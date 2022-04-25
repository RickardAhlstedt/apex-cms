<?php

namespace App\Models\Comments;

use App\Traits\HasLikes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory, HasLikes, HasComments;

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'content',
    ];

    public function user() {
        return $this->belongsTo( 'App\Models\User', 'user_id' );
    }

    // Create a response to a comment
    public function response( $iUserId, $sContent ) {
        $this->comments()->create( [
            'user_id' => $iUserId,
            'content' => $sContent,
            'commentable_id' => $this->id,
            'commentable_type' => get_class( $this ),
        ] );
    }
}
