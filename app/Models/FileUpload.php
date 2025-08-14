<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FileUpload extends Model
{
    use HasFactory;
    use LogsActivity;
    use Notifiable;
    use Searchable;

    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'document_type',
        'region',
        'date',
        'note',
        'verified',
        'file_title',
        'pinned',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll();
    }

    public function url()
    {

        if (env('FILESYSTEM_DISK') == 's3') {
            $url = Storage::temporaryUrl(
                $this->file_path.$this->file_name,
                now()->addMinutes(5)
            );
        } else {
            $url = Storage::url($this->file_path.$this->file_name);
        }

        return $url;
    }

    protected $casts = [
        'verified' => 'boolean',
    ];
}
