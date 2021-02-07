<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    //
    public function permissions()
    {
        return $this->belongsToMany('App\AdminFeature',"admin_feature_types")->withPivot('enabled','updated_at');
    }
}
