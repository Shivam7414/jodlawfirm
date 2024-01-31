<?php
namespace App\ViewComposers;

use App\Models\PageCategory;
use Illuminate\View\View;

class PageComposer
{
    public function compose(View $view)
    {
        $pageCategories = PageCategory::with('pages')->get();
        $view->with('pageCategories', $pageCategories);
    }
}