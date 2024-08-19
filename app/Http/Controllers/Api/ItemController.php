<?php

namespace App\Http\Controllers\Api;

use App\Utility;
use App\Utility_Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ItemController extends Controller
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
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $item = Utility_Item::create([
            'utility_id' => $request->utility_id,
            'title' => $request->title,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'description' => $request->description,
            // 'image' => $name ?? '',
        ]);

        if($item){
            return response()->json(['success' => true , 'message' => 'item Added Successfully']);
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
        $item = Utility_Item::find($id);
        
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $item->title = $request->title;
        $item->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $item->description = $request->description;
        $item->save();

        if($item->save()){
            return response()->json(['success' => true , 'message' => 'Item Updated Successfully']);
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
        $item = Utility_Item::find($id);

        if($item->delete()){
            return response()->json(['success' => true , 'message' => 'item Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }

    public function arabicTitle()
    {
        $items = Utility_Item::all();
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        foreach($items as $item){

            if(!isset($item->ar_title)){
                $item->ar_title = $tr->setSource('en')->setTarget('ar')->translate($item->title);
                $item->save();
            }
        }
        echo 'All Done';
    }
}
