<?php

namespace App\Models\Blog;

use App\Models\User;
use App\Traits\HasLikes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasLikes;

    protected $fillable = [
        'title',
        'slug',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'status',
        'author_id',
    ];

    public function blocks() {
        return $this->hasMany(Block::class);
    }

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function getBlocksInOrder() {
        return $this->blocks()->orderBy('order', 'asc')->get();
    }

}
