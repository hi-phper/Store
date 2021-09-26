<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'member_id',
        'address',
        'total',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'order_books')
            ->withPivot('amount', 'price', 'total');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'member_id', 'id', 'user');
    }
}
