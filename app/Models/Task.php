<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Task extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed' => 'bool',
        'notified' => 'bool',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function routeNotificationForMail($notification)
    {
        return $this->user->email;
    }
}
