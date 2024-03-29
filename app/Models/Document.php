<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Document extends Model
{
    use HasFactory;
    use HasUuids;

    public function application()
    {
        return $this->belongsTo(Application::class, 'type_id', 'id');
    }
}
