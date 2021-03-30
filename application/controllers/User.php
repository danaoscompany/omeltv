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
	
	public function update_user_location() {
		$userID = intval($this->input->post('user_id'));
		$latitude = doubleval($this->input->post('latitude'));
		$longitude = doubleval($this->input->post('longitude'));
		$this->db->query("UPDATE `users` SET `latitude`=" . $latitude . ", `longitude`=" . $longitude. " WHERE `id`=" . $userID);
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
	
	public function get_topics() {
		$date = $this->input->post('date');
		$topics = $this->db->query("SELECT * FROM `topics` WHERE `date`<='" . $date . "' ORDER BY `date` DESC LIMIT 10")->result_array();
		echo json_encode($topics);
	}
	
	public function find_nearest_partners() {
		$lat = doubleval($this->input->post('lat'));
		$lng = doubleval($this->input->post('lng'));
		$category = $this->input->post('category');
		$userID = intval($this->input->post('user_id'));
		if ($category == 'all') {
			$partners = $this->db->query("SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id`!=" . $userID . " HAVING distance < 25 ORDER BY distance;")->result_array();
		} else {
			$partners = $this->db->query("SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id`!=" . $userID . " AND `gender`='" . $category . "' HAVING distance < 25 ORDER BY distance;")->result_array();
		}
		echo json_encode($partners);
	}
	
	public function start_video_call() {
		$myUserID = intval($this->input->post('my_user_id'));
		$partnerUserID = intval($this->input->post('partner_user_id'));
		$videoUUID = Util::generateUUIDv4();
		$this->db->query("UPDATE `users` SET `video_uuid`='" . $videoUUID . "' WHERE `id`=" . $myUserID);
		$this->db->query("UPDATE `users` SET `video_uuid`='" . $videoUUID . "' WHERE `id`=" . $partnerUserID);
		$partner = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $partnerUserID)->row_array();
		FCM::send_message($partner['fcm_id'], 1, "You have incoming call", "Click to connect", array(
			'user_id' => $myUserID,
			'video_uuid' => $videoUUID
		));
		echo $videoUUID;
	}
}
