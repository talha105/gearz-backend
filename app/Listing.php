<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $casts = [
        'active' => 'integer',
    ];

    protected $guarded = ['id'];
    protected $appends = ['create_date' , 'main_image' , 'average_ratings' , 'total_likes' , 'total_reviews' , 'block_ids' , 'proper_title' , 'proper_description'];

    public function getCreateDateAttribute(){
        return $this->created_at->toDateString();
    }

    public function getGarageNameAttribute(){
        if($this->user_id) {
            $user = User::with('seller')->find($this->user_id);
            return $user->seller->garage_name;
        }else{
            return "Gearz";
        }
    }

    public function getArGarageNameAttribute(){
        if($this->user_id) {
            $user = User::with('seller')->find($this->user_id);
            return $user->seller->ar_garage_name;
        }else{
            return "گیرز";
        }
    }


    public function getMainImageAttribute(){
        if($this->images->count() > 0){
            return $this->images->first()->name;
        }else{
            return false;
        }
    }


    public function getRelationPivotsAttribute(){
        $relations = [];
        $relations['categories'] = array_map('intval', DB::table('category_listings')->where('listing_id', $this->id)->pluck('category_id')->toArray());
        $relations['subCategories'] = array_map('intval', DB::table('sub_category_listings')->where('listing_id', $this->id)->pluck('sub_category_id')->toArray());
        $relations['subSubCategories'] = array_map('intval', DB::table('listing_sub_sub_category')->where('listing_id', $this->id)->pluck('sub_sub_category_id')->toArray());
        $relations['genres'] = array_map('intval', DB::table('genre_listings')->where('listing_id', $this->id)->pluck('genre_id')->toArray());
        $relations['models'] = array_map('intval', DB::table('listing_model')->where('listing_id', $this->id)->pluck('model_id')->toArray());
        $relations['makes'] = array_map('intval', DB::table('listing_make')->where('listing_id', $this->id)->pluck('make_id')->toArray());
        $relations['variants'] = array_map('intval', DB::table('listing_variant')->where('listing_id', $this->id)->pluck('variant_id')->toArray());
        return $relations;
    }


    // public function getSellerDetailsAttribute(){
    //     return $this->seller();
    // }

    public function getAlreadyReviewedAttribute(){
        $count = 0;
        if(auth()->user() && auth()->user()->id){
            $count = Review::
            where('listing_id' , $this->id)
            ->where('user_id' , auth()->user()->id)
            ->count();
        }
        return $count ? true : false;
    }


    public function getAverageRatingsAttribute(){

        $reviews = Review::where('listing_id' , $this->id)->get();
        if($reviews->count() > 0 ){

            // $average_ratings = (float) number_format((float) array_sum($reviews->pluck('rating')->toArray())/$reviews->count() ,  1, '.', '');
 
            // $this->average_ratings = $average_ratings;
            // return $average_ratings ;


           // // $average_ratings = (int)number_format((float) array_sum($reviews->pluck('rating')->toArray())/$reviews->count() ,  1, '.', '');

$average_ratings = Review::where('listing_id', $this->id)->where('status',1)->avg('rating');
$this->average_ratings = $average_ratings;
return number_format((float) $average_ratings,1);


            // return array_sum($reviews->pluck('rating')->toArray())/$reviews->count();
        }else{
            return 0;
        }
    }

    public function getTotalReviewsAttribute(){
        return Review::where('listing_id' , $this->id)->count();
        // return $this->reviews->count();
    }
    public function getTotalLikesAttribute(){
        return $this->likes->count();
    }


    public function likes(){
        return $this->belongsToMany(User::class , 'likes' ,'listing_id' , 'user_id'  )->withTimestamps();
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function all_reviews(){
        return $this->hasMany(Review::class)->with('user')->orderBy('created_at' , 'desc');
    }
    public function reviews(){
        return $this->hasMany(Review::class)->where('status' , 1)->with('user')->orderBy('created_at' , 'desc');
    }

    public function listing_reviews(){
        return $this->hasMany(Review::class)->where('status' , 1)->orderBy('created_at' , 'desc');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_listings')->withTimestamps();
    }
    public function sub_categories(){
        return $this->belongsToMany(SubCategory::class, 'sub_category_listings')->withTimestamps();
    }

    public function sub_sub_categories(){
        return $this->belongsToMany(SubSubCategory::class)->withTimestamps();
    }

    public function makes(){
        return $this->belongsToMany(Make::class)->withTimestamps();
    }


    public function models(){
        return $this->belongsToMany(MakeModel::class , 'listing_model' , 'listing_id' , 'model_id')->withTimestamps();
    }

    public function variants(){
        return $this->belongsToMany(Variant::class , 'listing_variant' , 'listing_id' , 'variant_id')->withTimestamps();
    }



    public function user(){
        return $this->belongsTo(User::class);
    }
    public function seller(){
        return $this->belongsTo(User::class , 'user_id')->withDefault([
            'id' => 0,
            'name' => 'Admin',
            'type' => 'Admin',
        ]);
    }
    public function genres(){
        return $this->belongsToMany(Genre::class, 'genre_listings')->withTimestamps();
    }

    public function blocks(){
        return $this->belongsToMany(DisplayBlock::class , 'block_listing' ,'listing_id' , 'block_id'  )->withTimestamps();
    }
    public function getBlockIdsAttribute(){
        return $this->blocks->pluck('id')->toArray();
    }

    public function scopeApproved($query){
        return $query->where('status' , 'approved');
    }
    public function scopeActive($query){
        return $query->where('active' , 1);
    }

    public function getProperTitleAttribute($value){
        if(session('locale') == 'ar'){
            return $this->ar_title;
        }else{
            return $this->title;
        }
    }

    public function getProperDescriptionAttribute($value){
        if(session('locale') == 'ar'){
            return $this->ar_description;
        }else{
            return $this->description;
        }
    }

    public function getCoordinatesAttribute(){
        $url_coordinates_position = strpos($this->address, '@')+1;
        $coordinates = [
            'longitude' => '0',
            'latitude' => '0'
        ];

        if ($url_coordinates_position != false) {
            $coordinates_string = substr($this->address, $url_coordinates_position);
            $coordinates_array = explode(',', $coordinates_string);

            if (count($coordinates_array) >= 2) {
                $latitude = $coordinates_array[0];
                $longitude = $coordinates_array[1];
                // $longitude = $coordinates_array[0];
                // $latitude = $coordinates_array[1];

                $coordinates = [
                    "longitude" => $longitude,
                    "latitude" => $latitude
                ];
            }
            return $coordinates;
        }
    }

    // public function checkLike($user_id){
    //     if($request->user_id && $list->likes->find($request->user_id) ){
    //         $list->liked = true;
    //     }else{
    //         $list->liked = false;
    //     }
    // }


}
