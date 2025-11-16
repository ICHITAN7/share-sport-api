<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;
    public $timestamps = ["created_at"]; // Only created_at

    protected $fillable = [
        'news_id',
        'user_ip',
    ];

    /**
     * Get the news article this like belongs to.
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}