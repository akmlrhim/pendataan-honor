<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visits';
    protected $fillable = ['ip', 'user_id', 'browser'];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
