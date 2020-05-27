<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use App\ITSub;

class Employee extends Model
{
    protected $module = 'user';
    protected $fillable = array(
        "code",
        "img",
        "fullName",
        "phone",
        "email",
        "sex",
        "passport",
        "dateRange",
        "address",
        "provincesId",
        "districtId",
        "wardId",
        "nation", // dân tộc
        "religion", // tôn giáo
        "positionsIds",
        "updated_at",
        "created_at"           
    );
}
