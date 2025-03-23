<?php

namespace App\Providers;

use App\Interfaces\Services\EmailMonitoringServiceInterface;
use App\Interfaces\Services\EmailServiceInterface;
use App\Interfaces\Services\PollInstanceServiceInterface;
use App\Services\EmailService;
use App\Services\MailgunEmailMonitoringService;
use App\Services\PollInstanceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
        $this->app->bind(PollInstanceServiceInterface::class, PollInstanceService::class);
        $this->app->bind(EmailMonitoringServiceInterface::class, MailgunEmailMonitoringService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
