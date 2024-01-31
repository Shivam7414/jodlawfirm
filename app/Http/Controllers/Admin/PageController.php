<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageCategory;
use Illuminate\Support\Str;
use App\Models\Page;

class PageController extends Controller
{
    public function index() {
        $pages = Page::with('category')->get();
        return view('admin.page.index', compact('pages'));
    }
    public function edit(Request $request, $id = null) {
        $categories = PageCategory::all();
        if($id){
            $page = Page::find($id);
        }else{
            $page = new Page();
        }

        return view('admin.page.edit', compact('page', 'categories'));
    }
    public function store(Request $request) {
        if($request->id) {
            $page = Page::find($request->id);
        }else{
            $page = new Page();
        }

        $page->name = $request->name;
        $page->slug = str_replace('-', '_', Str::slug($request->name));
        $page->page_category_id = $request->page_category_id;
        $page->content = $request->content;
        $page->status = $request->status;
        $page->save();

        return redirect('admin/page/index')->with('success', 'Page saved successfully');
    }

    public function delete(Request $request) {
        $page = Page::find($request->id);
        $page->delete();

        return back()->with('success', 'Page deleted successfully');
    }

    public function editCategory(Request $request, $id = null){
        $pageCategories = PageCategory::all();

        return view('admin.page.modal.edit_category', compact('pageCategories'));
    }
    public function storeCategory(Request $request){
        $categoryIds = $request->id;
        $categoryNames = $request->name;
    
        foreach ($categoryNames as $index => $categoryName) {
            if ($categoryIds && $categoryIds[$index]) {
                $category = PageCategory::find($categoryIds[$index]);
                $category->name = $categoryName;
            } else {
                $category = new PageCategory;
                $category->name = $categoryName;
            }
    
            $category->save();
        }
    
        return back()->with('success', 'Categories saved successfully');
    }

    public function deleteCategory(Request $request) {
        $pageCategory = PageCategory::find($request->category_id);
        $pageCategory->delete();

        return response()->json(['success' => true]);
    }
}
