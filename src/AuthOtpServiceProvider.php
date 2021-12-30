<?php
namespace Nta\AuthOtp;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Facades\Notification;
use Nta\AuthOtp\app\Channels\SMSChannel;
use Nta\AuthOtp\Commands\AuthOtpCommand;

class AuthOtpServiceProvider extends ServiceProvider {

    public function boot()
    {
        $source = realpath(__DIR__ . '/config/otp.php');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('otp.php'),
            ], 'otp-config');
        }

        $this->mergeConfigFrom($source, 'otp');

        $this->commands([
            AuthOtpCommand::class,
        ]);
        
        Notification::extend('SMS', function ($app) {
            return new SMSChannel();
        });
    }

    public function register()
    {

    }
}
