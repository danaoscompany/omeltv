<?php

include "FCM.php";

class Test extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        $this->session->set_userdata("user_id", '123');
        echo "Current user id: (" . $this->session->userdata('user_id') . ")";
    }
   
   	public function index() {
   	}
   	
   	public function cookie() {
   		$value = $this->input->get('value');
   		$this->session->set_userdata("user_id", $value);
   	}
	
	public function fcm() {
		$url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = 'AAAAH_Srtxc:APA91bHlTnIwbcleCm96MiGvQy3Bh--MNYxD8KS7P_baU23-9mFJGV_D19Y659H68a7oVq_vGIQEWl6njwgKrkPv1r1azOPFXxmhV9lA_4oa5ZJefGJUda2x5VTbVWScQ-3I6DsMjAoa';
	    $notification = array('title' => 'Test title', 'body' => 'Test body', 'sound' => 'default', 'badge' => '1');
	    $arrayToSend = array('to' => 'c31WG_nwQsysexQIozc-oN:APA91bE99kJQFAVLUKnJD9bWxEZtNuA5qD6U2Inxnpo1TOcni0aC7A_V0n58HUCOE9GIT2KLjSP_JzVNqxnBBYci1-8syM8dq7uh6pDEDeq6y6Y6eAYjNs53zLqyoli45IkdVPku6DND', 'priority'=>'high');
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
