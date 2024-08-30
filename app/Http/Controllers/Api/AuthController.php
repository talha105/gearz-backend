<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Seller;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function login( Request $request )
    {
        // dd($request->all());
        // $user = User::where('email' , $request->email )->where('type' , 'viewer')->first();
                $user = User::where('email' , $request->email )->first();

        if($user && \Hash::check( $request->password, $user->password )){

            $user->fcm_token = request('fcm_token');
            $user->save();

            Auth::login($user);
            $user->last_login = Carbon::now();
            $tokenobj = Auth::user()->createToken('name');
            $token = $tokenobj->accessToken;

            $user->append(['total_cars_count']);

            return response()->json(['success'=> true , 'message' => 'Login successfully' , 'user' => $user , 'token' => $token ]);
        }elseif($user){
            return response()->json(['success'=> false , 'message' => 'No such records exists'] , 422 );
        }else{
            return response()->json(['success'=> false , 'message' => 'User does not exist'] , 422 );
        }


    }



    public function resendOTP( Request $request )
    {
        // dd($request->all());
        $user = User::where('email' , $request->email )->first();
        // && $user->status == 'pending'
        if($user){

            $otp = rand(000000 , 999999);
            $user->otp = $otp;
            $user->save();

            $subject = "Password Reset Code";
            $body = "Here is the 6 digit code
            <br>
            <h1>" .  $otp  . "</h1>
            <br>
            Thanks, GEARZ
            ";
            dispatch(new SendEmail($user , $subject , $body ));

            return response()->json(['success'=> true , 'message' => 'Code sent successfully' ]);
        }elseif($user){
            return response()->json(['success'=> false , 'message' => 'No such records exists'] , 422 );
        }else{
            return response()->json(['success'=> false , 'message' => 'User does not exist'] , 422 );
        }
    }



    public function verifyOTP( Request $request )
    {
        $user = User::where('email' , $request->email )->first();

        if($user && $user->otp && $user->otp == $request->otp){

            $user->otp = null;
            $user->status = 'verified';
            $user->save();

            return response()->json(['success'=> true , 'message' => 'OTP verified successfully' ]);
        }elseif($user){
            return response()->json(['success'=> false , 'message' => 'OTP not matched'] , 422 );
        }else{
            return response()->json(['success'=> false , 'message' => 'User does not exist'] , 422 );
        }
    }


    public function resetPassword( Request $request )
    {
        $user = User::where('email' , $request->email )->first();
        // strlen(request('password')) > 7
        if($user && request('password') && request('password') == request('confirm_password')){

            $user->otp = null;
            $user->password = \Hash::make($request->password);
            $user->save();

            return response()->json(['success'=> true , 'message' => 'New Password updated successfully' ]);
        }elseif($user){
            return response()->json(['success'=> false , 'message' => 'Password not matched'] , 422 );
        }else{
            return response()->json(['success'=> false , 'message' => 'User does not exist'] , 422 );
        }
    }


    public function socialLogin( Request $request )
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'source' => 'required | string',
        ]);

        // Check validation failure
        if ($validator->fails()) {
            return response()->json(['success' => false , 'errors' => $validator->errors()] , 422);
        }

        $user = User::updateOrCreate(
            [
                'email' => $request->email
            ],[
                'email' => $request->email,
                'name' => $request->name,
                'phone' => $request->phone,
                'source' => $request->source,
                'fcm_token' => $request->fcm_token,
                'type' => 'viewer',
                'status' => 'verified',
                'password' => Hash::make(Str::random(20))
            ]
        );


        $user->append(['total_cars_count']);

        if($user && !$user->wasRecentlyCreated && $user->wasChanged()){
            $status = 'User updated successfully';
        }elseif($user){
            $subject = "Thank you for your registration";
            $body = "
            <div style='font-size:16px; font-weight: bold;'>Hi {$user->name},</div>
            <br>
            <div style='font-size:14px;'>Thank you for joining our community,</div>
            <br>
            <div style='font-size:14px;'>We strive to provide the highest quality service and care deeply about how our work affects customers like you. We would love it if you could send us an email and tell us what we can do to make our app better</div>
            <br>
            <div style='font-size:14px;'>Thank you for taking the time out of your day. We really appreciate it!</div>
            <br>
            <div style='font-size:14px;'>Best regards, Gearz support team</div>
            ";
            dispatch(new SendEmail($user , $subject , $body ));
        }


        if($user){

            Auth::login($user);
            $user->last_login = Carbon::now();
            $tokenobj = Auth::user()->createToken('name');
            $token = $tokenobj->accessToken;

            return response()->json(['success'=> true , 'message' => 'Login successfully' , 'user' => $user , 'token' => $token ]);
        }elseif($user){
            return response()->json(['success'=> false , 'message' => 'No such records exists'] , 422 );
        }else{
            return response()->json(['success'=> false , 'message' => 'User does not exist'] , 422 );
        }
    }


    public function sellerLogin( Request $request )
    {
        // dd($request->all());
        $user = User::where('email' , $request->email )->where('type' , 'seller')->first();

        // dd($user);

        if($user && $user->approved == 0){
            return response()->json(['success'=> false , 'message' => 'Your account is not approved yet'] , 422 );
        }else{

            if($user && \Hash::check( $request->password, $user->password )){

                $user->seller;
                $user->last_login = Carbon::now();

                return response()->json(['success'=> true , 'message' => 'Login successfully' , 'user' => $user ]);
            }elseif($user && !(\Hash::check( $request->password, $user->password )) ){
                return response()->json(['success'=> false , 'message' => 'No such records exists'] , 422 );
            }else{
                return response()->json(['success'=> false , 'message' => 'User does not exist'] , 422 );
            }

        }



    }
    public function userRegister( Request $request )
    {
        $check = User::where('email' , $request->email)->get();
        $type = $request->userType == "seller" ? "seller" : "viewer";
        $otp = rand(000000 , 999999);

        if($check->count() == 0){
            $user  =  User::create([
                'email' => $request->email,
                'name' => $request->name,
                'phone' => $request->phone,
                'fcm_token' => $request->fcm_token,
                'type' => $type,
                'otp' => $otp,
                'password' => \Hash::make($request->password),
            ]);
            
            if($type == "seller"){
                // seller registered
                if($request->image){
                    $image = $request->image;
                    $logo =  rand(99, 9999) . time() . $image->getClientOriginalName();
                    $image->storeAs('public/sellers', $logo);
                }

                if ($request->hasFile('docs')) {
                    $docs = $request->file('docs');
                    $documents = []; // Array to hold the names of the saved documents
                
                    foreach ($docs as $doc) {
                        // Generate a unique name for each document
                        $documentName = rand(99, 9999) . time() . $doc->getClientOriginalName();
                        // Store the document in the specified directory
                        $doc->storeAs('public/sellers', $documentName);
                        // Add the document name to the array
                        $documents[] = $documentName;
                    }
                    
                    // Convert the array of document names to a comma-separated string (or another format if needed)
                    $documentsString = implode(',', $documents);
                } else {
                    $documentsString = NULL; // No documents were uploaded
                }
                

                $seller = Seller::create([
                'garage_name' => $request->name,,
                'user_id' => $user->id,
                'city' => $request->city ?? "Null",
                'about' => $request->about ?? "Nothing",
                'docs' => $documentsString ?? "Null",
                'logo' => isset($logo) ? $logo : NULL,
                ]);
            }

            if($user){
                $subject = "Thank you for your registration";
            
            if($type == "seller"){
                
                
                      $body = "Hello and welcome to Gearz your request is pending at this time and will take 2-3 business days, upon approval you can start listing all your Vehicles we appreciate your patience
                <br>
                Thank you, Gearz
                ";
                
            }
            else{
                    $body = "
                <div style='font-size:16px; font-weight: bold;'>Hi {$user->name},</div>
                <br>
                <div style='font-size:14px;'>Thank you for joining our community,</div>
                <br>
                <div style='font-size:14px;'>We strive to provide the highest quality service and care deeply about how our work affects customers like you. We would love it if you could send us an email and tell us what we can do to make our app better</div>
                <br>
                <div style='font-size:14px;'>Thank you for taking the time out of your day. We really appreciate it!</div>
                <br>
                <div style='font-size:14px;'>Best regards, Gearz support team</div>
                ";
            }
                
                
                dispatch(new SendEmail($user , $subject , $body ));
            }

            Auth::login($user);
            $user->last_login = Carbon::now();
            $tokenobj = Auth::user()->createToken('name');
            $token = $tokenobj->accessToken;

            $user->append(['total_cars_count']);

            return response()->json(['success'=> true , 'message' => 'User Registered successfully' , 'user' => $user , 'token' => $token ]);

        }else{
            return response()->json(['success'=> false , 'message' => 'Email already exists'] , 422 );
        }
    }


    public function verifyToken(Request $request)
    {

        $user = Auth::guard('api')->user();

        if(Auth::guard('api')->check()){

            $user->append(['total_cars_count']);

            return response()->json([
                'success'=> true ,
                'message' => 'Token is valid',
                'user' => $user,
                // 'token' => Auth::guard('api')->token(),
            ]);
        }else{
            return response()->json(['success'=> false , 'message' => 'Invalid token'] , 401 );
        }

    }


    public function sellerRegister( Request $request )
    {
        // dd($request->all());
        $check = User::where('email' , $request->email)->get();

        if($check->count() == 0){

            $docs = [];
            if($request->docs){
                $all_files = $request->docs;
                foreach($all_files as $k => $file){
                    $name =  rand(99, 9999) . time() . $file->getClientOriginalName();
                    if($file->storeAs('public/seller/files', $name)){
                        $docs[] = $name;
                    }else{
                        return response()->json(['success'=> false , 'message' => 'Unexpexted error when uploading file'] , 422 );
                    }
                }
            }


            $user  =  User::create([
                'email' => $request->email,
                'name' => $request->name,
                'phone' => $request->phone,
                'type' => 'seller',
                'password' => \Hash::make($request->password),
            ]);

            if($request->image){
                $image = $request->image;
                $logo =  rand(99, 9999) . time() . $image->getClientOriginalName();
                $image->storeAs('public/sellers', $logo);
            }


            $seller = Seller::create([
                'user_id' => $user->id,
                'city' => $request->city,
                'about' => $request->about,
                'docs' => isset($docs) ? $docs : NULL,
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
                $body = "Hello and welcome to Gearz your request is pending at this time and will take 2-3 business days, upon approval you can start listing all your Vehicles we appreciate your patience
                <br>
                Thank you, Gearz
                ";
                dispatch(new SendEmail($user , $subject , $body ));

            }

            return response()->json(['success'=> true , 'message' => 'User Registered successfully' , 'user' => $user ]);

        }else{
            return response()->json(['success'=> false , 'message' => 'Email already exists'] , 422 );
        }
    }

    public function checkCurrentUser(Request $request)
    {
        $user = User::find($request->user_id);
        // dd($request->last_login);
        $diff = Carbon::now()->diffInHours(Carbon::parse($request->last_login));
        // dd($diff);
        if($user && $diff < 25 && (($user->type == 'seller' && $user->status == 'approved') || $user->type == 'viewer')){
            // $user->last_login = Carbon::now();
            return response()->json(['success'=> true] , 200 );
        }else{
            return response()->json(['success'=> false , 'message' => 'No User Found'] , 403 );
        }
    }

        public function logout() {
            Auth::user()->fcm_token = null;
            Auth::user()->save();
            Auth::user()->tokens->each(function($token, $key) {
                $token->delete();
            });

            return response()->json([ 'success' => true , 'message' => 'Successfully logged out']);
        }


    public function FCMToken($type) {
        if($type == 'save'){
            $user = User::find(auth()->user()->id);
            $user->fcm_token = request('fcm_token');
            $user->save();
            return response()->json([ 'success' => true , 'message' => 'FCM Token saved successfully']);
        }else{
            return response()->json([ 'success' => true , 'message' => 'Undefined Action']);
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
        //
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
        //
    }
}
