<?php

namespace App\Http\Controllers\Api;

use App\Make;
use App\MakeModel;
use App\Imports\CsvImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $make = Make::with('models','models.genre')->find($id);

        $models = $make->models;
        $make->unsetRelation('models');
        if(request('genre_id')){
            $models = $models->where('genre_id', request('genre_id'))->values();
        }

        if($models){
            return response()->json(['success' => true , 'make' => $make , 'models' => $models]);
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
        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/makes', $name);
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        // $trans = $tr->setSource('en')->setTarget('ar')->translate($request->title);
        // dd($trans);
        $model = MakeModel::create([
            'category_id' => $request->category_id,
            'make_id' => $request->make_id,
            'title' => $request->title,
            'genre_id' => $request->genre_id,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'description' => $request->description && $request->description != 'null' ? $request->description : NULL ,
            'image' => $name ?? '',
        ]);

        if($model){
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

        // dd($request->all());

        $model = MakeModel::find($id);
        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/makes', $name);

            $model->image = $name;
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $model->title = $request->title;
        $model->genre_id = $request->genre_id;
        $model->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $model->description = $request->description && $request->description != 'null' ? $request->description : NULL ;
        $model->save();

        if($model->save()){
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
        $model = MakeModel::find($id);

        if($model->delete()){
            return response()->json(['success' => true , 'message' => 'Make Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }


    public function arabicTitle()
    {
        $models = MakeModel::all();
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        foreach($models as $model){
            $model->ar_title = $tr->setSource('en')->setTarget('ar')->translate($model->title);
            $model->save();
        }
        echo 'All Done';

    }



    public function excelImport(Request $request){
        if($request->hasFile('import_file')){
            $row = Excel::toArray(new CsvImport, $request->file('import_file'));
            $row_count = count($row);
            $all_vehicles = array();
            for ($i = 1; $i <= $row_count - 1; $i++) {
             $sheet = $row[$i];
                foreach($sheet as $value){
                   if(isset($value)){
                       foreach($value as $car){
                           if(isset($car)){
                                $model = MakeModel::create([
                                    'category_id' => 1,
                                    'make_id' => $i+2,
                                    'title' => $car,
                                    'description' => $car,
                                    'image' => '',
                                ]);
                           }
                       }
                   }
                }
            }
            return ('1');
        }
        return '0';
    }

}
