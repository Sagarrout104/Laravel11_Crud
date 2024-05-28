<?php

namespace App\Providers;

use App\Events\UserRegister;
use App\Listeners\SendWellcomeMail;
use App\Models\Post;
use App\Observers\PostObserver;
use App\Policies\PostPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();


        //register gate
        // Gate::define('create_post', function () {
        //     return Auth::user()->is_admin;
        // });

        // Gate::define('update_post', function () {
        //     return Auth::user()->is_admin;
        // });
        // Gate::define('delete_post', function () {
        //     return Auth::user()->is_admin;
        // });

        //register policy
        Gate::policy(
            Post::class,
            PostPolicy::class
        );

        //register observe model
        Post::observe(PostObserver::class);


        //register event listeneer
        // Event::listen(
        //     UserRegister::class,
        //     SendWellcomeMail::class
        // );
    }
}
