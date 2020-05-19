<?php
declare(strict_types = 1);
namespace App\Application\Actions\Job;

use Psr\Http\Message\ResponseInterface as Response;

class GetJobsAction extends JobAction
{

    /**
     *
     * {@inheritdoc}
     *
     */
    protected function action(): Response
    {
        $jobId = (int) $this->resolveArg('id');
        
        // $jobs = $this->jobRepository->findPKs([$jobId]);
        
        $job = $this->jobRepository->findJobOfId($jobId);
        
        $job->setIsDeleted(false);
        $job->save();
        
        $templates = new \League\Plates\Engine(__DIR__ . '/../../../../views');
        
        $this->response->getBody()->write($templates->render('feed', [
            'jobs' => [
                $job
            ],
            'min' => true,
            'max' => $this->jobRepository->findLatest()
        ]));
        
        return $this->response;
    }
}
