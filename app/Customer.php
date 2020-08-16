<?php

namespace App;

use App\Notifications\CustomerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Auth;
class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','email', 'password','first_name','last_name','tell','tell_alt','street_address','house_number','added_by_id'
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
        $this->notify(new CustomerResetPassword($token));
    }

    public function admin(){
        return $this->belongsTo('App\Admin','added_by_id');
    }

    public function product()
    {
        return $this->hasMany('App\product');
    }
    
    public function getCreatedByAttribute(){

        if ($this->admin){
           return $this->admin->first_name.'-'.$this->admin->last_name ;
        }
    }
    public function getNameAttribute(){
        return $this->title.' '.$this->first_name.'-'.$this->last_name ;
     }

     public function getEditTagAttribute()
    {
        return '<a data-toggle="tooltip" data-placement="auto" title="Edit Product" href="'. route('admin.sid.customer.edit', ['id' => $this]) .'"> <i class="ik ik-edit-2"></i></a>';
    }
    public function getShowTagAttribute()
    {
        return '<a data-toggle="tooltip" data-placement="auto" title="View Product" href="'. route('admin.sid.customer.show', ['id' => $this]) .'"><i class="ik ik-eye"></i></a>';
    }

}
