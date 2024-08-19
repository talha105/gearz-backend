<?php

namespace App\Http\Controllers\Api;

use App\Page;
use App\User;
use App\Query;
use App\Review;
use App\Listing;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminStats()
    {
        $stats = [];
        $week = Carbon::today()->subDays(7);
        $stats['new_users'] = User::where('type' , 'viewer')->where('created_at' , '>=' , $week)->get()->count();
        $stats['new_seller_requests'] = User::where('type' , 'seller')->get()->count();
        $stats['pending_seller_requests'] = User::where('type' , 'seller')->where('approved' , 0 )->get()->count();
        $stats['new_listings'] = Listing::where('created_at' , '>=' , $week)->get()->count();
        $stats['pending_listings'] = Listing::where('status' , 'pending')->get()->count();

        $stats['new_reviews'] = Review::where('created_at' , '>=' , $week)->get()->count();
        $stats['pending_reviews'] = Review::where('status' , 0 )->get()->count();
        $stats['total_categories'] = Category::all()->count();
        $stats['pending_queries'] = Query::where('is_resolved' , 0 )->count();


        return response()->json(['stats' => $stats]);
    }
    public function index()
    {
        $admins = User::with('roles')->where('type' , 'admin')->get();
        return response()->json(['admins' => $admins]);
    }

    public function updatePassword(Request $request)
    {
        $admin = User::where('email' , 'admin@admin.com')->first();
        $admin->password = \Hash::make($request->password);
        $admin->save();

        return response()->json(['success'=> true]);
    }


    public function ProfileUpdate(Request $request)
    {
        $user = User::findOrFail(request('id'));
        $user->name = $request->name;
        if($request->password){
            $user->password = \Hash::make($request->password);
        }
        $user->save();

        return response()->json(['success'=> true , 'user' => $user ]);

    }



    public function updateLogo(Request $request)
    {
        $image = $request->image;
        $name =  uniqid(true) . rand(99, 999) . "." . $image->getClientOriginalExtension();
        // $image->storeAs('/images/banners', $name);
        $request->image->move(public_path().'/images/' , $name );

        $page = Page::where('slug' , $request->slug)->first();
        $page->content = $name;
        $page->save();

        return response()->json(['success' => true ,  'message' => 'Page updated successfully', 'page' => $page]);

        return response()->json(['status' => 'Image Stored' ,'image' => $new_image ]);

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

        if($check->count() == 0){
            $user  =  User::create([
                'email' => $request->email,
                'name' => $request->name,
                'phone' => $request->phone,
                'type' => 'admin',
                'password' => \Hash::make($request->password),
            ]);

            // $user->givePermissionTo(['edit articles', 'delete articles']);
            // $user->syncPermissions($request->permissions);
            $user->roles()->sync([request('role')]);
            // $role = Role::find(request('role'));
            // $role->users()->attach([$user->id]);

            return response()->json(['success'=> true , 'message' => 'Admin Registered successfully' , 'user' => $user ]);

        }else{
            return response()->json(['success'=> false , 'message' => 'Email already exists'] , 422 );
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
        $user = User::find($id);

        $user->syncPermissions($request->permissions);
        $user->name = $request->name;
        if($request->password){
            $user->password = \Hash::make($request->password);
        }

        $user->save();
        $user->roles()->sync([request('role')]);

        if($user){
            return response()->json(['success' => true , 'user' => $user ]);
        }else{
            return response()->json(['success' => false , 'message' => 'Admin Not Found' ] , 422);
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
            return response()->json(['status' => 'user deleted'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'user Not Found'] , 422);
        }
    }
}
