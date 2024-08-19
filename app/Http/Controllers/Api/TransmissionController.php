<?php

namespace App\Http\Controllers\Api;

use App\Transmission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TransmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transmissions = Transmission::latest()->get();
        if($transmissions){
            return response()->json(['success' => true , 'transmissions' => $transmissions]);
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

        $transmission = Transmission::create([
            'title' => $request->title,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
        ]);

        if($transmission){
            return response()->json(['success' => true , 'message' => 'Transmission Added Successfully']);
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

        $transmission = Transmission::find($id);

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $transmission->title = $request->title;
        $transmission->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $transmission->save();

        if($transmission->save()){
            return response()->json(['success' => true , 'message' => 'Transmission Updated Successfully']);
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
        $transmission = Transmission::find($id);

        if($transmission->delete()){
            return response()->json(['success' => true , 'message' => 'Transmission Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }
}
