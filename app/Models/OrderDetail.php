<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'orderdetail';
    public $timestamps = false;

    protected $primaryKey = 'id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id','product_id','order_id','quantity','amount','created_at'
    ];
    /**
     * Get the order that owns the orderDetail.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    /**
     * Get the product of OrderDetail
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
