<?php
declare(strict_types = 1);
namespace App\Application\Actions\Job;

use Psr\Http\Message\ResponseInterface as Response;

class ListJobsAction extends JobAction
{

    /**
     *
     * {@inheritdoc}
     *
     */
    protected function action(): Response
    {
        $jobs = $this->jobRepository->findAll($this->request->getQueryParams()['id'] ?? null);

        $this->logger->info("Jobs list was viewed.");
        
        $templates = new \League\Plates\Engine(__DIR__ . '/../../../../views');

        $this->response->getBody()->write($templates->render('feed', [
            'jobs' => $jobs,
            'min' => $this->request->getQueryParams()['id'] ?? false,
            'max' => $this->jobRepository->findLatest(),
            'stats' => $this->jobRepository->findStats(),
        ]));
        
        return $this->response;
    }
}
