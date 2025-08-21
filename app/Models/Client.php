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
}
