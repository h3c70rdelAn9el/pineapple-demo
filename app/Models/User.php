<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Patient;
use App\Models\FileUpload;
use Laravel\Scout\Searchable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Searchable;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'license',
        'certificate',
        'expires_at',
        'bank_name',
        'account_number',
        'routing_number',
        'on_vacation',
        'clinical_license_verification_portal',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        //'on_vacation',
    ];

    protected $attributes = [
        'expires_at' => 0,
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function fileUploads()
    {
        return $this->hasMany(FileUpload::class);
    }
    /*
    public function getOnVacationAttribute()
    {
        return $this->attributes['on_vacation'] = $this->expires_at > now();
    }
    public function setOnVacationAttribute($value)
    {
        $this->attributes['on_vacation'] = $value;
    }
    */
}
