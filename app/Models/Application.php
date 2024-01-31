<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\ApplicationSetting;
use App\Models\Transaction;
use App\Models\Document;
class Application extends Model
{
    use HasFactory;
    use HasUuids;

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function applicationSetting(){
        return $this->hasOne(ApplicationSetting::class, 'type', 'type');
    }

    public function documents(){
        return $this->hasMany(Document::class, 'type_id', 'id');
    }

    public function userDocuments(){
        return $this->hasMany(Document::class, 'type_id', 'id')->whereNot('type', 'admin_document');
    }
    
    public function adminDocuments(){
        return $this->hasMany(Document::class, 'type_id', 'id')->where('type', 'admin_document');
    }

    public function transaction(){
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }
}
