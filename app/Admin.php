<?php

namespace App;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'title','first_name','last_name','email','dept_id','user_type_id','dept_office_id','password','company','tell','tell_alt','street_address','house_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }
   
    public function getFullNameAttribute(){

        return $this->title.' '.$this->first_name.' '.$this->last_name;
    }

    public function type()
    {
        return $this->belongsTo('App\UserType', "user_type_id");
    }

    public function permissions()
    {
        return $this->type->permissions();
    }

    public function hasPermission($id)
    {
        $pm = $this->permissions()->where('admin_feature_types.feature_id',$id)->first()->pivot->enabled;

        if($pm == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
