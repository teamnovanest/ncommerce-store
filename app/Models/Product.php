<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];


    /**
     * Get the brand associated with the product.
     */
    // public function brand()
    // {
    //     return $this->hasOne(BrandOptions::class,'brand_id','id');
    // }
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
        //return number_format($price / 100,2);
        return $price / 100;
    }

    public function setSellingPriceAttribute($price)
    {
        $this->attributes['discount_price'] = $price * 100;
    }

    public function getDiscountPriceAttribute($price)
    {
        //return number_format($price / 100,2);
        return $price / 100;
    }

    public function setDiscountPriceAttribute($price)
    {
        $this->attributes['discount_price'] = $price * 100;
    }

     /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        if (!app()->environment('production')){
            return 'dev_VESTASHI';
        }else{
            return 'prod_VESTASHI';
        }
    }

        /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize the data array...

        return $array;
    }
}
