<?php

namespace App\Http\Controllers\Api;

use App\Feature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stichoza\GoogleTranslate\GoogleTranslate;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $image->storeAs('public/features', $name);
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $feature = Feature::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'description' => $request->description,
            'image' => $name ?? '',
        ]);

        if($feature){
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
        $feature = Feature::find($id);
        
        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/features', $name);

            $feature->image = $name;
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $feature->title = $request->title;
        $feature->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $feature->description = $request->description;
        $feature->save();

        if($feature->save()){
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
        $feature = Feature::find($id);

        if($feature->delete()){
            return response()->json(['success' => true , 'message' => 'Sub Category Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }

    public function arabicTitle()
    {
        $features = Feature::all();
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        foreach($features as $feature){

            // dd($feature->ar_title , isset($feature->ar_title));
            if(!isset($feature->ar_title)){
                $feature->ar_title = $tr->setSource('en')->setTarget('ar')->translate($feature->title);
                $feature->save();
            }
        }
        echo 'All Done';
    }

}
