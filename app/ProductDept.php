<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDept extends Model
{   protected $fillable = ['product_id','dept_id','status','quantity','received_by','received_at','distributed_by','delivered_by'];

    

    public function receivedBy(){
        return $this->belongsTo('App\Admin', 'received_by');
    }
    public function distributedBy(){
        return $this->belongsTo('App\Admin', 'distributed_by');
    }

    public function deliveredBy(){
        return $this->belongsTo('App\Admin', 'delivered_by');
    }

    public function getDistributedByAdminAttribute(){
        if ($this->distributedBy){
            return $this->distributedBy->full_name;
        }
    }
    public function getReceivedByAdminAttribute(){
        if ($this->status === 1) {
            return 'Null';
         }else{
            return $this->receivedBy->full_name;
        }
    }
    public function getDeliveredByAdminAttribute(){
        if ($this->status === 1) {
            return 'Null';
         }else{
            return $this->deliveredBy->full_name;
        }
    }

  }
