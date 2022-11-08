<?php

namespace App\Models;

use App\Models\User;
use App\Models\TherapySession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
