<?php

class Login extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			header('Location: http://localhost/omeltv/main');
		} else {
			$this->load->view('login');
		}
	}
}
