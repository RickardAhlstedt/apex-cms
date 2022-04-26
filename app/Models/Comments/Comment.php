<?php

namespace App\Models\Comments;

use App\Traits\HasComments;
use App\Traits\HasLikes;
use App\Traits\CanRenderForm;
use Illuminate\Contracts\Auth\Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory, HasLikes, HasComments, CanRenderForm;

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'content',
    ];

    protected $formDictionary = [
        'content' => [
            'title' => 'Comment',
            'type' => 'textarea',
            'required' => true,
            'attributes' => [
                'rows' => 4,
                'cols' => 20,
                'class' => ''
            ]
        ],
        'garbage' => [
            'title' => 'File',
            'type' => 'file',
            'required' => false,
            'label' => false,
        ],
        'complaint_dpt' => [
            'type' => 'array',
            'required' => false,
            'label' => false,
            'values' => [
                '1' => 'Complaint',
                '2' => 'Department',
            ],
        ],
        'user_id' => [
            'type' => 'hidden',
        ],
        'usr' => [
            'type' => 'string',
            'title' => 'Username',
        ],
        'pwd' => [
            'type' => 'password',
            'title' => 'Password',
            'attributes' => [
            ]
        ],
        'submit' => [
            'type' => 'button',
            'value' => 'submit',
            'title' => 'Submit comment',
            'label' => false,
            'attributes' => [
                'class' => 'btn-primary'
            ]
        ],
    ];

    protected $formParams = [
        'method' => 'post',
        'action' => '',
        'enctype' => '',
        'labels' => true,
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
