<?php

class Login extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			header('Location: http://116.193.190.184/omeltv/main');
		} else {
			$this->load->view('login');
		}
	}
}
