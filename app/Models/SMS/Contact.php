<?php

namespace App\Models\SMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id', // unused as of now.
        'name',
        'phone',
        'email',
        'note',
    ];

    public function books() {
        return $this->belongsToMany( 'App\Models\SMS\Book', 'contact_books', 'contact_id', 'book_id' );
    }

}
