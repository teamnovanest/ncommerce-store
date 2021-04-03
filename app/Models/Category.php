<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];



    /**
     * Get the category associated with the product.
     */
    public function product()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Get the category associated with the product.
     */
    public function subcategory()
    {
        return $this->hasMany(subcategory::class, 'category_id');
    }
}
