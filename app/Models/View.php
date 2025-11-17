<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class View extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;
    public $timestamps = false; // Manually handled by 'viewed_at'

    // Set the CREATED_AT constant to 'viewed_at'
    const CREATED_AT = 'viewed_at';

    protected $fillable = [
        'viewable_id',
        'viewable_type',
        'user_ip',
    ];

    /**
     * Get the news article this view belongs to.
     */
    public function viewable()
    {
        return $this->morphTo();
    }
}
