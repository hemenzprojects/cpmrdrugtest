<?php

namespace App;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cache;
use Carbon\Carbon;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'title','first_name','last_name','position','email','dept_id','user_type_id','dept_office_id','password','pin','company','tell','tell_alt','street_address','house_number',
       'load_analysis_options','efficacy_analysis_options','organolepticts_options','physicochemical_options','chemical_constituents_options'
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
   
    public function getEditTagAttribute()
    {
        return '<a data-toggle="tooltip" data-placement="auto" title="Edit Product" href="'. route('admin.sid.user.edit', ['id' => $this]) .'"> <i class="ik ik-edit-2"></i></a>';
    }

    public function getFullNameAttribute(){

        return $this->title.'. '.$this->first_name.' '.$this->last_name;
    }

    public function getAdminPrevilageAttribute(){

        if ($this->user_type_id == 2) {
           return"1st Approval";
        }
        if ($this->user_type_id == 1) {
            return"2nd Approval";
         } 
    }

    public function type()
    {
        return $this->belongsTo('App\UserType', "user_type_id");
    }
    public function dept()
    {
        return $this->belongsTo('App\Department', "dept_id");
    }

    public function deptOffice()
    {
        return $this->belongsTo('App\DeptOffice', "dept_office_id");
    }

    public function permissions()
    {
        return $this->type->permissions();
    }

    public function hasPermission($id)
    {
        $pm = $this->permissions()->where('admin_feature_types.admin_feature_id',$id)->first()->pivot->enabled;

        if($pm == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
 
    public function isOnline(){
        return Cache::has('user-is-online-'. $this->id);
    }

    public function dateExpiry(){

        $currentdate = Carbon::now()->toDateTimeString();
        $expirydate = "2022-08-29 09:40:48";

        if ( $expirydate > $currentdate) {
            return "you produt has expired";
        }
        
    }
}
