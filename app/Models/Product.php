<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'product_name',
        'product_details',
        'color',
        'category',
        'amount',
        'price',
        'discount',
        'dis_price',
        'remain',
        'image',
        'images',
    ];
}
