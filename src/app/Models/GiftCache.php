<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCache extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'image',
        'title',
        'description',
    ];

}
