<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $with = ['users'];
    protected $table = 'visits';
    protected $fillable = ['ip', 'user_id'];


    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
