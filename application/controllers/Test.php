<?php

include "FCM.php";

class Test extends CI_Controller {
	
	public function fcm() {
		$url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = 'AAAAH_Srtxc:APA91bHlTnIwbcleCm96MiGvQy3Bh--MNYxD8KS7P_baU23-9mFJGV_D19Y659H68a7oVq_vGIQEWl6njwgKrkPv1r1azOPFXxmhV9lA_4oa5ZJefGJUda2x5VTbVWScQ-3I6DsMjAoa';
	    $notification = array('title' => 'Test title', 'body' => 'Test body', 'sound' => 'default', 'badge' => '1');
	    $arrayToSend = array('to' => 'cdAsV_nxScufATOIRmRX2t:APA91bGFPIPKOdWVZnBP92Ucqa-8lxdoQWYwMOINJSy8L5dGinnlrKTtnKZpPHaYfuAvGPZF1Zr00LzAgj-9zen3QYJiSBfXumOXstb3Imjvsn4PV6Q8nuwv2rtlEtL-54wvHoq399pF', 'notification' => $notification, 'priority'=>'high');
	    $json = json_encode($arrayToSend);
	    $headers = array();
	    $headers[] = 'Content-Type: application/json';
	    $headers[] = 'Authorization: key='. $serverKey;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	    //Send the request
	    $response = curl_exec($ch);
	    //Close request
	    if ($response === FALSE) {
	    	die('FCM Send Error: ' . curl_error($ch));
	    }
	    curl_close($ch);
	    echo $response;
	}
}
