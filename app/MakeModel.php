<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MakeModel extends Model
{
    protected $table = 'models';
    protected $guarded = ['id'];
    protected $appends = ['create_date' , 'proper_title'];

    public function getCreateDateAttribute(){
        return $this->created_at->toDateString();
    }

    public function variants(){
        return $this->hasMany(Variant::class , 'model_id')->orderBy('title');
    }

    public function genre(){
        return $this->belongsTo(Genre::class);
    }


    public function getProperTitleAttribute($value){
        if(session('locale') == 'ar'){
            return $this->ar_title;
        }else{
            return $this->title;
        }
    }

}
