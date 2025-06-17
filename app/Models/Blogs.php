<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
   protected $fillable = [
        'title',
        'text',
        'author',
    ];
}
