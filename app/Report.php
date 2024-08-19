<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['create_date'];

    public function getCreateDateAttribute(){
        return $this->created_at->toDateString();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function listing(){
        return $this->belongsTo(Listing::class);
    }


}
