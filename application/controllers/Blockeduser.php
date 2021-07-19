<?php

include "Util.php";
include "FCM.php";

class Blockeduser extends CI_Controller
{

	public function index()
	{
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('blocked_user', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://116.193.190.184/omeltv/login');
		}
	}
}
