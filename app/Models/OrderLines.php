<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLines extends Model
{
    protected $fillable = ['order_code','sku','quantity','comment',];
    use HasFactory;
}
