<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'area', 'genre', 'description', 'image_path', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class); // roleの実装方式によって削除
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'shop_id', 'user_id')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}