<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();

        return response()->json(['success' => true , 'banners' => $banners]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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
    public function store(Request $request){

        // dd($request->all());

        $image = $request->image;
        $name =  uniqid(true) . rand(99, 999) . "." . $image->getClientOriginalExtension();
        $image->storeAs('/public/banners', $name);

        $new_image = Banner::create([
            'user_id' => $request->user_id,
            'name' => $name,
            'type' => 'banner',
        ]);

        return response()->json(['status' => 'Image Stored' ,'image' => $new_image ]);
    }


    public function destroy(Request $request){

        // dd($request->all());

        $image = Banner::find($request->image_id);

        if($image && file_exists('storage/banners/'.$image->name) && File::delete('storage/banners/'.$image->name)){

        $image->delete();

            return response()->json(['status' => 'Image delete' ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'Image Not Found'] , 422);
        }
    }
}
