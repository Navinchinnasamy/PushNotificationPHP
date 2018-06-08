<?php
/**
 * Created by PhpStorm.
 * User: navin
 * Date: 10/23/2017
 * Time: 9:48 AM
 */

class Firebase
{
    public function send($registration_ids, $message)
    {
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $message
        );

        return $this->sendPushNotification($fields);
    }

    /*
    * This function will make the actual curl request to firebase server
    * and then the message is sent
    */
    private function sendPushNotification($fields)
    {

        //importing the constant files

        //firebase server url to send the curl request
        $url = FIREBASE_URL;

        //building headers for the request
        $headers = array(
            'Authorization: key=' . FIREBASE_KEY,
            'Content-Type: application/json'
        );

        //Initializing curl to open a connection
        $ch = curl_init();
        if (strpos(HOST, '10.100.9') !== false) {
            $proxy = '10.100.1.99:8080';
        }
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        if (strpos(HOST, '10.100.9') !== false) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        //adding headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //adding the fields in json format
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        //finally executing the curl request
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        //Now close the connection
        curl_close($ch);

        //and return the result
        return $result;
    }
}