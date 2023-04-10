<?php

namespace App\Models;

use App\Models\User;
use App\Models\TherapySession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Client extends Model
{
    use Searchable;
    use HasFactory;
    protected $fillable = [

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
