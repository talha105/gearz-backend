<?php

namespace App\Http\Controllers\Api;

use App\Query;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QueryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $queries = Query::latest()->paginate(20);
        return response()->json(['success' => true , 'queries' => $queries ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = Query::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        if($query){
            return response()->json(['status' => true  , 'query' => $query ]);
        }else{
            return response()->json(['status' => false , 'message' => 'Unexpected error happend'] , 422);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = Query::find($id);

        if($query && $query->delete()){
            return response()->json(['status' => true  ]);
        }else{
            return response()->json(['status' => false , 'message' => 'query Not Found'] , 422);
        }
    }

    public function updateStatus(Request $request)
    {
        $query = Query::find($request->query_id);
        $query->is_resolved = $request->status;
        if($query->save()){
            return response()->json(['status' => true  ]);
        }else{
            return response()->json(['status' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }
}
