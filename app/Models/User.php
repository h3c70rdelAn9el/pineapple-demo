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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


// NOTE:  look at user-fields markup file for the fields that have been omitted from the user model

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Searchable;
    use LogsActivity;
    use SoftDeletes

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
        'account_name',
        'account_number',
        'routing_number',
        'on_vacation',
        'clinical_license_verification_portal',
        'title',
        'preferred_name',
        'intern',
        'supervisor_name',
        'street_address',
        'zip_code_postal_code',
        'iban_swift_code',
        'contract_signed',
        'all_documents',
        'full',
        'session_cost',
        'contact_for_promotionals',
        'number_of_potential_clients',
        'out_of_state_coaching',
        'file_upload',
        'w9',
        'headshot',
        'voided_cheque',
        'bio',
        'website',
        'quickbooks',
        'dropbox',
        'client_extensions',
        'notes',
        'covid_fundraise',
        'insurance',
        'signed_documents',
        'leah_signed',
        'space_for_new_clients',
        'admin',
        'county_town',
        'country',
        'state',
        'gender',
        'time_zone'
    ];

    // tried guarded and it didn't work
    // protected $guarded = [];

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
        'contact_for_promotionals' => 'boolean',
        'out_of_state_coaching' => 'boolean',
        'contract_signed' => 'boolean',
        'full' => 'boolean',
        'intern' => 'boolean',
        'client_extensions' => 'boolean',
        'covid_fundraise' => 'boolean',
        'insurance' => 'boolean',
        'signed_documents' => 'boolean',
        'leah_signed' => 'boolean',
        'admin' => 'boolean',
        'on_vacation' => 'boolean',
        'gender' => 'array',
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

    public function isAdmin()
    {
        return $this->admin === 1; // Assuming your admin field is 'admin' and holds the value 1 for admin users
    }

    public function isTherapist()
    {
        // Define the condition that determines whether a user is a therapist
        return $this->admin === 0; // Assuming 0 means the user is a therapist
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll();
    }
}
