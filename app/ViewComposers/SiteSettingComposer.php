<?php
namespace App\ViewComposers;

use Illuminate\View\View;
use App\Models\SiteSetting;

class SiteSettingComposer
{
    public function compose(View $view)
    {
        $siteSettings = SiteSetting::whereIn('name', ['company_address', 'support_email', 'support_phone_no', 'whatsapp_number'])->pluck('value', 'name');
        $view->with('siteSettings', $siteSettings);
    }
}