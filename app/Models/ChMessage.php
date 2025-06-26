<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;

class ChMessage extends Model
{
    use UUID;

    protected $fillable = [
        'from_id',
        'to_id', 
        'body',
        'attachment',
        'seen'
    ];

    /**
     * Relationship with the sender (User)
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    /**
     * Relationship with the recipient (User)
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
