<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['create_date'];

    public function getCreateDateAttribute(){
        return $this->created_at->toDateString();
    }

    public function getNameAttribute(){
        return
            ($this->make ? $this->make->title : '')
            . ' ' .
            ($this->model ? $this->model->title : '') ;
    }

    public function getArNameAttribute(){
        return
            ($this->make ? $this->make->ar_title : '')
            . ' ' .
            ($this->model ? $this->model->ar_title : '') ;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function model(){
        return $this->belongsTo(MakeModel::class);
    }
    public function make(){
        return $this->belongsTo(Make::class);
    }

    public function transmission(){
        return $this->belongsTo(Transmission::class, 'transmission_id');
    }

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function variant(){
        return $this->belongsTo(Variant::class);
    }


}
