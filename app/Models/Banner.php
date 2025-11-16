<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;
    public $timestamps = ["created_at"]; // Only created_at

    protected $fillable = [
        'title',
        'image_url',
        'link_url',
        'position',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];
}