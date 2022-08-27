<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;
    protected $fillable = [
        'user',
        'code',
        'mode',
        'tax_id',
        'customer',
        'send_address',
        'product',
        'price',
    ];
}