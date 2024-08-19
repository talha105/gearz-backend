<?php

namespace App\Http\Controllers\Api;

use App\SubCategory;
use App\SubSubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stichoza\GoogleTranslate\GoogleTranslate;

class SubSubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($id)
    {
        $sub_category = SubCategory::with(['sub_categories' => function($query){
            $query->when(request('seller_id') , function($query){
                    $query->whereHas('sellers' , function($qu){
                        return $qu->where('users.id' , request('seller_id'));
                    });
                });
        }])->find($id);
        $sub_categories = $sub_category->sub_categories;
        $sub_category->unsetRelation('sub_categories');
        if($sub_categories){
            return response()->json(['success' => true , 'sub_categories' => $sub_categories , 'sub_category' => $sub_category]);
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


        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/sub-categories', $name);
        }

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default


        $sub_category = SubSubCategory::create([
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'ar_description' => $request->ar_description ? $request->ar_description : $tr->setSource('en')->setTarget('ar')->translate($request->description),
            'image' => $name ?? NULL,
        ]);

        if($sub_category){
            return response()->json(['success' => true , 'message' => 'Sub Category Added Successfully']);
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
        $sub_category = SubSubCategory::find($id);

        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/sub-categories', $name);

            $sub_category->image = $name;
        }

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $sub_category->title = $request->title;
        $sub_category->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $sub_category->description = $request->description;
        $sub_category->ar_description = $request->ar_description ? $request->ar_description : $tr->setSource('en')->setTarget('ar')->translate($request->description);
        $sub_category->save();

        if($sub_category->save()){
            return response()->json(['success' => true , 'message' => 'Sub Category Updated Successfully']);
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
        $sub_category = SubSubCategory::find($id);

        if($sub_category->delete()){
            return response()->json(['success' => true , 'message' => 'Sub Category Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }

}
