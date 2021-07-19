<?php

class Friendrequest extends CI_Controller
{

	public function index()
	{
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('friend_request', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/omeltv/login');
		}
	}
}
