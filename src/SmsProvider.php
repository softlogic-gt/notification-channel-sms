<?php
namespace NotificationChannels\Sms;

use Illuminate\Support\ServiceProvider;

class SmsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(SmsChannel::class)
            ->needs(Sms::class)
            ->give(function () {
                return new Sms(
                    $this->app->make(SmsConfig::class)
                );
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(SmsConfig::class, function () {
            return new SmsConfig($this->app['config']['services.sms']);
        });
    }
}
