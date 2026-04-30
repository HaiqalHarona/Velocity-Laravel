<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Policies\ProjectRoleRestrictions;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Gate::policy(Project::class, ProjectRoleRestrictions::class);
	URL::forceScheme('https');
	URL::forceRootUrl(config('app.url'));
        if (str_contains(config('app.url'), 'https://')) {
        	$this->app['request']->server->set('HTTPS', 'on');
    	}

    }
}

