<?php

namespace App\Http\Controllers\Api;

use App\Listing;
use App\DisplayBlock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stichoza\GoogleTranslate\GoogleTranslate;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $reviews = Review::with('user')->latest()->get();
        $blocks = DisplayBlock::customSort()->get();
        return response()->json(['success' => true , 'blocks' => $blocks ]);

    }

    public function blockListings($id)
    {
        try{
            $block = DisplayBlock::find($id);
            $listings = $block->home_listings;
            $listings->append(['garage_name', 'ar_garage_name']);
            return response()->json(['status' => true , 'listings' => $listings  ]);
        }catch(\Exception $e){
            return response()->json(['status' => false , 'message' => $e->getMessage()] , 422);
        }
    }

    public function get()
    {
        // $reviews = Review::with('user')->latest()->get();
        $blocks = DisplayBlock::where('status' , 1)->customSort()->get();
        return response()->json(['success' => true , 'blocks' => $blocks ]);

    }

    public function getAllBlocks()
    {
        $blocks = DisplayBlock::with('home_listings')->customSort()->where('status' , 1)->get();
        foreach($blocks as $block){
            $block->all_listings = $block->home_listings->take(10)->values();
        }
        return response()->json(['success' => true , 'blocks' => $blocks ]);
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
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $block = DisplayBlock::create([
            'title' => $request->title,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'status' => $request->status,
            'description' => $request->description,
            'sort' => DisplayBlock::all()->count(),
        ]);

        if($block){
            return response()->json(['success' => true , 'message' => 'blocks added Successfully' , 'block' => $block ]);
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
    public function update(Request $request, $id)
    {
        $block = DisplayBlock::find($id);

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $block->title = $request->title;
        $block->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $block->description = $request->description;
        $block->status = $request->status;
        $block->save();

        if($block->save()){
            return response()->json(['success' => true , 'message' => 'block Updated Successfully']);
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
        $block = DisplayBlock::find($id);

        if($block && $block->delete()){
            return response()->json(['status' => 'blocks deleted'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'block Not Found'] , 422);
        }
    }

    public function updateSortIndex(Request $request)
    {

        foreach($request->ids as $k => $id){
            $block = DisplayBlock::find($id);
            $block->sort = $k;
            $block->save();
        }
        return response()->json(['status' => 'blocks sorted'  ]);

    }

    public function listingBlockUpdate(Request $request)
    {
        // dd($request->all());
        $listing = Listing::find($request->listing_id);
        $listing->blocks()->sync($request->block_ids);

        if($listing){
            return response()->json(['status' => 'listing deleted'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'block Not Found'] , 422);
        }
    }


    public function arabicTitle()
    {
        $blocks = DisplayBlock::all();
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        foreach($blocks as $block){
            $block->ar_title = $tr->setSource('en')->setTarget('ar')->translate($block->title);
            $block->save();
        }
        echo 'All Done';

    }



}
