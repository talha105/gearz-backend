<?php

namespace App\Http\Controllers\Api;

use App\Make;
use App\Imports\CsvImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Stichoza\GoogleTranslate\GoogleTranslate;

class MakeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $makes = Make::
            when(request('seller_id'), function($query){
                $query->whereHas('sellers' , function($qu){
                    return $qu->where('users.id' , request('seller_id'));
                });
            })->latest()->get();

        if($makes){
            return response()->json(['success' => true , 'makes' => $makes]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }



    public function store(Request $request)
    {
        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/makes', $name);
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $make = Make::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'description' => $request->description,
            'image' => $name ?? '',
        ]);

        if($make){
            return response()->json(['success' => true , 'message' => 'Make Added Successfully']);
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
        $make = Make::find($id);

        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/makes', $name);

            $make->image = $name;
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $make->title = $request->title;
        $make->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $make->description = $request->description;
        $make->save();

        if($make->save()){
            return response()->json(['success' => true , 'message' => 'Make Updated Successfully']);
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
        $make = Make::find($id);

        if($make->delete()){
            return response()->json(['success' => true , 'message' => 'Make Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }


    public function arabicTitle()
    {
        $makes = Make::all();
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        foreach($makes as $make){
            if(!$make->ar_title){
                $make->ar_title = $tr->setSource('en')->setTarget('ar')->translate($make->title);
                $make->save();
            }
        }
        echo 'All Done';

    }


    public function excelImport(Request $request){
        if($request->hasFile('import_file')){
            $row = Excel::toArray(new CsvImport, $request->file('import_file'));
            $first_sheet = $row[0];
            foreach($first_sheet as $value){
               if(isset($value)){
                    $make = Make::create([
                        'category_id' => 1,
                        'title' => $value[0],
                        'description' => $value[0],
                        'image' => '',
                    ]);
               }
            }
            return '1';
        }
        return '0';
    }

}
