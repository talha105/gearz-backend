<?php

namespace App\Http\Controllers\Api;

use App\Make;
use App\Genre;
use App\Utility;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::
            latest()
            ->when(request('seller_id') , function($query){
                $query->whereHas('sellers' , function($qu){
                    return $qu->where('users.id' , request('seller_id'));
                });
            })->get();

        if($categories){
            return response()->json(['success' => true , 'categories' => $categories]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }


    public function allDetails()
    {
        // latest()
        $categories = Category::with('sub_categories' , 'sub_categories.sub_categories')->get();
        $makes = Make::with('models','models.variants')->get();
        // $sub_categories = SubCategory::with('sub_categories')->get();
        $genres = Genre::all();
        // $utilities = Utility::has('items')->with('items')->get();
        if($categories){
            return response()->json(['success' => true , 'categories' => $categories , 'makes' => $makes , 'genres' => $genres]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/categories', $name);
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $category = Category::create([
            'title' => $request->title,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'description' => $request->description,
            'ar_description' => $request->ar_description ? $request->ar_description : $tr->setSource('en')->setTarget('ar')->translate($request->description),
            'image' => $name ?? '',
        ]);

        if($category){
            return response()->json(['success' => true , 'message' => 'Category Added Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
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
    public function update(Request $request , $id)
    {


        $category = Category::find($id);

        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/categories', $name);

            $category->image = $name;
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $category->title = $request->title;
        $category->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $category->description = $request->description;
        $category->ar_description = $request->ar_description ? $request->ar_description : $tr->setSource('en')->setTarget('ar')->translate($request->description);

        $category->save();

        if($category->save()){
            return response()->json(['success' => true , 'message' => 'Category Updated Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if($category->delete()){
            return response()->json(['success' => true , 'message' => 'Category Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }
    public function getSubSategories($id)
    {
        $category = Category::
            with(['sub_categories' => function($query){
                $query->when(request('seller_id') , function($query){
                        $query->whereHas('sellers' , function($qu){
                            return $qu->where('users.id' , request('seller_id'));
                        });
                    });
            } , //'sub_categories.sub_categories'
            ])
            ->find($id);

        $sub_categories = $category->sub_categories;
        $category->unsetRelation('sub_categories');
        if($sub_categories){
            return response()->json(['success' => true , 'category' => $category , 'sub_categories' => $sub_categories]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }
    public function getFeatures($id)
    {
        $category = Category::find($id);
        $features = $category->features;
        if($features){
            return response()->json(['success' => true , 'features' => $features , 'category' => $category]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }




    public function arabicTitle()
    {
        $categories = Category::all();
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        foreach($categories as $category){
            $category->ar_title = $tr->setSource('en')->setTarget('ar')->translate($category->title);
            $category->save();
        }
        echo 'All Done';

    }


}
