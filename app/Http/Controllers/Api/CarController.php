<?php

namespace App\Http\Controllers\Api;

use App\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{


    public function index()
    {
        $cars = Car::
            with('make','model','transmission','genre','variant')->
            where('user_id' , auth()->user()->id)->get();
        $cars->append(['name', 'ar_name']);
        if($cars){
            return response()->json(['success' => true , 'cars' => $cars]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }

    }


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'registration_number' => 'required|unique:cars,registration_number',
        ]);

        // Check validation failure
        if ($validator->fails()) {
            return response()->json(['success' => false , 'errors' => $validator->errors()] , 422);
        }

        $car = Car::create([
            'user_id' => auth()->user()->id,
            'make_id' => request('make_id'),
            'model_id' => request('model_id'),
            'genre_id' => request('genre_id'),
            'variant_id' => request('variant_id'),
            'transmission_id' => request('transmission_id'),
            'registration_number' => request('registration_number'),
            // 'registration_year' => request('registration_year'),
            // 'transmission' => request('transmission'),
        ]);

        if($car){
            return response()->json(['success' => true , 'car' => $car]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }

    }

    public function update(Request $request , $car_id)
    {

        $validator = Validator::make($request->all(), [
            'registration_number' => 'required|unique:cars,registration_number,'.$car_id,
        ]);

        // Check validation failure
        if ($validator->fails()) {
            return response()->json(['success' => false , 'errors' => $validator->errors()] , 422);
        }

        $car = Car::find($car_id)->update([
            'make_id' => request('make_id'),
            'model_id' => request('model_id'),
            'genre_id' => request('genre_id'),
            'variant_id' => request('variant_id'),
            'transmission_id' => request('transmission_id'),
            'registration_number' => request('registration_number'),
        ]);

        if($car){
            return response()->json(['success' => true , 'car' => $car]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }

    }


    public function destroy($car_id)
    {
        $car = Car::find($car_id);
        if($car && $car->user_id == auth()->user()->id){
            $car->delete();
            return response()->json(['success' => true , 'message' => 'Car deleted successfully']);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }

    }


}
