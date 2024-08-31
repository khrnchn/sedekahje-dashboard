<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'qr_content',
        'type',
        'city',
        'state',
        'supported_methods',
        'user_id',
    ];

    protected $casts = [
        'supported_methods' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
