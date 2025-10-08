<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TherapySession extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = ['client_id', 'session_cost', 'client_contribution', 'remaining_client_contribution', 'created_at', 'attendance', 'notes'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function therapist()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $casts = [
        'special' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll();
    }
    // add delete function

}
