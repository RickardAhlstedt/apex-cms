<?php

return [
    'classes' => [
        'comment' => App\Models\Comments\Comment::class,
        'user' => App\Models\User::class,
    ],
    'decorator' => 'mdbootstrap',
    'decorators' => [
        'mdbootstrap' => [
            'label' => [
                'class' => 'form-label',
                'position' => 'after', // before or after input
            ],
            'wrapper' => [
                'enabled' => true,
                'wrapper_class' => 'form-outline mb-3',
            ],
            'button' => [
                'class' => 'btn'
            ],
            'file' => [
                'class' => 'form-control',
            ],
            'select' => [
                'class' => 'select'
            ],
            'password' => [
                'class' => 'form-control',
            ],
            'textarea' => [
                'class' => 'form-control',
            ],
            'text' => [
                'class' => 'form-control',
            ],
            'template' => '<div class="{wrapper_class}">{before}{input}{after}</div>'
        ]
    ]
];
