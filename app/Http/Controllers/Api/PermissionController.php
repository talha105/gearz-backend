<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        $permissions_grouped = $permissions->groupBy('group_by');
        return response()->json([
            'permissions' => $permissions,
            'permissions_grouped' => $permissions_grouped
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = Permission::create(['name' => $request->permission ]);

        return response()->json(['permission' => $permission]);
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
        $permission = Permission::find($id);
        $permission->delete();

        return response()->json(['success' => true]);

    }



    public function seedPermissions()
    {
        Permission::query()->delete();

        // Permission::delete();
        // $current->delete();

        $perms = "create makes,create genre,create categories,create sellers,create listings,create users,create display blocks,create push notifications,create transmission,edit makes,edit genre,edit categories,edit sellers,edit listings,edit users,edit display blocks,edit transmission,delete makes,delete genre,delete categories,delete sellers,delete listings,delete users,delete display blocks,delete transmission,approve sellers,approve listings,approve reviews,resolve query,reject sellers,reject listings,reject reviews,view reviews,view reports,view query,view makes,view genre,view categories,view users,view display blocks,view listings,view sellers,view push notifications,view transmission,manage image sizes";

        // php artisan cache:forget spatie.permission.cache
        // php artisan cache:clear

        $permsArray = explode( ',',  $perms);
        foreach($permsArray as $key => $perm) {
            $group = explode(' ', $perm, 2);
            // TRUNCATE TABLE permissions; to reset permissions
            Permission::create([ 'name' => $perm, 'group_by' => $group[1]]);
        }
        echo "Good to go.";
    }


}
