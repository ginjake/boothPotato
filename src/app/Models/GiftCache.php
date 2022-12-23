<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCache extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'boothUrl',
        'categoryId',
        'image',
        'price',
        'title',
        'description',
    ];

    /**
     * カテゴリ
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }
}
