<?php
declare(strict_types = 1);

use App\Domain\User\UserRepository;
use App\Domain\Job\JobRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\Job\DbJobRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class)
    ]);
    
    $containerBuilder->addDefinitions([
        JobRepository::class => \DI\autowire(DbJobRepository::class)
    ]);
};
