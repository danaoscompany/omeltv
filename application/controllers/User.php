<?php

include "FCM.php";
include "Util.php";

class User extends CI_Controller {
	
	public function login() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `password`='" . $password . "'")->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$user['response_code'] = 1;
			echo json_encode($user);
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function update_fcm_id() {
		$userID = intval($this->input->post('user_id'));
		$fcmID = $this->input->post('fcm_id');
		$this->db->query("UPDATE `users` SET `fcm_id`='" . $fcmID . "' WHERE `id`=" . $userID);
	}
	
	public function find_opponent() {
		$userID = intval($this->input->post('user_id'));
		$videoUUID = Util::generateUUIDv4();
		$this->db->query("UPDATE `users` SET `busy`=1, `video_uuid`='" . $videoUUID . "' WHERE `id`=" . $userID);
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`!=" . $userID . " AND `busy`=0 ORDER BY RAND() LIMIT 1")->row_array();
		$this->db->query("UPDATE `users` SET `video_uuid`='" . $videoUUID . "' WHERE `id`=" . $user['id']);
		$fcmID = $user['fcm_id'];
		FCM::send_message($fcmID, 1, "Anda mendapatkan pasangan baru", "Klik untuk menghubungkan", array(
			'user_id' => $userID,
			'video_uuid' => $videoUUID
		));
		echo json_encode($user);
	}
}
