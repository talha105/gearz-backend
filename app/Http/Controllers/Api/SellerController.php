<?php

namespace App\Http\Controllers\Api;

use App\Car;
use App\User;
use App\Seller;
use App\Listing;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function stats(Request $request){
        $all_listing = Listing::where('user_id' , $request->user_id)->get();

        $stats['approved'] = $all_listing->where('status' , 'approved' )->count();
        $stats['pending'] = $all_listing->where('status' , 'pending' )->count();
        $stats['draft'] = $all_listing->where('status' , 'draft' )->count();
        $stats['all'] = $all_listing->count();

        return response()->json(['success' => true , 'stats' => $stats ]);
    }


    public function getAllSellers()
    {
        $sellers = User::with('seller')
            ->when( request('status') , function($query){
                $query->where('status' , request('status') );
            })
            ->when( request('city') , function($query){
                $query->whereHas('seller' , function($query){
                    $query->where('city' , 'like' , '%' . request('city') . '%' );
                });
            })
            ->when( request('garage_name') , function($query){
                $query->whereHas('seller' , function($query){
                    $query->where('garage_name' , 'like' , '%' . request('garage_name') . '%' );
                    $query->orWhere('ar_garage_name' , 'like' , '%' . request('garage_name') . '%' );
                });
            })

            ->where('type' , 'seller')
            ->orderBy('created_at' , request('sortBy', 'Desc'))
            ->paginate(15);

        $sellers->append(['pivots']);

        return response()->json(['success' => true , 'sellers' => $sellers ]);
    }

    public function getSellerList()
    {
        $sellers = User::with('seller')->where('approved' , 1)->where('type' , 'seller')->get();

        return response()->json(['success' => true , 'sellers' => $sellers ]);
    }

    public function searchSellers(Request $request)
    {
        $sellers = User::with('seller')->
        when( request('name') , function($query){
            $query->where(function($query) {
                $query->where('name' , 'like' , '%' . request('name') . '%' );
                $query->orWhere('email' , 'like' , '%' . request('name') . '%' );
            });
        })
        ->when(request('sortBy') , function($query){
            $query->orderBy('created_at' , request('sortBy') );
        } )
        ->when( request('status') , function($query){
            // dd( (int) request('active') );
            $query->where('status' , request('status') );
            // $query->where('approved' , (int) request('status') );
        })
        ->when( request('city') , function($query){
            $query->whereHas('seller' , function($query){
                $query->where('city' , 'like' , '%' . request('city') . '%' );
            });
        })
        ->where('type' , 'seller')
        ->paginate(20);

        return response()->json(['success' => true , 'sellers' => $sellers]);

    }

    public function getSpecificSellers(Request $request)
    {
        $sellers = User::with('seller')
            ->where('type' , 'seller')
            ->where('status' , $request->status)
            ->orderBy('created_at' , 'desc')
            ->paginate(20);

        $sellers->append(['pivots']);
        return response()->json(['success' => true , 'sellers' => $sellers ]);

    }
    public function searchUsers(Request $request)
    {
        $users = User::
        when( request('name') , function($query){
            $query->where(function($query) {
                $query->where('name' , 'like' , '%' . request('name') . '%' );
                $query->orWhere('email' , 'like' , '%' . request('name') . '%' );
            });
        })
        ->when(request('sortBy') , function($query){
            $query->orderBy('created_at' , request('sortBy') );
        } )
        ->where('type' , 'viewer')
        ->paginate(20);

        return response()->json(['success' => true , 'users' => $users]);

    }

    public function getProfile(Request $request)
    {
        $user = User::with('seller')->find($request->user_id);
        if($user){
            return response()->json(['success' => true , 'user' => $user ]);
        }else{
            return response()->json(['success' => false , 'message' => 'Profile Not Found' ] , 422);
        }

    }
    public function userUpdate(Request $request)
    {
        $user = User::find($request->user_id);

        $user->name = $request->name;
        $user->phone = $request->phone;
        if($request->password){
            $user->password = \Hash::make($request->password);
        }

        $user->save();

        if($user){
            return response()->json(['success' => true , 'user' => $user ]);
        }else{
            return response()->json(['success' => false , 'message' => 'Profile Not Found' ] , 422);
        }

    }

    public function userSellerUpdate(Request $request)
    {

        $user = User::with('seller')->find($request->user_id);
        
        $user->name = $request->garage_name ?? $request->name;
        $user->phone = $request->phone;
        if($request->password){
            $user->password = \Hash::make($request->password);
        }
        if($user->seller){
            $user->seller->garage_name = $request->garage_name;
            $user->seller->ar_garage_name = $request->ar_garage_name;
            $user->seller->city = $request->city;
            $user->seller->address = $request->address;
            $user->seller->about = $request->about;
            $user->seller->ar_about = $request->ar_about;
        }

        if($request->image){
            $image = $request->image;
            $logo =  rand(99, 9999) . time() . $image->getClientOriginalName();
            $image->storeAs('public/sellers', $logo);
            $user->seller->logo = $logo;
        }


        $user->seller->save();
        $user->save();


        if($user && $request->docs){

            $docs = [];
            $all_docs = $user->seller->docs;
            // dd($request->docs);
            foreach($request->docs as $k => $doc){
                // dd($all_docs[$k]);
                if( isset($all_docs[$k]) && $doc == $all_docs[$k]){
                    $docs[] = $doc;
                }
            }


            if($request->_docs){
                $all_files = $request->_docs;
                foreach($all_files as $k => $file){
                    $name =  rand(99, 9999) . time() . $file->getClientOriginalName();
                    if($file->storeAs('public/seller/files', $name)){
                        $docs[] = $name;
                    }else{
                        return response()->json(['success'=> false , 'message' => 'Unexpexted error when uploading file'] , 422 );
                    }
                }
                // dd($docs);
            }
            $user->seller->docs = $docs;
            $user->seller->save();
        }

        request('makes') && $user->makes()->sync(explode(',', request('makes',[])));
        request('categories') &&  $user->categories()->sync(explode(',', request('categories',[])));
        request('subCategories') &&  $user->sub_categories()->sync(explode(',', request('subCategories',[])));
        request('subSubCategories') &&  $user->sub_sub_categories()->sync(explode(',', request('subSubCategories',[])));


        $user->append(['pivots']);

        if($user){
            return response()->json(['success' => true , 'user' => $user ]);
        }else{
            return response()->json(['success' => false , 'message' => 'Profile Not Found' ] , 422);
        }

    }

    public function index()
    {
        //
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
                'name' => $request->garage_name,
                'phone' => $request->phone,
                'approved' => 1,
                'status' => 'approved',
                'type' => 'seller',
                'password' => \Hash::make($request->password),
            ]);

            request('makes') && $user->makes()->sync(explode(',', request('makes',[])));
            request('categories') &&  $user->categories()->sync(explode(',', request('categories',[])));
            request('subCategories') &&  $user->sub_categories()->sync(explode(',', request('subCategories',[])));
            request('subSubCategories') &&  $user->sub_sub_categories()->sync(explode(',', request('subSubCategories',[])));


            if($request->image){
                $image = $request->image;
                $logo =  rand(99, 9999) . time() . $image->getClientOriginalName();
                $image->storeAs('public/sellers', $logo);
            }


            $seller = Seller::create([
                'user_id' => $user->id,
                'garage_name' => $request->garage_name,
                'ar_garage_name' => $request->ar_garage_name,
                'city' => $request->city,
                'about' => $request->about,
                'ar_about' => $request->ar_about,
                'address' => $request->address,
                'logo' => isset($logo) ? $logo : NULL,
            ]);

            $user->seller;

            if($user && $seller){

                $admins = User::where('type' , 'admin')->get();
                $subject = "A New Seller Registered";
                $body = "A New Seller <b>".$user->name ."</b> has Registered";
                foreach($admins as $admin){
                    dispatch(new SendEmail($admin , $subject , $body ));
                }

                $subject = "Welcome to Gearz";
                $body = "Hello and welcome to Gearz.
                        <br>
                        You can start listing all your Vehicles
                        <br>
                        Thank you, Gearz";

                dispatch(new SendEmail($user , $subject , $body ));
            }

            return response()->json(['success'=> true , 'message' => 'User Registered successfully' , 'user' => $user ]);

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
        $user = User::find($id);

        if($user && $user->seller->delete() && $user->delete()){
            return response()->json(['status' => 'seller deleted'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'seller Not Found'] , 422);
        }
    }
    public function destroyUser($id)
    {
        $user = User::find($id);

        if($user && $user->delete()){
            return response()->json(['status' => 'User Removed'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'User Not Found'] , 422);
        }
    }

    public function updateSellerStatus(Request $request)
    {
        // dd($request->all());

        $user = User::find($request->user_id);
        $user->approved = $request->approved;
        $user->status = $request->status;
        if($user->save()){

            if($user->status == 'approved'){
                $subject = "Gearz";
                $body = "Congratulations your seller account has been approved, happy listing
                <br>
                Thank you, Gearz
                ";
                dispatch(new SendEmail($user , $subject , $body ));
            }
            if($user->status == 'rejected'){
                $subject = "Gearz";
                $body = "We regret to inform you that your seller account has been denied, we wish all the best
                <br>
                Thank you, Gearz
                ";
                dispatch(new SendEmail($user , $subject , $body ));
            }
            return response()->json(['status' => 'Seller updated'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'Unexpected error happend'] , 422);
        }
    }


    public function downloadSellerFile($file)
    {
        if(file_exists(public_path() . "/storage/seller/files/".$file)){
            return response()->download(public_path() . "/storage/seller/files/".$file);
        }else{
            return response()->json( [ 'success' => false , 'message' => 'File Not Found' ] , 422) ;
        }
    }


    public function sellersList()
    {
        try{
            if(request('car_id')){
                $make_ids = [Car::find(request('car_id'))->make_id];
            }else{
                $make_ids = auth()->user()->cars->pluck('make_id')->toArray();
            }

            $sellers = User::
                when(request('category_ids') , function($query){
                    $query->whereHas('categories' , function($qu){
                        return $qu->where('categories.id' , request('category_ids'));
                    });
                })->
                when(request('sub_category_id') , function($query){
                    $query->whereHas('sub_categories' , function($qu){
                        return $qu->where('sub_categories.id' , request('sub_category_id'));
                    });
                })->
                when(request('sub_sub_category_id') , function($query){
                    $query->whereHas('sub_sub_categories' , function($qu){
                        return $qu->where('sub_sub_categories.id' , request('sub_sub_category_id'));
                    });
                })->

                whereHas('makes' , function($query) use ($make_ids){
                    return $query->whereIn('makes.id' , $make_ids);
                } )->

                with('seller')
                ->latest()
                ->where('type' , 'seller')
                ->where('approved' , 1)
                ->paginate(15);

            return response()->json(['success' => true , 'sellers' => $sellers ]);

        }catch(Exception $e){
            return response()->json( [ 'success' => false , 'message' => 'File Not Found' , 'exception' => $e->getMessage() ] , 422) ;
        }
    }

    public function showSeller($id)
    {
        try{
            $seller = User::
                with('seller')
                ->find($id);
            $seller->append('average_ratings', 'coordinates');

            return response()->json(['success' => true , 'seller' => $seller ]);

        }catch(Exception $e){
            return response()->json( [ 'success' => false , 'message' => 'Seller Not Found' , 'exception' => $e->getMessage() ] , 422) ;
        }
    }


    public function showSellerBrands($id)
    {
        try{
            $seller = User::
                with('seller', 'makes')
                ->find($id);

            return response()->json(['success' => true , 'seller' => $seller, 'makes' => $seller->makes ]);

        }catch(Exception $e){
            return response()->json( [ 'success' => false , 'message' => 'Seller Not Found' , 'exception' => $e->getMessage() ] , 422) ;
        }
    }

    public function showSellerCategories($id)
    {
        try{
            $seller = User::
                with('seller', 'makes', 'categories', 'sub_categories', 'sub_sub_categories')
                ->find($id);

            return response()->json([
                'success' => true ,
                'seller' => $seller,
                'makes' => $seller->makes,
                'categories' => $seller->categories,
                'sub_categories' => $seller->sub_categories,
                'sub_sub_categories' => $seller->sub_sub_categories,
            ]);

        }catch(Exception $e){
            return response()->json( [ 'success' => false , 'message' => 'Seller Not Found' , 'exception' => $e->getMessage() ] , 422) ;
        }
    }
}
