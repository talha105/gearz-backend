<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('type' , 'viewer')->latest()->paginate(20);

        return response()->json(['success' => true , 'users' => $users]);
    }


    public function search(Request $request)
    {
        $users = User::
            when( request('name') , function($query){
                $query->where(function($query) {
                    $query->where('name' , 'like' , '%' . request('name') . '%' );
                    $query->orWhere('phone' , 'like' , '%' . request('name') . '%' );
                    $query->orWhere('email' , 'like' , '%' . request('name') . '%' );
                });
            })
            ->when(request('sortBy') , function($query){
                $query->orderBy('created_at' , request('sortBy') );
            } )
            ->where('type' , 'viewer')->paginate(20);

        return response()->json(['success' => true , 'users' => $users]);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = User::where('email' , $request->email)->get();

        // dd($request->all());
        if($check->count() == 0){
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => \Hash::make($request->password),
            ]);

            if($user){
                return response()->json(['success' => true , 'user' => $user]);
            }else{
                return response()->json(['success' => false , 'messsage' => 'Unexpexted error occured'] , 422);
            }
        }else{
            return response()->json(['success' => false , 'message' => 'Email Already exists'] , 422);

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

        $check = User::where('email' , $request->email)->where('id' , '!=' , $id)->get();
        if($check->count() > 0){
            return response()->json(['success' => false , 'messsage' => 'Email Already registered'] , 422);
        }

        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if($request->password){
            $user->password = \Hash::make($request->password);
        }
        $user->save();

        if($user->save()){
            return response()->json(['success' => true , 'user' => $user]);
        }else{
            return response()->json(['success' => false , 'messsage' => 'Unexpexted error occured'] , 422);
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
        $user = User::find($id);

        if($user && $user->delete()){
            return response()->json(['status' => 'User Removed'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'User Not Found'] , 422);
        }
    }

}
