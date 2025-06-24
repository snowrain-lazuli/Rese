<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'reserved_date',
        'reserved_time',
        'number_of_people',
        'visited'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function visitCode()
    {
        return $this->hasOne(VisitCode::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}