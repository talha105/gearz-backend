<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PushNotification;
use App\FCMToken;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PushNotificationController extends Controller
{
    public function index()
    {

        try {
            $notifications = PushNotification::latest()->paginate(15);
            return response()->json([
                'success' => true,
                'notifications' => $notifications
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wront',
                'exception' => $e->getMessage()
            ], 422);
        }
    }

    public function store(){
        try {

            $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

            $notification = PushNotification::create([
                'title' => request('title'),
                'description' => request('description'),
                'ar_title' => request('ar_title') ? request('ar_title') : $tr->setSource('en')->setTarget('ar')->translate(request('title')),
                'ar_description' => request('ar_description') ? request('ar_description') : $tr->setSource('en')->setTarget('ar')->translate(request('description')),

            ]);

            $response = FCMToken::SendNotification($notification);
            // Log::info($response);
            // self::sendNotifcationToUsers($notification);
            return response()->json([
                'success' => true,
                'notification' => $notification,
                'response' => $response,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wront',
                'exception' => $e->getMessage()
            ], 422);
        }
    }

    public function resend(){
        try {

            $current = PushNotification::find(request('id'));
            $notification = PushNotification::create([
                'title' => $current->title,
                'description' => $current->description,
                'ar_title' => $current->ar_title,
                'ar_description' => $current->ar_description,
            ]);

            $response = FCMToken::SendNotification($notification);

            // self::sendNotifcationToUsers();
            return response()->json([
                'success' => true,
                'response' => $response,
                'notification' => $notification,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wront',
                'exception' => $e->getMessage()
            ], 422);
        }
    }

    public static function sendNotifcationToUsers($notification)
    {
        // $notification
    }
}
