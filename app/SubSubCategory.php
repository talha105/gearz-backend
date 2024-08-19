<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['create_date' , 'proper_title'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

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

    public function sellers(){
        return $this->belongsToMany(User::class , 'seller_meta', 'sub_sub_category_id', 'user_id'  );
    }

}
