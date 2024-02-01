<?php

namespace App\Http\Traits;


trait PushNotificationsTrait {


    public function sendPushNotification($fcm_token, $title, $message, $id = null,$tag='') {

        $accesstoken = env('FCM_KEY');
        $url = "https://fcm.googleapis.com/fcm/send";
        $header = [
        'authorization: key=' . $accesstoken,
            'content-type: application/json'
        ];

        $postdata = '{
            "to" : "' . $fcm_token . '",
                "notification" : {
                    "title":"' . $title . '",
                    "body" : "' . $message . '"
                    "tag":"' . $tag . '",
                    "id" : "'.$id.'",
                },
            "data" : {
                "id" : "'.$id.'",
                "title":"' . $title . '",
                "description" : "' . $message . '",
                "text" : "' . $message . '",
                "is_read": 0,
                "tag" : "' . $tag . '",
              }
        }';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
