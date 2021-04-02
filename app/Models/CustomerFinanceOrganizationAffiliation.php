<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerFinanceOrganizationAffiliation extends Model
{
    use HasFactory;
    use SoftDeletes;

  /**
     * Get the user associated with the this finance/lending org.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
