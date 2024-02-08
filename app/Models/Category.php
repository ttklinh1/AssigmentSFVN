<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Category extends Model
{
    public $timestamps = false;
    protected $table = 'category';
    protected $primaryKey = 'id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];
    /**
     * Get the product associated with the category.
     */
    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
