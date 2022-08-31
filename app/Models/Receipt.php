<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $fillable = [
        'user',
        'code',
        'billing',
        'mode',
        'tax_id',
        'customer',
        'send_address',
        'product',
        'discount',
        'dis_price',
    ];
}