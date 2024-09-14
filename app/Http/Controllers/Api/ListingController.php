<?php

namespace App\Http\Controllers\Api;

use App\Car;
use App\Make;
use stdClass;
use App\Genre;
use App\Image;
use App\Review;
use App\Listing;
use App\Category;
use App\MakeModel;
use App\SearchQuery;
use App\DisplayBlock;
use App\Jobs\SendEmail;
use App\SubSubCategory;
use App\Intervention_Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as I_Image;
use phpDocumentor\Reflection\Types\Null_;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(auth()->user());

        $listings = Listing::with('user')->latest()->paginate(20);

        return response()->json(['success' => true , 'listings' => $listings ]);
        // if( auth()->user()->is_super_admin || auth()->user()->hasPermissionTo('listings') ){
        // }else{
        //     return response()->json(['success' => false ] , 401);
        // }

    }


    public function searchListings()
    {

        $listings = Listing::
        // withAvg('reviews', 'rating')
        // withAvg('rating as your_alias_here', 'reviews')
        with( 'user', 'models', 'variants' , 'categories' , 'sub_categories' , 'sub_sub_categories' , 'makes','images','genres')

        ->when( request('seller_id') , function($query){
            $query->where('user_id' , request('seller_id') );
        })
        ->when( request('year') , function($query){
            $query->where('start_year' , '<=' , request('year') )->where('end_year' , '>=' , request('year') );
        })
        ->when( (request('active') && request('active') == "Active") , function($query){
            $query->where('active' , 1 );
        })
        ->when( (request('active') && request('active') == "Inactive") , function($query){
            $query->where('active' , 0 );
        })
        // ->when( request('status') , function($query){
        //     $query->where('status' , request('status') );
        // })
        ->when( request('min_price') , function($query){
            $query->where('price' , '>=' , request('min_price') );
        })
        ->when( request('max_price') , function($query){
            $query->where('price' , '<=' , request('max_price') );
        })
        ->when( request('city') , function($query){
            $query->where('city' , 'like' , '%' . request('city') . '%' );
        })


        ->when( request('search') , function($query){
            $query->where(function($query){
                $query->where('title' , 'like' , '%' . request('search') . '%' );
                $query->orWhere('ar_title' , 'like' , '%' . request('search') . '%' );
                $query->orWhere('description' , 'like' , '%' . request('search') . '%' );
                $query->orWhere('ar_description' , 'like' , '%' . request('search') . '%' );
            });
        })
        ->when( request('user') , function($query){
            $query->whereHas('user' , function($query){
                $query->where('name' , 'like' , '%' . request('user') . '%' );
            });
        })

        ->when( request('categories') && array_filter(request('categories')) , function($query){

            $query->whereHas('categories' , function($q){
                $q->whereIn('category_id' , array_filter(request('categories')));
            });
        })
        ->when( request('sub_categories') && array_filter(request('sub_categories')) , function($query){
            $query->whereHas('sub_categories' , function($q){
                $q->whereIn('sub_category_id' , array_filter(request('sub_categories')));
            });
        })
        ->when( request('sub_sub_categories') && array_filter(request('sub_sub_categories')) , function($query){
            $query->whereHas('sub_sub_categories' , function($q){
                $q->whereIn('sub_sub_category_id' , array_filter(request('sub_sub_categories')));
            });
        })
        ->when( request('makes') && array_filter(request('makes')) , function($query){
            $query->whereHas('makes' , function($q){
                $q->whereIn('make_id' , array_filter(request('makes')));
            });
        })
        ->when( request('models') && array_filter(request('models')) , function($query){
            $query->whereHas('models' , function($q){
                $q->whereIn('model_id' , array_filter(request('models')));
            });
        })
        ->when( request('variants') && array_filter(request('variants')) , function($query){
            $query->whereHas('variants' , function($q){
                $q->whereIn('variant_id' , array_filter(request('variants')));
            });
        })

        ->when(request('sort') , function($query){
            $query->orderBy('created_at' , ((request('sort') == "Newest") ? "desc" : "asc") );
        } )
        ->when( request('ratings') , function($query){
            $query->whereHas('listing_reviews' , function($q){
                // $q->havingRaw('AVG(rating) >= '. (float)(request('ratings')));
                // $q->havingRaw('AVG(rating) >= '. (float)(request('ratings')));
                // $q->havingRaw('AVG(rating) >= '.(float)(request('ratings')));
                  $rating = (float)(request('ratings'));

                  
                    $q->havingRaw('AVG(rating) >= ?', [$rating]);



            });
        })

        // ->when( request('ratings') , function($query){

            // ->select(['products.*',
            // DB::raw('AVG(reviews.rating) as ratings_average')
            // ])
            // ->where('ratings_average', request('ratings'));

            // $query->whereHas('listing_reviews' , function($q){
            //     // $q->where(function ($sub) {
            //     //     return $sub->selectRaw('round(avg(reviews.rating)) as ratings_average');
            //     //             //    ->from('reviews')
            //     //             //    ->whereColumn('items.id', 'reviews.reviewable_id')
            //     //             //    ->where('reviews.reviewable_type', 'App\\Models\\Item');
            //     // }, '>=', request('ratings'));
            //         // dump(request('ratings'), $q->get());
            //     $q
            //     ->havingRaw('ROUND(AVG(rating)) = '. (int)(request('ratings')));
            //         // dump($q->toSQL());

            //     // ->selectRaw('AVG(reviews.rating) as ratings_average')
            //     // ->groupBy('restaurants.id')

            //     // $q->selectRaw('avg(reviews.rating) as ratings_average == ' . request('ratings'));
            //     // $q->whereRaw('avg(reviews.rating) as ratings_average == ' . request('ratings'));
            // });
        // })
        // ->when( request('ratings') , function($query){
        //     $query->whereHas('listing_reviews' , function($q){
        //         $q->where('rating' , request('ratings'));
        //     });
        // })


        // Price
        // Year
        // ->toSql();

        // dd($listings);
        ->paginate(20);

        $listings->append(['relation_pivots', 'garage_name', 'ar_garage_name']);

        // self::storeSearch($listings);

        return response()->json(['success' => true , 'listingsCount' => $listings->count() , 'listings' => $listings ]);

    }


    public static function storeSearch($listings)
    {
        return SearchQuery::create([
            'user_id' => auth()->user()->id,
            'search_query' => request()->all(),
            'response_listings' => $listings->pluck('id')->toArray(),
        ]);
    }



    public function allLostings()
    {
        $listings = Listing::with('user')->latest()->get();
        return response()->json(['success' => true , 'listings' => $listings ]);

    }
    public function getListingDetails(Request $request)
    {
        $listing = Listing::with('user' , 'features' , 'images' , 'categories' , 'makes' , 'models','genres')->find($request->listing_id);

        if($request->user_id && $listing->all_reviews->where( 'user_id' , $request->user_id)->first()){
            $listing->already_reviewed = true;
        }else{
            $listing->already_reviewed = false;
        }
        return response()->json(['success' => true , 'listing' => $listing ]);

    }
    public function sellerListings($id)
    {
        $listings = Listing::where('user_id' , $id)->latest()->get();

        return response()->json(['success' => true , 'listings' => $listings ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default


        $listing = Listing::create([

            'user_id' => $request->is_admin && !$request->user_id ? 0 : $request->user_id,
            'status' => $request->status ? $request->status : 'pending',

            'title' => $request->title,
            'ar_title' => $request->ar_title,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'description' => $request->description,
            // 'ar_description' => $request->ar_description,
            'ar_description' => $request->ar_description ? $request->ar_description : $tr->setSource('en')->setTarget('ar')->translate($request->description),

            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,

            'price' => $request->price,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,

            'active' => $request->active ? 1 : 0,
            'approved' => $request->is_admin ? 1 : 0,
        ]);

        if($listing) {
            self::attachRelationToIDsArray($listing);
        }


        if($listing && $listing->seller){
            $subject = "Gearz";
            $body = "Your new listing request is pending approval
            <br>
            Thank you, Gearz
            ";
            dispatch(new SendEmail($listing->seller , $subject , $body ));
        }

        if(isset($request->subSubCategories)) {
            self::copySubCategoryImage($listing, $request->subSubCategories );
        }

        if($listing){
            return response()->json(['success' => true , 'message' => 'Listing added Successfully' , 'listing' => $listing ]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }


    }

    public static function attachRelationToIDsArray($listing){


        $relations = [
            'models' => 'models',
            'makes' => 'makes',
            'categories' => 'categories',
            'sub_categories' => 'subCategories',
            'sub_sub_categories' => 'subSubCategories',
            'genres' => 'genres',
            'variants' => 'variants',
            'transmissions'=>'transmissions'
        ];
        foreach ($relations as $key => $value) {
            if(request($value)){
                $listing->$key()->sync(request($value));
            }
        }
    }
    // public static function attachRelationToIDsArray($listing) {
    //     $relations = [
    //         'models' => 'models',
    //         'makes' => 'makes',
    //         'categories' => 'categories',
    //         'sub_categories' => 'subCategories',
    //         'sub_sub_categories' => 'subSubCategories',
    //         'genres' => 'genres',
    //         'variants' => 'variants',
    //     ];
        
    //     foreach ($relations as $key => $value) {
    //         if (request($value)) {
    //             $values = request($value);
    
    //             // Ensure $values is an array and take the first element
    //             $singleValue = is_array($values) ? $values[0] : $values;
    
    //             if ($key === 'makes' || $key === 'models') {
    //                 $singleValue = intval($singleValue); // Convert to integer
    //             }
    
    //             $listing->$key()->sync($singleValue);
    //         }
    //     }
    // }
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $listing = Listing::with(
            'categories',
            'sub_categories',
            'sub_sub_categories',
            'models',
            'makes',
            'images',
            'seller',
            'seller.seller'
        )->find($id);
        // $listing = Listing::with('categories'  , 'categories.sub_categories' , 'categories.sub_categories.sub_categories' , 'sub_category.sub_categories' , 'sub_sub_categories' , 'makes' , 'makes.models' , 'models' , 'images' , 'genres' , 'seller' , 'seller.seller')->find($id);

        $listing->append([ 'garage_name', 'ar_garage_name', 'already_reviewed', 'relation_pivots', 'coordinates']);

        return response()->json(['success' => true , 'listing' => $listing ]);
    }

    public function getListingImages($id)
    {
        $images = Image::where('listing_id', $id)->get();
        return response()->json(['success' => true , 'images' => $images ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $listing = Listing::find($id);

        $listing->user_id = $request->is_admin && !$request->user_id ? 0 : $request->user_id;

        $listing->title = $request->title;
        $listing->description = $request->description;

        $listing->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        // $listing->ar_description = $request->ar_description;
        $listing->ar_description = $request->ar_description ? $request->ar_description : $tr->setSource('en')->setTarget('ar')->translate($request->description);


        $listing->phone = $request->phone;
        $listing->address = $request->address;

        $listing->city = $request->city;

        $listing->start_year = $request->start_year;
        $listing->end_year = $request->end_year;
        $listing->price = $request->price;

        $listing->active = $request->active ? 1 : 0;
        $listing->approved = $request->is_admin ? 1 : 0;


        if($listing) {
            self::attachRelationToIDsArray($listing);
        }

        if($listing->save()){
            return response()->json(['success' => true , 'message' => 'Listing updated Successfully' , 'listing' => $listing ]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }

    }


    public static function copySubCategoryImage($listing, $subIds){
        $categories = SubSubCategory::
            where('image', '<>', '')
            ->whereIn('id', $subIds)->get();

        foreach ($categories as $key => $category) {

            $path = public_path() . '/storage/sub-categories/' . $category->image;
            $file = I_Image::make($path);

            $ext = $file->extension;
            $name =  uniqid(true) . rand(99, 999) . "." . $ext;

            $file->save(public_path().'/storage/listings/' . $name , 100);

            Image::create([
                'listing_id' => $listing->id,
                'name' => $name,
            ]);
        }

    }



    public function uploadImages(Request $request){

        // dd($request->all());

        // $image = $request->image;
        // $name =  uniqid(true) . rand(99, 999) . "." . $image->getClientOriginalExtension();
        // $image->storeAs('/public/listings', $name);



        $file = Intervention_Image::imageResize($request->image);

        $ext = $request->image->getClientOriginalExtension();
        // $name =  uniqid(true) . rand(99, 999) . "." . $ext;
        $name =  uniqid(true) . rand(99, 999) . ".webp";

        $file->save(public_path().'/storage/listings/' . $name , 100);

        // // Get image
        // $img = request()->file('image');
        // // Minify image
        // $resizedImage = I_Image::make($img)->encode('webp', 100); // put this in a variable
        // // use a unique filename
        // $filename = $img->hashName();
        // // Store image in uploads folder
        // Storage::disk('public_storage')->put('listings/'.$filename, $resizedImage->__toString());

        $new_image = Image::create([
            'listing_id' => $request->listing_id,
            'name' => $name,
        ]);

        return response()->json(['status' => 'Image Stored' ,'image' => $new_image ]);
    }


    public function deleteImages(Request $request){

        // dd($request->all());

        $image = Image::find($request->image_id);

        if($image && file_exists('storage/listings/'.$image->name)){
            File::delete('storage/listings/'.$image->name);
        }
        $image->delete();
        return response()->json(['status' => 'Image delete' ]);
        // }else{
            // return response()->json(['status' => 'failed' , 'message' => 'Image Not Found'] , 422);
        // }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $listing = Listing::find($id);

        // $listing->reviews()->delete();

        if($listing && $listing->delete()){
            return response()->json(['status' => 'listing deleted'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'listing Not Found'] , 422);
        }
    }

    public function updateListingStatus(Request $request)
    {
        // dd($request->all());
        $listing = Listing::find($request->listing_id);
        $listing->status = $request->status;
        if($listing->save()){

            if($listing && $listing->status == 'approved' && $listing->seller){
                $subject = "Gearz";
                $body = "Congrats your listing has been approved
                <br>
                Thank you, Gearz
                ";
                dispatch(new SendEmail($listing->seller , $subject , $body ));
            }

            if($listing && $listing->status == 'rejected' && $listing->seller){
                $subject = "Gearz";
                $body = "We regret to inform you that you’re listing as be denied please review our policy for more info or contact us
                <br>
                Thank you, Gearz
                ";
                dispatch(new SendEmail($listing->seller , $subject , $body ));
            }


            return response()->json(['status' => 'Listing updated'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'Unexpected error happend'] , 422);
        }
    }


    public function getListingReviews(Request $request)
    {
        $reviews = Review::where('listing_id' , request('listing_id'))
        ->latest()->paginate(15);

        if($reviews){
            return response()->json(['status' => true , 'reviews' => $reviews  ]);
        }else{
            return response()->json(['status' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }

    public function getSellerReviews($user_id = null)
    {
        $reviews = Review::
            whereHas('listing', function($query) use ($user_id){
                $query->where('listings.user_id', $user_id );
            })
            ->latest()
            ->paginate(15);

        if($reviews){
            return response()->json(['status' => true , 'reviews' => $reviews  ]);
        }else{
            return response()->json(['status' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }

    public function likeListing(Request $request)
    {
        $listing = Listing::find($request->listing_id);
        // dd($listing->likes->find($request->user_id) , $request->user_id , $request->listing_id  );
        if($request->user_id && $listing->likes()->find($request->user_id) ){
            // $like = Like::create([
            //     'user_id' => $request->user_id,
            //     'listing_id' => $request->listing_id,
            // ]);
            $like = $listing->likes()->detach([$request->user_id]);
            $listing->liked = false;
        }else{
            $like = $listing->likes()->attach([$request->user_id]);
            $listing->liked = true;
        }

        if($listing){
            return response()->json(['status' => true , 'listing' => $listing , 'likes' => $listing->likes->count()  ]);
        }else{
            return response()->json(['status' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }


    public function listingsCategories(Request $request){


        $category = '';
        if($request->category_id){
            $category = Category::find($request->category_id);
        }
        $block = '';
        if($request->block_id){
            $block = DisplayBlock::find($request->block_id);
        }
        $model = '';
        if($request->model_id){
            $model = MakeModel::find($request->model_id);
        }
        $make = '';
        if($request->make_id){
            $make = Make::find($request->make_id);
        }
        $genre = '';
        if($request->genre_id){
            $genre = Genre::find($request->genre_id);
        }
        if($request->genre_id == 'all'){
            $genre = new stdClass();
            $genre->id = 'all';
            if(session('locale') == 'ar'){
                $genre->proper_title = 'جميع الأنواع';
            }else{
                $genre->proper_title = 'All Genres';
            }
        }

        if($category || $block || $genre){
            return response()->json(['status' => true , 'category' => $category , 'genre' => $genre , 'make' => $make , 'model' => $model , 'block' => $block  ]);
        }else{
            return response()->json(['status' => false , 'message' => 'Unexpected error happend'] , 422);
        }


    }
    public function categoryListings(Request $request)
    {
        $block_listing_ids = [];
        if($request->block_id){
            $block = DisplayBlock::find($request->block_id);
            $block_listing_ids = $block->listings->pluck('id')->toArray();
        }
        $listing = Listing::with('category','model','make','images')->approved()->active()

        ->when( request('block_id') && isset($block_listing_ids) , function($query) use ($block_listing_ids){
            $query->whereIn('id' , $block_listing_ids);
        })
        ->when( request('category_id') , function($query){
            $query->where('category_id' , request('category_id') );
        })
        ->when( request('genre') && request('genre') != 'all' , function($query){
            $query->where('genre_id' , request('genre') );
        })
        ->when( request('genre') && request('genre') == 'all' , function($query){
            // $query->where('genre_id' , request('genre') );
        })
        ->when( request('model_id') , function($query){
            $query->where('model_id' , request('model_id') );
        })
        ->when( request('make_id') , function($query){
            $query->where('make_id' , request('make_id') );
        })
        ->when(request('sort_by') && !request('sort_by_price') , function($query){
            $query->orderBy('created_at' , request('sort_by') );
        } )
        ->when(request('sort_by_price') , function($query){
            $query->orderBy('day_price' , request('sort_by_price') );
        } )

        ->paginate(5);
        // })->get();
        // $listing = Listing::with('category','model','make','images')
        // ->where('category_id' , $request->category_id )

        // ->when( request('model_id') , function($query){
        //     $query->where('model_id' , request('model_id') );
        // })
        // ->when( request('make_id') , function($query){
        //     $query->where('make_id' , request('make_id') );
        // })->paginate(3);
        // // })->get();
        foreach($listing as $list){
            if($request->user_id && $list->likes->find($request->user_id) ){
                // dd($list->likes->find($request->user_id));
                $list->liked = true;
            }else{
                $list->liked = false;
            }
        }


        if($listing){
            return response()->json(['status' => true , 'listing' => $listing  ]);
        }else{
            return response()->json(['status' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }












    public function getReleventListing()
    {
        try{

            if(request('car_id')){
                $model_ids = [Car::find(request('car_id'))->model_id];
                $make_ids = [Car::find(request('car_id'))->make_id];
                $variant_ids = [Car::find(request('car_id'))->variant_id];
            }else{
                $model_ids = auth()->user()->cars->pluck('model_id')->toArray();
                $make_ids = auth()->user()->cars->pluck('make_id')->toArray();
                $variant_ids = auth()->user()->cars->pluck('variant_id')->toArray();
            }

            // dump($model_ids, $make_ids, $variant_ids);

            // dd(request()->all());

            $listings = Listing::
                when(request('category_ids') , function($query){
                    $query->whereHas('categories' , function($qu){
                        return $qu->whereIn('categories.id' , request('category_ids'));
                    });
                })->
                when(request('sub_category_ids') , function($query){
                    $query->whereHas('sub_categories' , function($qu){
                        return $qu->whereIn('sub_categories.id' , request('sub_category_ids'));
                    });
                })->
                when(request('sub_sub_category_ids') , function($query){
                    $query->whereHas('sub_sub_categories' , function($qu){
                        return $qu->whereIn('sub_sub_categories.id' , request('sub_sub_category_ids'));
                    });
                })->
                whereHas('models' , function($query) use ($model_ids){
                    return $query->whereIn('models.id' , $model_ids);
                } )->
                whereHas('makes' , function($query) use ($make_ids){
                    return $query->whereIn('makes.id' , $make_ids);
                } )->
                whereHas('variants' , function($query) use ($variant_ids){
                    return $query->whereIn('variants.id' , $variant_ids);
                } )->
                paginate(10);

                $listings->append(['garage_name', 'ar_garage_name']);

                return response()->json(['status' => true , 'listings' => $listings  ]);

            }catch(\Exception $e){
                return response()->json([
                    'status' => false ,
                    'message' => $e->getMessage()
                ] , 422);
            }

    }



    public function getReleventCategoryListing($cat_id , $car_id = NULL)
    {
        if($car_id){
            $model_ids = Car::find($car_id)->pluck('model_id');
            $make_ids = Car::find($car_id)->pluck('make_id');
        }else{
            $model_ids = auth()->user()->cars->pluck('model_id');
            $make_ids = auth()->user()->cars->pluck('make_id');
        }

        $listings = Listing::
            // when($model_ids , function($q) use ($model_ids) {
            //     $q->whereHas('models' , function($query) use ($model_ids){
            //         return $query->whereIn('model_id' , $model_ids->toArray());
            //     } );
            // })->
            // when($model_ids , function($q) use ($make_ids) {
            //     $q->whereHas('makes' , function($query) use ($make_ids){
            //         return $query->whereIn('make_id' , $make_ids->toArray());
            //     });
            // })->
            // whereExact(['category_id'] , $cat_id)->

            whereHas('categories' , function($q) use ($cat_id){
                $q->where('category_id' , $cat_id);
            })
            ->paginate(10);

        $listings->append(['garage_name', 'ar_garage_name']);

        if($listings){
            return response()->json(['status' => true , 'listings' => $listings  ]);
        }else{
            return response()->json(['status' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }

    public function getFeaturedListings($slug = null)
    {
        try{
            if($slug) {
                $block = DisplayBlock::where('title', $slug)->first();
                $listings = $block->home_listings;
            }else{
                $listings = Listing::whereHas('blocks')->latest()->get();
            }
            $listings->append(['garage_name', 'ar_garage_name']);
            return response()->json(['status' => true , 'listings' => $listings  ]);
        }catch(\Exception $e){
            return response()->json(['status' => false , 'message' => $e->getMessage()] , 422);
        }

    }

    public function getSellerListings($id = null)
    {
        try{

            $listings = Listing::
                when( request('category_ids') , function($query){
                    $query->whereHas('categories' , function($q){
                        $q->whereIn('category_id' , request('category_ids'));
                    });
                })
                ->when( request('sub_category_ids') , function($query){
                    $query->whereHas('sub_categories' , function($q){
                        $q->whereIn('sub_category_id' , request('sub_category_ids'));
                    });
                })
                ->when( request('sub_sub_category_ids') , function($query){
                    $query->whereHas('sub_sub_categories' , function($q){
                        $q->whereIn('sub_sub_category_id' , request('sub_sub_category_ids'));
                    });
                })
                ->when($id , function($query) use ($id) {
                    $query->where('user_id' , $id);
                })->latest()->paginate(15);

            return response()->json([
                'status' => true,
                'listings' => $listings
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false ,
                'message' => $e->getMessage()
            ] , 422);
        }
    }
}
