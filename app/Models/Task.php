<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function hasTag(int $tagId): bool
    {
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }
}
