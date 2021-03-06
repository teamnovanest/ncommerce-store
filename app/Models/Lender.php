<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lender extends Model
{
    use HasFactory;
    use SoftDeletes;

      /**
     * Get the lender associated with the an offer.
     */
    public function lenderOffering()
    {
        return $this->hasMany(lenderOffering::class, 'lender_organization_id');
    }
}
