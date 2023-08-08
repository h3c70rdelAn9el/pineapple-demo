<?php

namespace App\Models;

use App\Models\User;
use App\Models\TherapySession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Client extends Model
{
    use Searchable;
    use HasFactory;
    use Notifiable;
    protected $fillable = [
        'client_code',
        'preferred_name',
        'legal_name',
        'sexual_orientation',
        'ethnic_group',
        'home_address_state',
        'health_coverage_provider',
        'health_coverage_number',
        'health_coverage_expiration',
        'previous_therapy',
        'possible_support_needed',
        'preferred_language',
        'additional_notes',
        'pronouns',
        'client_contribution',
        // 'user_id',
        'email',
        'phone',
        'contact_method',
        'status',
        'max_sessions',
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
