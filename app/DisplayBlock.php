<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisplayBlock extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['create_date', 'proper_title' ];

    public function getCreateDateAttribute(){
        return $this->created_at->toDateString();
    }

    public function getProperTitleAttribute($value){

        // dd( session('locale') , session()->get('locale') ,\App::getLocale());

        if(session('locale') == 'ar'){
            return $this->ar_title;
        }else{
            return $this->title;
        }
    }

    public function getAllListingsCountAttribute(){
        return $this->listings;
    }



    public function scopeActive($query){
        return $query->where('status' , 1);
    }


    public function listings(){
        return $this->belongsToMany(Listing::class , 'block_listing' , 'block_id' ,'listing_id');
    }
    public function home_listings(){
        return $this->belongsToMany(Listing::class , 'block_listing' , 'block_id' ,'listing_id')->where('status' , 'approved')->where('active' , 1)->orderBy('created_at' , 'desc');
    }


    public function scopeCustomSort($query){
        return $query->orderBy('sort' , 'asc');
    }
}
