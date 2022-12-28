<?php

namespace App\Models\SMS;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description'
    ];

    public function owner() {
        return $this->hasOne( User::class, 'id', 'user_id' );
    }

    public function contacts() {
        return $this->belongsToMany(Contact::class, 'contact_books', 'book_id', 'contact_id');
    }


}
