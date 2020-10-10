<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Bookmark extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BookmarkCategory::class);
    }

    public function getShortenDescriptionAttribute(): string
    {
        return Str::limit($this->page_description, 80);
    }

    public function getCanNotDeleteOrEditAttribute(): bool
    {
        return $this->created_at < Carbon::now()->subDay();
    }
}