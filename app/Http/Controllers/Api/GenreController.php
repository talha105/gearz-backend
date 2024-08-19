<?php

namespace App\Http\Controllers\Api;

use App\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MakeModel;
use Stichoza\GoogleTranslate\GoogleTranslate;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request('make_id')){
            $models = MakeModel::where('make_id', request('make_id'))->get();
            $genreIds = $models->pluck('genre_id')->toArray();
            $genres = Genre::whereIn('id', $genreIds)->latest()->get();
        }else{
            $genres = Genre::latest()->get();
        }
        if($genres){
            return response()->json(['success' => true , 'genres' => $genres]);
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
            $image->storeAs('public/genres', $name);
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $genre = Genre::create([
            'title' => $request->title,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'description' => $request->description,
            'image' => $name ?? '',
        ]);

        if($genre){
            return response()->json(['success' => true , 'message' => 'genre Added Successfully']);
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

        $genre = Genre::find($id);

        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/genres', $name);

            $genre->image = $name;
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $genre->title = $request->title;
        $genre->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $genre->description = $request->description;
        $genre->save();

        if($genre->save()){
            return response()->json(['success' => true , 'message' => 'genre Updated Successfully']);
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
        $genre = Genre::find($id);

        if($genre->delete()){
            return response()->json(['success' => true , 'message' => 'genre Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }
}
