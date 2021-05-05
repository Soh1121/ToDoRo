<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Task;
use App\Context;
use App\Project;
use App\Policies\TaskPolicy;
use App\Policies\ContextPolicy;
use App\Policies\ProjectPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
        Context::class => ContextPolicy::class,
        Project::class => ProjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
