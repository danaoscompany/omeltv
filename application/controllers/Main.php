<?php

class Main extends CI_Controller {
	
	public function index() {
		if ($this->session->logged_in == 1) {
			header('Location: http://localhost/omeltv/notification');
		} else {
			header('Location: http://localhost/omeltv/login');
		}
	}
}
