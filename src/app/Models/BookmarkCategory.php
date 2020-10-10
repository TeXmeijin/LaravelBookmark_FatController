<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookmarkCategory extends Model
{
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class, 'category_id');
    }
}