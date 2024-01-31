<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PageCategory;

class Page extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(PageCategory::class, 'page_category_id', 'id');
    }
}
