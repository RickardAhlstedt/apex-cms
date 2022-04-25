<?php

namespace App\Traits;


trait HasComments {

    public function comments() {
        return $this->morphMany( 'App\Models\Comments\Comment', 'commentable' );
    }

    // Insert comment
    public function comment( $iUserId, $sContent ) {
        $this->comments()->create( [
            'user_id' => $iUserId,
            'content' => $sContent,
            'commentable_id' => $this->id,
            'commentable_type' => get_class( $this ),
        ] );
    }

    // Edit comment
    public function editComment( $iCommentId, $sContent ) {
        $this->comments()->where( 'id', $iCommentId )->update( [
            'content' => $sContent,
        ] );
    }

    // Remove comment
    public function removeComment( $iUserId, $iCommentId ) {
        $this->comments()->where( [
            ['user_id', '=', $iUserId],
            ['id', '=', $iCommentId]
        ] )->delete();
    }

}
