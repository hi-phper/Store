<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'member_id',
        'book_id',
        'amount',
        'total',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
