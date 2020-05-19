<?php
namespace App\Cli;

use Unirest;
use PHPHtmlParser\Dom;
use App\Model\Job;
use App\Model\JobQuery;
use App\Model\Base\SkillQuery;
use App\Model\JobSkill;
use App\Model\Base\JobSkillQuery;
use App\Model\Skill;

class Parser
{

    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function parse()
    {
        $response = Unirest\Request::get($this->url);
        
        if ($response->code != 200)
            die();
        
        $xml = new \SimpleXMLElement($response->body);
        $result = $xml->xpath('//item');
        
        foreach ($result as $node) {
            $data = $this->process($node);
            
            $job = JobQuery::create()->findOneByLink($data['link']) ?  : new Job();
            
            $job->setTitle($data['title']);
            $job->setLink($data['link']);
            $job->setDescription($data['description']);
            $job->setBudget($data['budget'] ? preg_replace('~\D+~', '', $data['budget']) : null);
            $job->setCategory($data['category']);
            $job->setCountry($data['country']);
            $job->setPosted(date('Y-m-d H:i:s', strtotime($data['date'])));
            $job->save();
            
            JobSkillQuery::create()->filterByJobId($job->getId())->delete();
            
            if ($data['skills']) {
                foreach ($data['skills'] as $skill) {
                    $s = SkillQuery::create()->findOneByTitle($skill) ?  : new Skill();
                    $s->setTitle($skill);
                    $s->save();
                    
                    $r = new JobSkill();
                    $r->setJobId($job->getId());
                    $r->setSkillId($s->getId());
                    $r->save();
                }
            }
        }
    }

    private function process($node)
    {
        $title = $node->xpath('title')[0]->__toString();
        $link = $node->xpath('link')[0]->__toString();
        $description = $node->xpath('description')[0]->__toString();
        $date = $node->xpath('pubDate')[0]->__toString();
        
        $budget = $category = $country = '';
        $skills = [];
        
        preg_match('/<b>Budget<\/b>:(.*)/', $description, $budgetRaw);
        
        if (isset($budgetRaw[1])) {
            $budget = substr($budgetRaw[1], 2);
        }
        
        preg_match('/<b>Category<\/b>:(.*)/', $description, $categoryRaw);
        
        if (isset($categoryRaw[1])) {
            $category = trim($categoryRaw[1]);
        }
        
        preg_match('/<b>Country<\/b>:(.*)/', $description, $countryRaw);
        
        if (isset($countryRaw[1])) {
            $country = trim($countryRaw[1]);
        }
        
        preg_match('/<b>Skills<\/b>:(.*)<br/', $description, $skillsRaw);
        
        if (isset($skillsRaw[1])) {
            $skills = explode(',', $skillsRaw[1]);
            
            array_walk($skills, function (&$item) {
                return $item = trim($item);
            });
        }
        
        if (stripos($description, '<b>Budget</b>') !== false) {
            $description = substr($description, 0, stripos($description, '<b>Budget</b>'));
        } elseif (stripos($description, '<b>Posted On</b>') !== false) {
            $description = substr($description, 0, stripos($description, '<b>Posted On</b>'));
        }
        
        $dom = new Dom();
        $dom->loadStr($description);
        
        foreach ($dom->find('a') as &$a) {
            if (stripos($a->href, '?source=rss') !== false) {
                $a->setAttribute('href', '#');
                $a->delete();
                unset($a);
            }
        }
        
        return [
            'title' => $title,
            'link' => $link,
            'description' => trim($description, '<br><br />'),
            'budget' => $budget,
            'category' => $category,
            'country' => $country,
            'skills' => $skills,
            'date' => $date
        ];
    }
}
