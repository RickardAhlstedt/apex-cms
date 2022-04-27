<?php

namespace App\Models;

use App\Traits\CanRenderForm;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanRenderForm;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $formDictionary = [
        'name' => [
            'type' => 'string',
            'title' => 'Name',
            'required' => true,
        ],
        'email' => [
            'type' => 'string',
            'title' => 'Email',
            'required' => true,
        ],
        'password' => [
            'type' => 'password',
            'title' => 'Password',
            'required' => true,
        ],
        'password_confirm' => [
            'type' => 'password',
            'title' => 'Confirm Password',
            'required' => true,
        ],
        'role' => [
            'type' => 'select',
            'title' => 'Role',
            'values' => [
                'admin' => 'Admin',
                'user' => 'User',
            ],
            'required' => true,
            'label' => false,
        ],
        'submit' => [
            'type' => 'button',
            'title' => 'Submit',
            'value' => 'submit',
            'label' => false,
            'attributes' => [
                'class' => 'btn-primary'
            ]
        ]
    ];

    protected $formParams = [
        'method' => 'post',
        'labels' => true,
    ];

}
