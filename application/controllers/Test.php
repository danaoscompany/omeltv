<?php

include "FCM.php";

class Test extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        $this->session->set_userdata("user_id", '123');
        //echo "Current user id: (" . $this->session->userdata('user_id') . ")";
    }
   
   	public function index() {
   	}
   	
   	public function db() {
   		echo json_encode($this->db->query("SELECT * FROM `users`")->result_array());
   	}
   	
   	public function cookie() {
   		$value = $this->input->get('value');
   		$this->session->set_userdata("user_id", $value);
   	}
   	
   	private function ip_is_private ($ip) {
    $pri_addrs = array (
                      '10.0.0.0|10.255.255.255', // single class A network
                      '172.16.0.0|172.31.255.255', // 16 contiguous class B network
                      '192.168.0.0|192.168.255.255', // 256 contiguous class C network
                      '169.254.0.0|169.254.255.255', // Link-local address also refered to as Automatic Private IP Addressing
                      '127.0.0.0|127.255.255.255' // localhost
                     );

    $long_ip = ip2long ($ip);
    if ($long_ip != -1) {

        foreach ($pri_addrs AS $pri_addr) {
            list ($start, $end) = explode('|', $pri_addr);

             // IF IS PRIVATE
             if ($long_ip >= ip2long ($start) && $long_ip <= ip2long ($end)) {
                 return true;
             }
        }
    }

    return false;
	}
	
	public function ip_check() {
		echo $this->ip_is_private("34.101.188.127")?"true":"false";
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
