<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_title',
        'secondary_title',
        'image',
        'content',
        'hashtags',
    ];

    // Cast hashtags to array
    protected $casts = [
        'hashtags' => 'array',
    ];

    // Optional: accessor to get comma-separated hashtags
    public function getHashtagsStringAttribute()
    {
        return $this->hashtags ? implode(', ', $this->hashtags) : '';
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
