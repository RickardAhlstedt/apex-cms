<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'parent_id',
        'sort',
        'name',
        'class',
        'href',
        'behavior',
        'prefix',
        'suffix',
    ];



}
