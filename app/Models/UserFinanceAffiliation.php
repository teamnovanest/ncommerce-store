<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFinanceAffiliation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =
    ['user_id','lender_organization_id','identification_type','identification_number','created_at'];

    protected $table = "user_finance_affiliations";

    public function user() {
        return $this->belongsTo(User::class);
    }
}
