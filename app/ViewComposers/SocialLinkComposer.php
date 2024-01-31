<?php
namespace App\ViewComposers;

use Illuminate\View\View;
use App\Models\SocialLink;

class SocialLinkComposer
{
    public function compose(View $view)
    {
        $socialLinks = SocialLink::where('status', '1')->get();
        $view->with('socialLinks', $socialLinks);
    }
}