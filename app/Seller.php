<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $guarded = ['id'];
    protected $appends = [
        'create_date',
        'description',
        'ar_description',
    ];
    protected $casts = ['docs' => 'array'];

    public function getCreateDateAttribute(){
        return $this->created_at->toDateString();
    }
    public function getDescriptionAttribute(){
        return $this->about;
    }
    public function getArDescriptionAttribute(){
        return $this->ar_about;
    }

}
