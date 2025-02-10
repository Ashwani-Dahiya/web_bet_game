<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    use HasFactory;
    protected $table = "notifications";
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'date',
        'seen_status',
        'created_at',
        'updated_at',
    ];
}
