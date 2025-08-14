<?php

//this model is not used

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'first',
        // 'last',
        // 'email',
        // 'phone',
        // 'insurance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function therapySessions()
    {
        return $this->hasMany(TherapySession::class);
    }
}
