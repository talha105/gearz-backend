<?php

namespace App\Http\Controllers\Api;

use App\Review;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $reviews = Review::with('user')->latest()->get();
        $reviews = Review::latest()->paginate(20);
        $reviews->append('details');

        return response()->json(['success' => true , 'reviews' => $reviews ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $review = Review::updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'listing_id' => $request->listing_id,
            ],
            [
            'user_id' => auth()->user()->id,
            'text' => $request->text,
            'rating' => $request->rating,
            'listing_id' => $request->listing_id,
        ]);

        if($review->user){

            $subject = "Thank you for your feedback";
            $body = "
            <div style='font-size:16px; font-weight: bold;'>Hi {$review->user->name},</div>
            <br>
            <div style='font-size:14px;'>Thank you for your feedback, we will get back to you as soon as possible</div>
            <br>
            <div style='font-size:14px;'>We strive to provide the highest quality service and care deeply about how our work affects customers like you. We would love it if you could send us an email and tell us what we can do to make our app better</div>
            <br>
            <div style='font-size:14px;'>Thank you for taking the time out of your day. We really appreciate it!</div>
            <br>
            <div style='font-size:14px;'>Best regards, Gearz support team</div>
            ";
            dispatch(new SendEmail($review->user , $subject , $body ));
        }

        if($review && $review->user){
            return response()->json(['success' => true , 'message' => 'Review added Successfully' , 'review' => $review ]);
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
        $review = Review::find($id);

        if($review && $review->delete()){
            return response()->json(['status' => 'review deleted'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'review Not Found'] , 422);
        }
    }

    public function updateStatus(Request $request)
    {
        $review = Review::find($request->review_id);
        $review->status = $request->status;
        if($review->save()){
            return response()->json(['status' => 'Review updated'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'Unexpected error happend'] , 422);
        }
    }


}
