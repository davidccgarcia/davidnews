<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function getExcerpt()
    {
        return substr(strip_tags($this->body), 0, 150);
    }

    public function getReadingTime()
    {
        $wordCount = str_word_count(strip_tags($this->body));
        $readingTime = ceil($wordCount / 250);

        return $readingTime === 0 ? 1 : $readingTime;
    }
}
