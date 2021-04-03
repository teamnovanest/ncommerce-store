<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use HasFactory;
    use SoftDeletes;



    /**
     * Get the products associated with this merchant.
     */
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
