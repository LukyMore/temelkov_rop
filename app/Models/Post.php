<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Conner\Likeable\Likeable;

class Post extends Model
{
    use HasFactory;
    use Likeable;
    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];
}
