<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Models\Message;
use App\Models\User;

class Ticket extends Model
{
    use HasFactory, Searchable;

    function messages()
    {
        return $this->hasMany(Message::class, 'ticket_id', 'id');
    }

    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getStatusBadgeAttribute()
    {
        $status = $this->status;
        if ($status == 'open') {
            return '<span class="badge badge-success">Open</span>';
        } else if ($status == 'closed') {
            return '<span class="badge badge-danger">Closed</span>';
        } else if($status == 'on_hold') {
            return '<span class="badge badge-warning">On Hold</span>';
        }else if($status == 'resolved') {
            return '<span class="badge badge-info">Resolved</span>';
        }else if($status == 'in_progress') {
            return '<span class="badge badge-primary">In Progress</span>';
        }else if($status == 'reopened') {
            return '<span class="badge badge-secondary">Reopened</span>';
        }else{
            return '<span class="badge badge-dark">Unknown</span>';
        }
    }
}
