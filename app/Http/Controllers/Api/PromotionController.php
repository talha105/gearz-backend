<?php

namespace App\Http\Controllers\Api;

use App\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = Promotion::latest()->get();
        if($promotions){
            return response()->json(['success' => true , 'promotions' => $promotions]);
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

        $promotions = Promotion::create([
            'code' => $request->code,
            'percentage' => $request->percentage,
            'description' => $request->description,
            'ar_description' => $request->ar_description ? $request->ar_description : $tr->setSource('en')->setTarget('ar')->translate($request->description),
            'duration' => $request->duration,
            'subscription_id' => $request->subscription_id,
            'user_id' => $request->user_id,


        ]);

        if($promotions){
            return response()->json(['success' => true , 'message' => 'Promotion Added Successfully']);
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

        // dd($request->all() , $request->has_modal , $request->has_modal == false );

        $promotion = Promotion::find($id);

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $promotion->code = $request->code;
        $promotion->percentage = $request->percentage;
        $promotion->description = $request->description;
        $promotion->ar_description = $request->ar_description ? $request->ar_description : $tr->setSource('en')->setTarget('ar')->translate($request->description);
        $promotion->duration = $request->duration;
        $promotion->user_id = $request->user_id;
        $promotion->subscription_id = $request->subscription_id;

        $promotion->save();

        if($promotion->save()){
            return response()->json(['success' => true , 'message' => 'Promotion Updated Successfully']);
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
        $promotion = Promotion::find($id);

        if($promotion->delete()){
            return response()->json(['success' => true , 'message' => 'Promotion Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }
}
