<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lift extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'weight',
        'reps',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
