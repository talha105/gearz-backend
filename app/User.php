<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Passport\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable , HasRoles , HasApiTokens;
    protected $appends = ['create_date' , 'is_admin' , 'is_super_admin'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    protected $guarded = ['id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function getCreateDateAttribute(){
        return $this->created_at ? $this->created_at->toDateString() : "";
    }
    public function getTotalCarsCountAttribute(){
        return Car::where('user_id' , $this->id)->count();
    }

    public function getIsSuperAdminAttribute(){
        return $this->type == 'super-admin' ? true : false;
    }

    public function getIsAdminAttribute(){
        return $this->type == 'admin' ? true : false;
    }

    public function likes(){
        return $this->belongsToMany(Like::class , 'likes' , 'user_id' , 'listing_id'  );
    }



    //
    public function getPivotsAttribute(){
        $pivots = [];
        $pivots['all'] = SellerMeta::where('user_id', $this->id)->get();
        $pivots['makes'] = array_map('intval', $pivots['all']->whereNotNull('make_id')->pluck('make_id')->toArray());
        $pivots['categories'] = array_map('intval', $pivots['all']->whereNotNull('category_id')->pluck('category_id')->toArray());
        $pivots['subCategories'] = array_map('intval', $pivots['all']->whereNotNull('sub_category_id')->pluck('sub_category_id')->toArray());
        $pivots['subSubCategories'] = array_map('intval', $pivots['all']->whereNotNull('sub_sub_category_id')->pluck('sub_sub_category_id')->toArray());
        return $pivots;
    }
    // For Selle specific
    public function categories(){
        return $this->belongsToMany(Category::class , 'seller_meta' , 'user_id' , 'category_id'  );
    }

    public function sub_categories(){
        return $this->belongsToMany(SubCategory::class , 'seller_meta' , 'user_id' , 'sub_category_id'  );
    }

    public function sub_sub_categories(){
        return $this->belongsToMany(SubSubCategory::class , 'seller_meta' , 'user_id' , 'sub_sub_category_id'  );
    }

    public function makes(){
        return $this->belongsToMany(Make::class , 'seller_meta' , 'user_id' , 'make_id'  );
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Listing::class,);
    }

    public function cars(){
        return $this->hasMany(Car::class);
    }



    public function getAverageRatingsAttribute(){

        $listings_ids = Listing::where('user_id' , $this->id)->pluck('id')->toArray();
        $reviews = Review::whereIn('listing_id' , $listings_ids)->get();
        if($reviews->count() > 0 ){

            $average_ratings = (float) number_format((float) array_sum($reviews->pluck('rating')->toArray())/$reviews->count() ,  1, '.', '');

            $this->average_ratings = $average_ratings;
            return $average_ratings ;
        }else{
            return 0;
        }
    }




    public function getCoordinatesAttribute(){

        if($this->seller){
            $url_coordinates_position = strpos($this->seller->address, '@')+1;
            $coordinates = [
                'longitude' => '0',
                'latitude' => '0'
            ];

            if ($url_coordinates_position != false) {
                $coordinates_string = substr($this->seller->address, $url_coordinates_position);
                $coordinates_array = explode(',', $coordinates_string);

                if (count($coordinates_array) >= 2) {
                    $longitude = $coordinates_array[0];
                    $latitude = $coordinates_array[1];

                    $coordinates = [
                        "longitude" => $longitude,
                        "latitude" => $latitude
                    ];
                }
                return $coordinates;
            }
        }else{
            return $coordinates = [
                'longitude' => '0',
                'latitude' => '0'
            ];

        }
    }

}
