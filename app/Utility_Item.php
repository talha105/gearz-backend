<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utility_Item extends Model
{
    protected $table = 'utility_items';
    protected $guarded = ['id'];
    protected $appends = ['create_date' , 'proper_title'];
    
    public function getCreateDateAttribute(){
        return $this->created_at->toDateString();
    }
    public function getProperTitleAttribute($value){
        if(session('locale') == 'ar'){
            return $this->ar_title;
        }else{
            return $this->title;
        }
    }
}
