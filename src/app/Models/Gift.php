<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'url',
        'priority',
        'memo',
        'completed',
    ];

    /**
     * キャッシュ
     */
    public function giftCache()
    {
        return $this->hasOne(GiftCache::class, 'url', 'url');
    }
}
