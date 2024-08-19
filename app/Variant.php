<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
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

    /**
     * Get the transmission that owns the Variant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transmission(){
        return $this->belongsTo(Transmission::class);
    }

    public function transmissions(){
        return $this->belongsToMany(Transmission::class);
    }


}
