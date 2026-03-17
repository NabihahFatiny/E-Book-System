<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'cover_image',
        'title',
        'author',
        'publisher',
        'category',
        'isbn',
        'description',
        'status',
    ];
}
