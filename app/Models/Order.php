<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'client_order_code',
        'order_comments',
        'dropshipping',
        'send_to_name',
        'send_to_address',
        'send_to_zipcode',
        'send_to_village_neighborhood',
        'send_to_city',
        'send_to_phone_number',
        'send_to_person',
        'transport_code',
        'delivery_note_type',
        'packaging_type',
        'order_code_nav',
        'serial_number',
        'shipping',
        'status_nav',
        'status_text',
        'tracking_number',
        'status',
        'user',
        'deleted_at'
    ];
    use HasFactory;
}
