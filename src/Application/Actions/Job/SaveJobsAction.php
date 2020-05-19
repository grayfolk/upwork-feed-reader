<?php
declare(strict_types = 1);
namespace App\Application\Actions\Job;

use Psr\Http\Message\ResponseInterface as Response;

class SaveJobsAction extends JobAction
{

    /**
     *
     * {@inheritdoc}
     *
     */
    protected function action(): Response
    {
        $jobId = (int) $this->resolveArg('id');
        
        $job = $this->jobRepository->findJobOfId($jobId);
        
        $job->setIsSaved($job->getIsSaved() ? false : true);
        $job->save();
        
        $this->logger->info("Job of id `${jobId}` was saved/unsaved.");
        
        return $this->respondWithData([]);
    }
}
