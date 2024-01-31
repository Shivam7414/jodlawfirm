<?php

namespace App\Providers;

use App\ViewComposers\SiteSettingComposer;
use App\ViewComposers\SocialLinkComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\ViewComposers\PageComposer;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('frontend.layouts.partials.footer', SiteSettingComposer::class);
        View::composer('frontend.layouts.partials.footer', SocialLinkComposer::class);
        View::composer('frontend.layouts.partials.footer', PageComposer::class);
    }
}
?>