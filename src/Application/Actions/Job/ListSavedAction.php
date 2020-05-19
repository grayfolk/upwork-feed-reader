<?php
declare(strict_types = 1);
namespace App\Application\Actions\Job;

use Psr\Http\Message\ResponseInterface as Response;

class ListSavedAction extends JobAction
{

    /**
     *
     * {@inheritdoc}
     *
     */
    protected function action(): Response
    {
        $jobs = $this->jobRepository->findAllSaved();
        
        $this->logger->info("Jobs list was viewed.");
        
        $templates = new \League\Plates\Engine(__DIR__ . '/../../../../views');
        
        $this->response->getBody()->write($templates->render('feed', [
            'jobs' => $jobs,
            'max' => $this->jobRepository->findLatest(),
            'min' => false,
            'stats' => $this->jobRepository->findStats(),
        ]));
        
        return $this->response;
    }
}
