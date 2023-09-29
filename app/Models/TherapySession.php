<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class TherapySession extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['client_id', 'session_cost', 'client_contribution', 'created_at', 'attendance', 'notes'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
