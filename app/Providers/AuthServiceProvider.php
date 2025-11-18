<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Banner;
use App\Models\News;
use App\Models\User;
use App\Policies\BannerPolicy;
use App\Policies\NewsPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Highlight;
use App\Policies\HighlightPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        News::class => NewsPolicy::class,
        Highlight::class => HighlightPolicy::class,
        User::class  => UserPolicy::class,
        Banner::class => BannerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
