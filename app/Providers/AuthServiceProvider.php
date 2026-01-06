<?php

namespace App\Providers;

use App\Models\Game;
use App\Models\Console;
use App\Policies\GamePolicy;
use App\Policies\ConsolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Game::class => GamePolicy::class,
        Console::class => ConsolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
