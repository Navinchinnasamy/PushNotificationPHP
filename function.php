<?php 

	pushNotification('dfsdfs545s5df4s5fsfs5fs5', 'New Trip', 'A new trip was assigned to you!');

	function pushNotification($token, $title, $message)
    {
        $push = null;

        $push = new PushNotification(
            $title,
            $message
        );

        //getting the push from push object
        $mPushNotification = $push->getPush();

        //getting the token from database object
        $devicetoken = $token;

        //creating firebase class object
        $firebase = new Firebase();

        //sending push notification and displaying result
        $pushed = $firebase->send(array($devicetoken), $mPushNotification);
        return $pushed;
    }
?>