<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'order_id',
        'product_name',
        'quantity',
        'unit_price',
        'total_price',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'quantity' => 'int',
        'unit_price' => 'float',
        'total_price' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
