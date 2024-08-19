<?php

namespace App\Http\Controllers\Api;

use App\Make;
use App\Feature;
use App\Listing;
use App\Category;
use App\MakeModel;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $models = MakeModel::all();
        $features = Feature::all();
        $sub_categories = SubCategory::all();
        $makes = Make::all();

        return response()->json(['success' => true , 
        'categories' => $categories,
        'sub_categories' => $sub_categories,
        'models' => $models,
        'features' => $features,
        'makes' => $makes,
        ]);
    }


    public function searchFilters(Request  $request)
    {
        // dd($request->all());


        $listings = Listing::approved()->
        when(request('category') , function($query){
            $query->where('category_id' , request('category')['id']);
        })
        ->when(request('model') , function($query){
            $query->where('model_id' , request('model')['id']);
        })
        ->when(request('make') , function($query){
            $query->where('make_id' , request('make')['id']);
        })
        ->when(request('feature') , function($query){
            
            // foreach(request('feature') as $feature ){
            //     $all_features[] = $feature['id']; 
            // }

            $query->whereHas('features' , function($query){
                $query->where('feature_id' ,  request('feature')['id']);
                // $query->whereIn('feature_id' ,  $all_features);
            } );
        })
        ->when(request('genre') && request('genre')['id'] != 'all' , function($query){
            $query->where('genre_id' , request('genre')['id']);
        })
        ->when(request('city') , function($query){
            $query->where('city' , 'like' , '%'. request('city') . '%'  );
        })
        ->when(request('transmission') , function($query){
            $query->where('attr->transmission' , request('transmission'));
        })
        ->when(request('seats') , function($query){
            $query->where('attr->seats' , request('seats'));
        })
        ->when(request('doors') , function($query){
            $query->where('attr->doors' , request('doors'));
        })
        ->when(request('year') , function($query){
            $query->where('attr->year' , request('year'));
        })
        ->when(request('search') , function($query){
            $query->where('title' , 'like' , '%'. request('search') . '%' );
            $query->orWhere('description' , 'like' , '%'. request('search') . '%' );
            $query->orWhere('ar_title' , 'like' , '%'. request('search') . '%' );
            $query->orWhere('ar_description' , 'like' , '%'. request('search') . '%' );
        } )
        ->when(request('min_day') , function($query){
            $query->where('day_price' , '>=' , (int) request('min_day') );
        } )
        ->when(request('max_day') , function($query){
            $query->where('day_price' , '<=' , (int) request('max_day') );
        } )
        
        ->when(request('max_month') , function($query){
            $query->where('day_price' , '>=' , (int) request('max_month') );
        } )
        ->when(request('max_month') , function($query){
            $query->where('day_price' , '<=' , (int) request('max_month') );
        } )
        // ->when(request('sort_by') && !request('sort_by_price') , function($query){
        //     $query->orderBy('created_at' , request('sort_by') );
        // } )
        ->when(request('sort_by_price') , function($query){
            // $query->orderByRaw("day_price::int", request('sort_by_price')  );
            $query->orderBy('day_price' , request('sort_by_price') );
        } )
        ->paginate(5);

        foreach($listings as $list){
            if($request->user_id && $list->likes->find($request->user_id) ){
                // dd($list->likes->find($request->user_id));
                $list->liked = true;
            }else{
                $list->liked = false;
            }
        }

        // $listings = $listings->sortByDesc('day_price');

        return response()->json(['success' => true , 'listings' => $listings]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
