<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['create_date', 'proper_title'];

    public function getCreateDateAttribute(){
        return $this->created_at->toDateString();
    }

    public function models(){
        return $this->hasMany(MakeModel::class , 'make_id')->orderBy('title');
    }
    public function getProperTitleAttribute($value){
        if(session('locale') == 'ar'){
            return $this->ar_title;
        }else{
            return $this->title;
        }
    }

    public function sellers(){
        return $this->belongsToMany(User::class , 'seller_meta', 'make_id', 'user_id'  );
    }
}
