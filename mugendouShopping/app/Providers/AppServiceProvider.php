<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

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
        // セッションの切り替え
        if (request()->is('admin*')) {
            config(['session.cookie' => config('session.cookie_admin')]);
        }

        if (request()->is('owner*')) {
            config(['session.cookie' => config('session.cookie_owner')]);
        }

        // 未認証時の遷移先
        Authenticate::redirectUsing(function () {
            if (Route::is('owner.*')) {
                return route('owner.login');
            } elseif (Route::is('admin.*')) {
                return route('admin.login');
            } else {
                return route('login');
            }
        });

        // 認証済みの遷移先
        RedirectIfAuthenticated::redirectUsing(function () {
            if (Route::is('owner.*')) {
                return route('owner.dashboard');
            } elseif (Route::is('admin.*')) {
                return route('admin.dashboard');
            } else {
                return route('dashboard');
            }
        });
    }
}
