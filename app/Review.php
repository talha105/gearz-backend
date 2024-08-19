<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
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

    public function getDetailsAttribute()
    {
        $user = \DB::table('users')->where('id', $this->user_id)->first();
        $listing = \DB::table('listings')->where('id', $this->listing_id)->first();
        $listing && $garage = \DB::table('users')->where('id', $listing->user_id)->first();

        return [
            'userName' => $user ? $user->name : "",
            'userEmail' => $user ? $user->email : "",
            'listingTitle' => $listing ? $listing->title : "",
            'garageName' => isset($garage) ? $garage->name : "",
        ];
    }
}
