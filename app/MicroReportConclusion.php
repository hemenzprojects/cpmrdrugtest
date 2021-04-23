<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicroReportConclusion extends Model
{
    protected $fillable = ['title','default_conclusion','description','added_by_id'];

}
