<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Model
{
    use HasFactory;
    use Searchable;
    use Notifiable;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'document_type',
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
                $this->file_path . $this->file_name,
                now()->addMinutes(5)
            );
         } else {
             $url = Storage::url($this->file_path . $this->file_name);
         }

        return $url;
    }

    protected $casts = [
        'verified' => 'boolean',
    ];
}
