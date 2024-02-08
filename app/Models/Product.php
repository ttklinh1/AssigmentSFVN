<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id';
    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id','name','unit','price','category_id'
    ];
    /**
     * Get the Category that owns the Product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
