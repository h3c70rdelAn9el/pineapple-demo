<?php

namespace App\Models;

use App\Models\User;
use App\Models\TherapySession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use Searchable;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use LogsActivity;
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
    ];

    public static $categories = [
        'Active',
        'Active - with intern',
        'Corporate',
        'Latin America',
        'Sexual Trauma',
	'Romanian clients'
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
}
