<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

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
        'file_title'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
