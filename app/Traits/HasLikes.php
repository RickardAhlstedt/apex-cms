<?php

namespace App\Traits;


trait HasLikes {

    public function likes() {
        return $this->morphMany( 'App\Models\Likes\Like', 'likeable' );
    }

    public function canLike( $iUserId ) {
        return $this->likes()->where( 'user_id', $iUserId )->count() == 0;
    }

    public function like( $iUserId ) {
        if( $this->likes()->where( [
            ['user_id', '=', $iUserId],
            ['likeable_id', '=', $this->id],
            ['likeable_type', '=', get_class( $this )]
        ] )->exists() ) {
            return false;
        }
        $this->likes()->create( [
            'user_id' => $iUserId,
        ] );
        $this->update( ['likes' => $this->likes()->count()] );
    }

    public function getLikes() {
        return $this->likes()->count();
    }

    public function unlike( $iUserId ) {
        $this->likes()->where( 'user_id', $iUserId )->delete();
        $this->update( ['likes' => $this->likes()->count()] );
    }

    public function isLikedBy( $iUserId ) {
        return $this->likes()->where( 'user_id', $iUserId )->exists();
    }

}
