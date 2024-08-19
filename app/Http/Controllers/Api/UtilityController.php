<?php

namespace App\Http\Controllers\Api;

use App\Utility;
use App\Utility_Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stichoza\GoogleTranslate\GoogleTranslate;

class UtilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $utilities = Utility::all();

        if($utilities){
            return response()->json(['success' => true , 'utilities' => $utilities ]);
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
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $utility = Utility::create([
            'title' => $request->title,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'description' => $request->description,
            // 'image' => $name ?? '',
        ]);

        if($utility){
            return response()->json(['success' => true , 'message' => 'utility Added Successfully']);
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
        $utility = Utility::find($id);
        
        // if($request->image){
        //     $image = $request->image;
        //     $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
        //     $image->storeAs('public/features', $name);

        //     $feature->image = $name;
        // }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $utility->title = $request->title;
        $utility->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $utility->description = $request->description;
        $utility->save();

        if($utility->save()){
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
        $utility = Utility::find($id);

        if($utility->delete()){
            return response()->json(['success' => true , 'message' => 'Sub Category Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }


    public function getUtilityItems($id){
        $items = Utility_Item::where('utility_id' , $id)->get();
        return response()->json(['success' => true , 'items' => $items ]);

    }

    public function arabicTitle()
    {
        $utilities = Utility::all();
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        foreach($utilities as $utility){

            if(!isset($utility->ar_title)){
                $utility->ar_title = $tr->setSource('en')->setTarget('ar')->translate($utility->title);
                $utility->save();
            }
        }
        echo 'All Done';
    }
}
