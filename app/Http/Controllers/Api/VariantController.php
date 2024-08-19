<?php

namespace App\Http\Controllers\Api;

use App\Variant;
use App\MakeModel;
use App\Imports\CsvImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Stichoza\GoogleTranslate\GoogleTranslate;

class VariantController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $model = MakeModel::with('variants.transmissions')->find($id);
        $variants = $model->variants;
        $model->unsetRelation('variants');
        if($model){
            return response()->json(['success' => true , 'model' => $model , 'variants' => $variants]);
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
            $image->storeAs('public/variants', $name);
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        // $trans = $tr->setSource('en')->setTarget('ar')->translate($request->title);
        // dd($trans);
        $variant = Variant::create([
            'model_id' => $request->model_id,
            'title' => $request->title,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'ar_title' => $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title),
            'image' => $name ?? '',
        ]);

        if($variant){
            $variant->transmissions()->sync($request->transmission_ids);
            return response()->json(['success' => true , 'message' => 'Vairant Added Successfully']);
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

        $variant = Variant::find($id);
        if($request->image){
            $image = $request->image;
            $name =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/variants', $name);

            $variant->image = $name;
        }
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $variant->title = $request->title;
        $variant->start_year = $request->start_year;
        $variant->end_year = $request->end_year;
        $variant->ar_title = $request->ar_title ? $request->ar_title : $tr->setSource('en')->setTarget('ar')->translate($request->title);
        $variant->save();

        $variant->transmissions()->sync($request->transmission_ids);

        if($variant->save()){
            return response()->json(['success' => true , 'message' => 'Variant Updated Successfully']);
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
        $variant = Variant::find($id);

        if($variant->delete()){
            return response()->json(['success' => true , 'message' => 'Variant Deleted Successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }


    public function arabicTitle()
    {
        $variants = Variant::all();
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        foreach($variants as $model){
            $model->ar_title = $tr->setSource('en')->setTarget('ar')->translate($model->title);
            $model->save();
        }
        echo 'All Done';

    }


}
