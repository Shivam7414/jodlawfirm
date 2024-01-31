<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ApiCredential;
use App\Models\SiteSetting;

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
        $apiCredentials = ApiCredential::whereIn('name', ['test_razorpay_key_id', 'test_razorpay_key_secret','live_razorpay_key_id', 'live_razorpay_key_secret', 'mail_from_name', 'mail_from_email_address', 'brevo_email_login', 'brevo_smtp_password'])->pluck('value', 'name');
        $siteSettings = SiteSetting::whereIn('name', ['site_name', 'favicon', 'logo', 'payment_mode_status'])->pluck('value', 'name');
        
        if($siteSettings->get('payment_mode_status') && $siteSettings->get('payment_mode_status') == 'live'){
            config(['services.razorpay.key' => $apiCredentials->get('live_razorpay_key_id')]);
            config(['services.razorpay.secret' => $apiCredentials->get('live_razorpay_key_secret')]);
        }else{
            config(['services.razorpay.key' => $apiCredentials->get('test_razorpay_key_id')]);
            config(['services.razorpay.secret' => $apiCredentials->get('test_razorpay_key_secret')]);
        }
        
        config(['mail.from.name' => $apiCredentials->get('mail_from_name')]);
        config(['mail.from.address' => $apiCredentials->get('mail_from_email_address')]);
        config(['mail.mailers.smtp.username' => $apiCredentials->get('brevo_email_login')]);
        config(['mail.mailers.smtp.password' => $apiCredentials->get('brevo_smtp_password')]);
        config(['app.name' => $siteSettings->get('site_name')]);
        config(['app.favicon' => $siteSettings->get('favicon')]);
        config(['app.logo' => $siteSettings->get('logo')]);
    }
}
