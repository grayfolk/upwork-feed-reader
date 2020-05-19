<?php
declare(strict_types = 1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Actions\Job\ListJobsAction;
use App\Application\Actions\Job\ListSavedAction;
use App\Application\Actions\Job\GetJobsAction;
use App\Application\Actions\Job\SaveJobsAction;
use App\Application\Actions\Job\DeleteJobsAction;

return function (App $app) {
    $container = $app->getContainer();
    
    $app->get('/', ListJobsAction::class);
    
    $app->get('/saved', ListSavedAction::class);
    
    $app->group('/jobs', function (Group $group) use($container) {
        $group->get('', ListJobsAction::class);
        $group->get('/{id}', GetJobsAction::class);
        $group->post('/{id}', SaveJobsAction::class);
        $group->delete('/{id}', DeleteJobsAction::class);
    });
    
    /*
     * $app->group('/users', function (Group $group) use($container) {
     * $group->get('', ListUsersAction::class);
     * $group->get('/{id}', ViewUserAction::class);
     * });
     */
};
