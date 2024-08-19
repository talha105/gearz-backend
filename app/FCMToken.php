<?php

namespace App;


use App\User;
use LaravelFCM\Facades\FCM;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;


class FCMToken{
    public static function SendNotification($notification){

        $tokens = User::
            whereNotNull('fcm_token')->
            pluck('fcm_token')->toArray();

        $response = Http::
            acceptJson()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->post(env('NOTIFICATION_URL') , [
                'to' => [implode(",", $tokens)],
                'title' => $notification->title,
                'body' => $notification->description,
            ])->json();

        Log::info($response);
        return $response;

        // $optionBuilder = new OptionsBuilder();
        // $optionBuilder->setTimeToLive(60*20);

        // $notificationBuilder = new PayloadNotificationBuilder($notification->title);
        // $notificationBuilder->setBody($notification->description)
        //                     ->setSound('default');

        // $dataBuilder = new PayloadDataBuilder();
        // $dataBuilder->addData(['notification' => $notification ]);

        // $option = $optionBuilder->build();
        // $notification = $notificationBuilder->build();
        // $data = $dataBuilder->build();

        // // You must change it to get your tokens
        // $tokens = User::
        //             whereNotNull('fcm_token')->
        //             pluck('fcm_token')->toArray();

        // $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        // $downstreamResponse->numberSuccess();
        // $downstreamResponse->numberFailure();
        // $downstreamResponse->numberModification();

        // // return Array - you must remove all this tokens in your database
        // $downstreamResponse->tokensToDelete();

        // // return Array (key : oldToken, value : new token - you must change the token in your database)
        // $downstreamResponse->tokensToModify();

        // // return Array - you should try to resend the message to the tokens in the array
        // $downstreamResponse->tokensToRetry();

        // // return Array (key:token, value:error) - in production you should remove from your database the tokens present in this array
        // $downstreamResponse->tokensWithError();

        // return $downstreamResponse;
    }
}
