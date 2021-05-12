<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLenderSelection extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =
    ['user_id','lender_organization_id','city_id','region_id','affiliation','identification_type','identification_number','created_at'];

    protected $table = "user_lender_selections";

    public function user() {
        return $this->belongsTo(User::class);
    }
}
