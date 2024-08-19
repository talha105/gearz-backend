<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['create_date', 'proper_title'];

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


    public function sub_categories(){
        return $this->hasMany(SubCategory::class)->orderBy('title');
    }
    public function features(){
        return $this->hasMany(Feature::class)->orderBy('title');
    }
    public function makes(){
        return $this->hasMany(Make::class)->orderBy('title');
    }



    public function sellers(){
        return $this->belongsToMany(User::class , 'seller_meta', 'category_id', 'user_id'  );
    }


}
