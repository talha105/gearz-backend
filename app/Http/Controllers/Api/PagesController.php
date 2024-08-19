<?php

namespace App\Http\Controllers\Api;

use App\Page;
use stdClass;
use App\Intervention_Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\Null_;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
        if($pages){
            return response()->json(['success' => true , 'pages' => $pages]);
        }else{
            return response()->json(['success' => false , 'message' => 'Unexpected error happend'] , 422);
        }
    }
    
    public function reportListing(Request $request){
        $id = $request->id;
        // report listing
        $superAdmins = \DB::table('users')->where('type', 'super-admin')->get();
        $admins = \DB::table('users')->where('type', 'admin')->get();
        foreach($superAdmins as $superAdmin){
                    $email = $superAdmin->email;
       $listing = \DB::table('listings')->where('id',$id)->first();
      $content = "$listing->title is Reported ID: $listing->id";
 \Mail::raw($content, function($message) use ($superAdmin) {
    $message->to($superAdmin->email);
    $message->subject('New Listing Report');
});
        foreach($admins as $superAdmin){
                    $email = $superAdmin->email;
       $listing = \DB::table('listings')->where('id',$id)->first();
      $content = "$listing->title is Reported ID: $listing->id";
 \Mail::raw($content, function($message) use ($superAdmin) {
    $message->to($superAdmin->email);
    $message->subject('New Listing Report');
});
return response()->json(['data' => '','success' => true]);
        }

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
    public function show(Request $request)
    {
        $page = Page::where('slug' , $request->slug)->first();

        return response()->json(['success' => true ,'page' => $page]);

    }
    public function getPage(Request $request)
    {
        $page = Page::where('slug' , $request->slug)->first();

        return response()->json(['success' => true ,'page' => $page]);

    }

    public function getSinglePage($slug)
    {
        $page = Page::where('slug' , $slug)->firstOrFail();
        return response()->json(['success' => true ,'page' => $page]);
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
        // dd($request->all());

        $page = Page::find($id);
        $page->content = $request->content;
        $page->save();
        return response()->json(['success' => true ,  'message' => 'Page updated successfully', 'page' => $page]);

    }

    public function updatePage(Request $request, $slug)
    {
        $image = $request->image;
        $name =  uniqid(true) . rand(99, 999) . "." . $image->getClientOriginalExtension();
        $image->storeAs('/public/pages', $name);


        $page = Page::where( 'slug' , $slug)->first();
        $page->{request('contentKey')} = $name;
        $page->save();

        return response()->json(['success' => true ,  'message' => 'Page updated successfully']);

    }


    public function updateMultiPage($slug, $action, $image = null)
    {
        $page = Page::where( 'slug' , $slug)->first();
        $images = $page->{request('contentKey')} ? json_decode($page->{request('contentKey')}) : [];

        if($action == 'add' && request('image')) {
            $image = request('image');
            $name =  uniqid(true) . rand(99, 999) . "." . $image->getClientOriginalExtension();
            $image->storeAs('/public/pages', $name);
            array_push($images, $name);
        }
        if($action == 'remove' && $image) {
            unset($images[array_search($image,$images)]);
            $images = array_values($images);
        }

        $page->{request('contentKey')} = json_encode($images);
        $page->save();

        return response()
            ->json([
                'success' => true ,
                'message' => 'Page updated successfully',
                'name' => isset($name) && $name ? $name : NULL,
            ]);

    }


    public function updateContactDetails(Request $request)
    {
        // dd($request->all());
        $__details = new stdClass();
        if($request->email){
            $__details->email = $request->email;
        }
        if($request->phone){
            $__details->phone = $request->phone;
        }
        // dd($__details , $request->all());
        $page = Page::find($request->page_id);
        if($__details->email || $__details->phone){
            $page->content = json_encode($__details);
        }else{
            $page->content = '';
        }
        $page->save();

        return response()->json(['success' => true ,  'message' => 'Page updated successfully', 'page' => $page]);

    }

    public function updateTermsDetails(Request $request)
    {

        $page = Page::find($request->page_id);
        $page->content = $request->content;
        $page->ar_content = $request->ar_content;
        $page->save();

        return response()->json(['success' => true ,  'message' => 'Page updated successfully', 'page' => $page]);

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
