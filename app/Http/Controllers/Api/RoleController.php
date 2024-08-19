<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $roles->map( function($role) {
            $role->create_date = Carbon::parse($role->created_at)->toDateString();
            $role->permission_ids = array_map('intval', $role->permissions->pluck('id')->toArray());
            return $role;
        } );
        return response()->json(['success' => true , 'roles' => $roles ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->permissions()->sync(request('permissions'));

        return response()->json(['success' => true , 'role' => $role ]);
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
    public function update($id)
    {
        $role = Role::find($id);
        $role->name = request('name');
        $role->save();
        $role->permissions()->sync(request('permissions'));

        return response()->json(['success' => true , 'role' => $role ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        return response()->json(['success' => true ,  ]);
    }


}
