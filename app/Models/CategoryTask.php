<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryTask extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'status',
        'date_from',
        'date_to',
    ];

    /**
     * Get the user that owns the CategoryTask
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
