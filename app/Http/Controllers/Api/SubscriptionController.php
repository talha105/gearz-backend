<?php

namespace App\Http\Controllers\Api;

use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stichoza\GoogleTranslate\GoogleTranslate;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::latest()->get();
        if($subscriptions){
            return response()->json(['success' => true , 'subscriptions' => $subscriptions]);
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

        $subscription = Subscription::create([
            'title' => $request->title,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'description' => $request->description,
            'ar_description' => $request->ar_description ? $request->ar_description : $tr->setSource('en')->setTarget('ar')->translate($request->description),
            'price' => $request->price,
            'duration' => $request->duration,
            'user_id' => $request->user_id,

        ]);

        if($subscription){
            return response()->json(['success' => true , 'message' => 'Subscription Added Successfully']);
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

        $subscription = Subscription::find($id);

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $subscription->title = $request->title;
        $subscription->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $subscription->description = $request->description;
        $subscription->ar_description = $request->ar_description ? $request->ar_description : $tr->setSource('en')->setTarget('ar')->translate($request->description);
        $subscription->price = $request->price;
        $subscription->duration = $request->duration;
        $subscription->user_id = $request->user_id;

        $subscription->save();

        if($subscription->save()){
            return response()->json(['success' => true , 'message' => 'Subscription Updated Successfully']);
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
        $subscription = Subscription::find($id);

        if($subscription->delete()){
            return response()->json(['success' => true , 'message' => 'Subscription Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }
}
