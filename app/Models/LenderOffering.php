<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LenderOffering extends Model
{
    use HasFactory;
    use SoftDeletes;


     /**
     * Get the lender associated with the an lenderOffering.
     */
    public function lender()
    {
        return $this->belongsTo(Lender::class,'lender_organization_id');
    }
}
