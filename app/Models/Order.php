<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id','total','created_at', 'customer_name'
    ];

    /**
     * Get the orderDetail associated with the Order.
     */
    public function orderDetail(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
