<?php
declare(strict_types = 1);
namespace App\Infrastructure\Persistence\Job;

use App\Domain\Job\Job;
use App\Domain\Job\JobNotFoundException;
use App\Domain\Job\JobRepository;
use App\Model\JobQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class DbJobRepository implements JobRepository
{

    /**
     *
     * @var Job[]
     */
    private $jobs;

    /**
     * DbJobRepository constructor.
     *
     * @param array|null $jobs            
     */
    public function __construct(array $jobs = null)
    {}

    /**
     *
     * {@inheritdoc}
     *
     */
    public function findAll($min = null): ?object
    {
        $query = JobQuery::create();
        if($min) $query = $query->filterById([
            'min' => $min + 1
        ]);
        return $query->filterByIsDeleted(false)->orderByPosted(Criteria::DESC)->paginate(1, 100);
    }
    
    public function findPKs(array $jobIds): ?object
    {
        $query = JobQuery::create();
        return $query->findPKs($jobIds);
    }
    
    public function findLatest(){
        $job = JobQuery::create()->orderById(Criteria::DESC)->findOne();
        if($job) return $job->getId();
        return null;
    }
    
    public function findAllSaved(){
        return JobQuery::create()->filterByIsSaved(true)->orderByPosted(Criteria::DESC);
    }
    
    public function findStats(){
        return [
            'total' => JobQuery::create()->count(),
            'saved' => JobQuery::create()->filterByIsSaved(true)->count(),
            'lasth' => JobQuery::create()->filterByPosted([
                'min' => time() - (60 * 60), 
                'max' => time()
            ])->count(),
            'lastd' => JobQuery::create()->filterByPosted([
                'min' => time() - (24 * 60 * 60), 
                'max' => time()
            ])->count(),
            'lastm' => JobQuery::create()->filterByPosted([
                'min' => time() - (30 * 24 * 60 * 60), 
                'max' => time()
            ])->count(),
            'new' => JobQuery::create()->filterByIsDeleted(false)->count()
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function findJobOfId(int $id)
    {
        $job = JobQuery::create()->findOneById($id);
        
        if(!$job) throw new JobNotFoundException();
        
        return $job;
    }
}
