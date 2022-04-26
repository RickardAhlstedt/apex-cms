# FormRender

## Using the form-renderer
To use the form-render, your model will need to include the trait `CanRenderForm`, and implement the following parameters:

```php

protected $formDictionary = [
    ...
];

protected $formParams = [
    ...
];

```

## $formDictionary
The following types are supported:
- `string` - Creates a text input
- `password` - Creates a password input
- `array|select` - Creates a select with the given values, doesn't support default value as of now
- `textarea|text` - Creates a textarea
- `button` - Creates a button with the given text
- `file|upload` - Creates a file upload field

### Example:
```php
[
    'text' => [
        'title' => 'Description',
        'type' => 'text', // Or textarea
        'label' => true,
        'required' => true,
        'value' => 'Value inside the textarea'
        'attributes' => [
            'class' => ''
            'placeholder' => ''
            'cols' => 8,
            'rows' => 4
        ]
    ],
    'upload' => [
        'type' => 'file', // Or upload
        'label' => false,
        'required' => false,
        'title' => 'Upload a file',
        'attributes' => [
            'class' => '',
            'multiple' => true,
            'accept' => 'image/*'
        ]
    ],
    'selectable' => [
        'type' => 'select', // Or array
        'label' => false,
        'required' => false,
        'title' => 'Select a value',
        'values' => [
            'value1' => 'Value 1',
            'value2' => 'Value 2',
            ...
        ]
    ],
    // Any entry with the key 'user_id' will be replaced by the current user id
    'user_id' => [
        'type' => 'hidden'
    ],
    'honeypot' => [
        'type' => 'hidden',
        'value' => ''
    ]
    'username' => [
        'type' => 'string',
        'title' => 'Username',
    ],
    'password' => [
        'type' => 'password',
        'title' => 'Password',
    ],
    'submit' => [
        'type' => 'button',
        'value' => 'submit',
        'title' => 'Create content',
        'label' => false,
        'attributes' => [
            'class' => 'btn-primary'
        ]
    ]
]
```

## $formParams
The following parameters are supported:
- `method` - The method to use for the form, defaults to `POST`
- `action` - The action to use for the form, defaults to `/`
- `class` - The class to use for the form, defaults to `form-horizontal`
- `enctype` - The enctype to use for the form, defaults to `multipart/form-data`
- `autocomplete' - The autocomplete to use for the form, defaults to `off`
- `labels` - Whether to show labels or not, defaults to `true`
- `token` - Whether to include a CSRF token or not, defaults to `true`
- `csrf` - The CSRF token to use, defaults to the function `csrf_token()`

### Example:
```php
[
    'method' => 'post',
    'action' => '',
    'enctype' => '',
    'labels' => true,
]
```

## Blade-directive
The directive for rendering a form is `@form( model )`.  

**Please make sure that your models that has the trait `CanRenderForm` has the `formDictionary` and `formParams` parameters set, and is set up under `config/form.php` under the key `classes`.**

## Configuration
For the blade-directive to be able to get the right dictionaries and params, the model-class needs to be defined in the config-file.
### Classes:
```php
'classes' => [
    'comment' => App\Models\Comments\Comment::class,
    'post' => App\Models\Posts\Post::class,
    'user' => App\Models\Users\User::class,
]
```

### Decorator:
A decorator is used to style the form after according to your css-styles. By default a decorator for mdbootstrap is used.

To change the decorator, please define a new decorator under the key `decorators` in the config-file, and then set `decorator` to the name of the decorator you want to use.
When changing the decorator, you will need to clear the cache for the config and for the views, as the forms are compiled together with the view-file.

To add a new decorator, please copy the mdbootstrap-decorator and modify it to your needs.
Keep in mind that keys in your decorator should be the same as the default decorator. Otherwise it will break your layout.

## Adding new fields
To add a new field, you will need to add it to the form-engine under `App\Render\Form.php`, and in the switch-case in the function `render()` you will need to add a new case. After that, write your supporting functions.  
After all that, you will need to add the field to the decorators.  
And finally, clear the config-cache and view-cache for the changes to take effect.
