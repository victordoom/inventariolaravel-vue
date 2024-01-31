<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disc extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'album',
        'artist',
        'gender',
        'year',
        'picturealbum',
    ];
}
