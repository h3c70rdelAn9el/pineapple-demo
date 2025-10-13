<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use HasFactory;
    use LogsActivity;
    use Notifiable;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'client_code',
        'preferred_name',
        'legal_name',
        'sexual_orientation',
        'ethnic_group',
        'home_address_state',
        'home_address_country',
        'previous_therapy',
        'possible_support_needed',
        'preferred_language',
        'additional_notes',
        'pronouns',
        'client_contribution',
        'cost_per_session',
        // 'user_id',
        'email',
        'phone',
        'contact_method',
        'status',
        'max_sessions',
        'gender',
        'therapist_id',
        'user_id',
        'waitlist',
        'special_sessions',
        'category',
        'has_been_contacted',
    ];

    public static $categories = [
        'Active',
        'Active - with intern',
        'Corporate',
        'Latin America',
        'Romanian clients',
        'Support Groups',
        'Well Being',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function therapist()
    {
        return $this->belongsTo(User::class);
    }

    public function therapySessions()
    {
        return $this->hasMany(TherapySession::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll();
    }

    protected $attributes = [
        'status' => 'active',
        'waitlist' => 'null',
    ];

    /**
     * Get the effective cost per session for this client.
     * Returns the client's override value if set, otherwise the therapist's default value.
     */
    public function getEffectiveCostPerSession()
    {
        // If client has an override set, use that
        if ($this->cost_per_session !== null) {
            return $this->cost_per_session;
        }

        // Otherwise, use the therapist's default session_cost (user_id = 0 means no therapist)
        return ($this->user && $this->user_id > 0) ? $this->user->session_cost : null;
    }
}
