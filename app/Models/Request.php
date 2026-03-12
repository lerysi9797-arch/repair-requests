<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'phone',
        'address',
        'problem_text',
        'status',
        'assigned_to'
    ];

    public function master()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
