<?php
declare(strict_types = 1);
namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\UserRepository;
use DI\Container;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{

    /**
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     *
     * @param Container $container            
     * @param LoggerInterface $logger            
     * @param UserRepository $userRepository            
     */
    public function __construct(Container $container, LoggerInterface $logger, UserRepository $userRepository)
    {
        parent::__construct($container, $logger);
        $this->userRepository = $userRepository;
    }
}
