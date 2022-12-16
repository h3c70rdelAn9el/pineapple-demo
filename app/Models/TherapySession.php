<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TherapySession extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'total_bill', 'covered_cost', 'created_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
