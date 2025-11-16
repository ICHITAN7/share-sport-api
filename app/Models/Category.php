<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;
    public $timestamps = ["created_at"]; // Only created_at

    protected $fillable = [
        'name',
        'slug',
        'icon_url',
    ];

    /**
     * Boot method to auto-generate slug.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get all news articles in this category.
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}