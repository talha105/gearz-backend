<?php

namespace App\Http\Controllers\Api;

use App\Report;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::with('user' , 'listing')->latest()->paginate(20);
        return response()->json(['success' => true , 'reports' => $reports ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $report = Report::create([
            'user_id' => $request->user_id,
            'listing_id' => $request->listing_id,
            'reason' => $request->reason,
            'text' => $request->text,
        ]);

        if($report){

            if($report->user){
                $subject = "Thank you for your inquiry";
                $body = "
                <div style='font-size:16px; font-weight: bold;'>Hi {$report->user->name},</div>
                <br>
                <div style='font-size:14px;'>Thank you for your inquiry, we will get back to you as soon as possible.</div>
                <br>
                <div style='font-size:14px;'>We strive to provide the highest quality service and care deeply about how our work affects customers like you. We would love it if you could send us an email and tell us what we can do to make our app better</div>
                <br>
                <div style='font-size:14px;'>Thank you for taking the time out of your day. We really appreciate it!</div>
                <br>
                <div style='font-size:14px;'>Best regards, Gearz support team</div>
                ";

                dispatch(new SendEmail($report->user , $subject , $body ));
            }


            return response()->json(['status' => 'Review updated'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'Unexpected error happend'] , 422);
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
        $report = Report::find($id);

        if($report && $report->delete()){
            return response()->json(['status' => 'report deleted'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'report Not Found'] , 422);
        }
    }

    public function updateStatus(Request $request)
    {
        $report = Report::find($request->report_id);
        $report->status = $request->status;
        if($report->save()){
            return response()->json(['status' => 'report updated'  ]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'Unexpected error happend'] , 422);
        }
    }


}
