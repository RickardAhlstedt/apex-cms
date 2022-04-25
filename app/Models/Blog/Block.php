<?php

namespace App\Models\Blog;

use App\Traits\HasLikes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory, HasLikes;

    protected $fillable = [
        'post_id',
        'name',
        'content',
        'visibility',
        'order',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

}
