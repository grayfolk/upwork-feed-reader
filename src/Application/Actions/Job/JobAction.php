<?php
declare(strict_types = 1);
namespace App\Application\Actions\Job;

use App\Application\Actions\Action;
use App\Domain\Job\JobRepository;
use DI\Container;
use Psr\Log\LoggerInterface;

abstract class JobAction extends Action
{

    /**
     *
     * @var UserRepository
     */
    protected $jobRepository;

    /**
     *
     * @param Container $container            
     * @param LoggerInterface $logger            
     * @param JobRepository $jobRepository            
     */
    public function __construct(Container $container, LoggerInterface $logger, JobRepository $jobRepository)
    {
        parent::__construct($container, $logger);
        $this->jobRepository = $jobRepository;
    }
}
