<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminFeature extends Model
{
    //

    public function usertypes()
    {
        return $this->belongsToMany('App\UserType',"user_types");
    }
}
