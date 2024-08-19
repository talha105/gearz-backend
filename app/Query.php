<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['create_date'];
    
    public function getCreateDateAttribute(){
        return $this->created_at->toDateString();
    }
}
