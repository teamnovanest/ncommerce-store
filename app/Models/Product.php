<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];


    /**
     * Get the category associated with the product.
     */
    public function category()
    {
        return $this->hasOne(Category::class);
    }

    /**
     * Get the subcategory associated with the product.
     */
    public function subcategory()
    {
        return $this->hasOne(Subcategory::class);
    }

     /**
     * Get the merchant associated with the product.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }


    public function getSellingPriceAttribute($price)
    {
        return $price / 100;
    }

    public function setSellingPriceAttribute($price)
    {
        $this->attributes['selling_price'] = $price * 100;
    }
}
