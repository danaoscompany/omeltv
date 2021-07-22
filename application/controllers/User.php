<?php

include "FCM.php";
include "Util.php";

class User extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        $sessionUserID = $this->input->post('_session_user_id');
        $sessionDate = $this->input->post('_session_date');
        //$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $sessionDate . "' WHERE `id`=" . $sessionUserID);
    }

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('user', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://116.193.190.184/omeltv/login');
		}
	}

	public function edit() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$id = intval($this->input->post('id'));
			$this->load->view('user/edit', array(
				'adminID' => $adminID,
				'editedUserID' => $id
			));
		} else {
			header('Location: http://116.193.190.184/omeltv/login');
		}
	}
	
	public function login_with_email_password() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `password`='" . $password . "'")->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$user['response_code'] = 1;
			echo json_encode($user);
			$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $this->input->post('_session_date') . "' WHERE `id`=" . $user['id']);
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function login_with_token() {
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$token = $this->input->post('token');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `phone`='" . $phone . "' AND `login_token`='" . $token . "'")->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$user['response_code'] = 1;
			echo json_encode($user);
			$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $this->input->post('_session_date') . "' WHERE `id`=" . $user['id']);
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function login_with_phone() {
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `phone`='" . $phone . "'")->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$user['response_code'] = 1;
			echo json_encode($user);
			$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $this->input->post('_session_date') . "' WHERE `id`=" . $user['id']);
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function login_with_facebook() {
		$email = $this->input->post('email');
		$token = $this->input->post('token');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `login_token`='" . $token . "'")->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$user['response_code'] = 1;
			echo json_encode($user);
			$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $this->input->post('_session_date') . "' WHERE `id`=" . $user['id']);
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function login_with_google() {
		$email = $this->input->post('email');
		$token = $this->input->post('token');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `login_token`='" . $token . "'")->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$user['response_code'] = 1;
			echo json_encode($user);
			$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $this->input->post('_session_date') . "' WHERE `id`=" . $user['id']);
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function signup() {
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$this->db->insert('users', array(
			'name' => $name,
			'email' => $email,
			'phone' => $phone
		));
	}
	
	public function update_login_token() {
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$token = $this->input->post('token');
		$this->db->query("UPDATE `users` SET `login_token`='" . $token . "' WHERE `email`='" . $email . "' AND `phone`='" . $phone . "'");
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `phone`='" . $phone . "'")->result_array();
		if (sizeof($users) > 0) {
			echo json_encode($users[0]);
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function update_login_token_with_facebook() {
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$token = $this->input->post('token');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->result_array();
		if (sizeof($users) > 0) {
			echo json_encode($users[0]);
			$this->db->query("UPDATE `users` SET `name`='" . $name . "', `login_token`='" . $token . "' WHERE `email`='" . $email . "'");
			$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $this->input->post('_session_date') . "' WHERE `id`=" . $user['id']);
		} else {
			$this->db->insert('users', array(
				'name' => $name,
				'email' => $email,
				'login_token' => $token
			));
			$id = $this->db->insert_id();
			$users = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $id)->result_array();
			echo json_encode($users[0]);
			$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $this->input->post('_session_date') . "' WHERE `id`=" . $user['id']);
		}
	}
	
	public function update_login_token_with_google() {
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$token = $this->input->post('token');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->result_array();
		if (sizeof($users) > 0) {
			echo json_encode($users[0]);
			$this->db->query("UPDATE `users` SET `name`='" . $name . "', `login_token`='" . $token . "' WHERE `email`='" . $email . "'");
			$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $this->input->post('_session_date') . "' WHERE `id`=" . $user['id']);
		} else {
			$this->db->insert('users', array(
				'name' => $name,
				'email' => $email,
				'login_token' => $token
			));
			$id = $this->db->insert_id();
			$users = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $id)->result_array();
			echo json_encode($users[0]);
			$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $this->input->post('_session_date') . "' WHERE `id`=" . $user['id']);
		}
	}
	
	public function update_user_location() {
		$userID = intval($this->input->post('user_id'));
		$latitude = doubleval($this->input->post('latitude'));
		$longitude = doubleval($this->input->post('longitude'));
		$this->db->query("UPDATE `users` SET `latitude`=" . $latitude . ", `longitude`=" . $longitude. " WHERE `id`=" . $userID);
	}
	
	public function update_user_info() {
		$userID = intval($this->input->post('user_id'));
		$latitude = doubleval($this->input->post('latitude'));
		$longitude = doubleval($this->input->post('longitude'));
		$androidID = $this->input->post('android_id');
		$countryCode = $this->input->post('country_code');
		$this->db->query("UPDATE `users` SET `latitude`=" . $latitude . ", `longitude`=" . $longitude. ", `android_id`='" . $androidID . "' WHERE `id`=" . $userID);
		$this->db->query("UPDATE `users` SET `country_code`='" . $countryCode . "' WHERE `id`=" . $userID . " AND `country_code`=NULL");
		echo "UPDATE `users` SET `country_code`='" . $countryCode . "' WHERE `id`=" . $userID . " AND `country_code` IS NULL";
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
		$topics = $this->db->query("SELECT * FROM `topics` WHERE `type`='public' AND `date`<='" . $date . "' ORDER BY `date` DESC LIMIT 10")->result_array();
		echo json_encode($topics);
	}
	
	public function get_private_topics() {
		$userID = intval($this->input->post('user_id'));
		$topics = $this->db->query("SELECT * FROM `topics` WHERE `type`='private' AND `user_id`=" . $userID . " ORDER BY `date` DESC")->result_array();
		echo json_encode($topics);
	}
	
	public function find_nearest_partners() {
		$lat = doubleval($this->input->post('lat'));
		$lng = doubleval($this->input->post('lng'));
		$category = $this->input->post('category');
		$countryCode = strtolower($this->input->post('country_code'));
		$userID = intval($this->input->post('user_id'));
		$date = $this->input->post('date');
		$skippedUserIDs = json_decode($this->input->post('skipped_user_ids'), true);
		$this->db->query("UPDATE `users` SET `is_searching`=1, `last_searching_date`='" . $date . "' WHERE `id`=" . $userID);
		array_push($skippedUserIDs, $userID);
		$skippedIDs = "";
		if (sizeof($skippedUserIDs) > 0) {
			$skippedIDs = "(";
			for ($i=0; $i<sizeof($skippedUserIDs); $i++) {
				$skippedIDs .= ($skippedUserIDs[$i].", ");
			}
			if (sizeof($skippedUserIDs) > 0) {
				$skippedIDs = substr($skippedIDs, 0, strlen($skippedIDs)-2);
			}
			$skippedIDs .= ")";
		} else {
			$skippedIDs = "(-1)";
		}
		if ($category == 'all' || $category == 'both') {
			/*$partners = $this->db->query("SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id` NOT IN " . $skippedIDs . " AND `id` `is_searching`=1 AND `last_searching_date` IS NOT NULL AND `last_searching_date` BETWEEN DATE_SUB('" . $date . "', INTERVAL 1 MINUTE) AND '" . $date . "' ORDER BY distance;")->result_array();*/
			$partners = $this->db->query("SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id`!=" . $userID . " AND `id` NOT IN " . $skippedIDs . " AND `is_searching`=1 AND `country_code`='" . $countryCode . "' AND (`user_find_candidate`=0 OR `candidate_user_id`=" . $userID . ") ORDER BY RAND();")->result_array();
			if (sizeof($partners) > 0) {
				$partners[0]['command'] = "SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id` NOT IN " . $skippedIDs . " AND `is_searching`=1 AND `country_code`='" . $countryCode . "' AND `user_find_candidate`=0 ORDER BY RAND();";
			}
		} else {
			/*$partners = $this->db->query("SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id` NOT IN " . $skippedIDs . " AND `gender`='" . $category . "' AND `is_searching`=1 AND `last_searching_date` IS NOT NULL AND `last_searching_date` BETWEEN DATE_SUB('" . $date . "', INTERVAL 1 MINUTE) AND '" . $date . "' ORDER BY distance;")->result_array();*/
			$partners = $this->db->query("SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id`!=" . $userID . " AND `id` NOT IN " . $skippedIDs . " AND `gender`='" . $category . "' AND `is_searching`=1 AND `country_code`='" . $countryCode . "' AND (`user_find_candidate`=0 OR `candidate_user_id`=" . $userID . ") ORDER BY RAND();")->result_array();
			if (sizeof($partners) > 0) {
				$partners[0]['command'] = "SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id` NOT IN " . $skippedIDs . " AND `gender`='" . $category . "' AND `is_searching`=1 AND `country_code`='" . $countryCode . "' AND `user_find_candidate`=0 ORDER BY RAND();";
			}
		}
		/* FOR TEST ONLY */
		/*if ($userID == 9) {
			$partners = $this->db->query("SELECT * FROM `users` WHERE `id`=8")->result_array();
		}*/
		/*if (sizeof($partners) <= 0) {
			$partners = $this->db->query("SELECT * FROM `users` WHERE `id`!=" . $userID . " AND `id` NOT IN " . $skippedIDs . " AND `gender`='" . $category . "' AND `is_searching`=1 AND `country_code`='" . $countryCode . "' ORDER BY RAND();")->result_array();
		}*/
		//echo "SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id` NOT IN " . $skippedIDs . " AND `gender`='" . $category . "' AND `is_searching`=1 AND `country_code`='" . $countryCode . "' ORDER BY distance;";
		/*if (sizeof($partners) > 0) {
			$partners[0]['query'] = "SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id` NOT IN " . $skippedIDs . " AND `gender`='" . $category . "' AND `is_searching`=1 AND `country_code`='" . $countryCode . "' ORDER BY distance;";
			$partners[0]['category'] = $category;
		}*/
		echo json_encode($partners);
	}
	
	public function done_finding_partner() {
		$userID = intval($this->input->post('user_id'));
		$this->db->query("UPDATE `users` SET `is_searching`=0, `last_searching_date`=NULL WHERE `id`=" . $userID);
	}
	
	public function start_video_call() {
		$callerUserID = intval($this->input->post('caller_user_id'));
		$receiverUserID = intval($this->input->post('receiver_user_id'));
		/*$this->db->query("UPDATE `users` WHERE `id`=" . $callerUserID);
		$this->db->query("UPDATE `users` WHERE `id`=" . $receiverUserID);*/
		$receiver = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $receiverUserID)->row_array();
		FCM::send_message($receiver['fcm_id'], 1, "You have incoming call", "Click to connect", array(
			'caller_user_id' => "" . $callerUserID,
			'receiver_user_id' => "" . $receiverUserID
		));
	}
	
	public function watch_live_stream() {
		$fromUserID = intval($this->input->post('from_user_id'));
		$toUserID = intval($this->input->post('to_user_id'));
		$fcmID = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $toUserID)->row_array()['fcm_id'];
		FCM::send_message($fcmID, 5, "", "", array(
			'user_id' => $fromUserID
		));
	}
	
	public function update_websocket_id() {
		$webSocketID = $this->input->post('websocket_id');
		$userID = intval($this->input->post('user_id'));
		$this->db->query("UPDATE `users` SET `websocket_id`='" . $webSocketID . "' WHERE `id`=" . $userID);
	}
	
	public function get_websocket_id_by_email() {
		$email = $this->input->post('email');
		echo $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->row_array()['websocket_id'];
	}
	
	public function get_websocket_id_by_user_id() {
		$userID = $this->input->post('user_id');
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID)->row_array();
		if ($user != NULL) {
			echo $user['websocket_id'];
		}
	}
	
	public function request_receiver_websocket_id() {
		$callerUserID = intval($this->input->post('caller_user_id'));
		$callerWebsocketID = $this->input->post('caller_websocket_id');
		$receiverUserID = intval($this->input->post('receiver_user_id'));
		$receiver = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $receiverUserID)->row_array();
		FCM::send_message($receiver['fcm_id'], 2, "Initializing call", "", array(
			'caller_user_id' => "" . $callerUserID,
			'caller_websocket_id' => $callerWebsocketID,
			'receiver_user_id' => "" . $receiverUserID
		));
	}
	
	public function respond_receiver_websocket_id() {
		$callerUserID = intval($this->input->post('caller_user_id'));
		$receiverUserID = intval($this->input->post('receiver_user_id'));
		$receiverWebsocketID = $this->input->post('receiver_websocket_id');
		$caller = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $callerUserID)->row_array();
		FCM::send_message($caller['fcm_id'], 3, "Initializing call", "", array(
			'caller_user_id' => "" . $callerUserID,
			'receiver_user_id' => "" . $receiverUserID,
			'websocket_id' => $receiverWebsocketID
		));
	}
	
	public function get_user_by_id() {
		$id = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `users` WHERE `id`=" . $id)->row_array());
	}
	
	public function send_live_video_message() {
		$senderUserID = intval($this->input->post('sender_user_id'));
		$receiverUserID = intval($this->input->post('receiver_user_id'));
		$message = $this->input->post('message');
		$receiver = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $receiverUserID)->row_array();
		$sender = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $senderUserID)->row_array();
		$receiver = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $receiverUserID)->row_array();
		if ($receiver != NULL) {
			FCM::send_message($receiver['fcm_id'], 4, "New message", "", array(
				'sender_user_id' => "" . $senderUserID,
				'receiver_user_id' => "" . $receiverUserID,
				'message' => $message,
				'sender' => json_encode($sender),
				'receiver' => json_encode($receiver)
			));
		}
		echo json_encode(array(
			'sender_user_id' => $senderUserID,
			'receiver_user_id' => $receiverUserID,
			'message' => $message,
			'sender' => $sender,
			'receiver' => $receiver
		));
	}
	
	public function set_is_searching() {
		$userID = $this->input->post('user_id');
		$isSearching = $this->input->post('is_searching');
		$this->db->where('id', $userID);
		$this->db->update('users', array(
			'is_searching' => $isSearching
		));
	}
	
	public function is_user_exists() {
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `phone`='" . $phone . "'")->result_array();
		echo json_encode(sizeof($users));
	}
	
	public function send_verification_code() {
		$email = $this->input->post('email');
		$verificationCode = $this->input->post('verification_code');
		Util::send_email_2($email, "Your verification code: " . $verificationCode, "Please enter the following code in the available field: <b>" . $verificationCode . "</b>");
	}
	
	public function get_user_by_phone() {
		$phone = $this->input->post('phone');
		$users = $this->db->query("SELECT * FROM `users` WHERE `phone`='" . $phone . "'")->result_array();
		echo json_encode($users);
	}
	
	public function get_user_by_email() {
		$email = $this->input->post('email');
		$user = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->row_array();
		echo json_encode($user);
	}
	
	public function complete_profile() {
		$email = $this->input->post('email');
		$username = $this->input->post('username');
		$displayName = $this->input->post('display_name');
		$gender = $this->input->post('gender');
		$bio = $this->input->post('bio');
		$profilePictureSet = intval($this->input->post('profile_picture_set'));
		if ($profilePictureSet == 1) {
			$config = array(
				'upload_path' => './userdata/',
				'allowed_types' => "*",
				'overwrite' => TRUE
			);
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('file')) {
				$this->db->where('email', $email);
				$this->db->update('users', array(
					'profile_picture' => $this->upload->data()['file_name'],
					'username' => $username,
					'name' => $displayName,
					'gender' => $gender,
					'bio' => $bio,
					'profile_completed' => 1
				));
			} else {
				echo json_encode($this->upload->display_errors());
			}
		} else {
			$this->db->where('email', $email);
			$this->db->update('users', array(
				'username' => $username,
				'name' => $displayName,
				'gender' => $gender,
				'bio' => $bio,
				'profile_completed' => 1
			));
		}
		$user = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->row_array();
		echo json_encode($user);
	}
	
	public function edit_profile() {
		$email = $this->input->post('email');
		$username = $this->input->post('username');
		$displayName = $this->input->post('display_name');
		$bio = $this->input->post('bio');
		$profilePictureSet = intval($this->input->post('profile_picture_set'));
		if ($profilePictureSet == 1) {
			$config = array(
				'upload_path' => './userdata/',
				'allowed_types' => "*",
				'overwrite' => TRUE
			);
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('file')) {
				$this->db->where('email', $email);
				$this->db->update('users', array(
					'profile_picture' => $this->upload->data()['file_name'],
					'username' => $username,
					'name' => $displayName,
					'bio' => $bio,
					'profile_completed' => 1
				));
			} else {
				echo json_encode($this->upload->display_errors());
			}
		} else {
			$this->db->where('email', $email);
			$this->db->update('users', array(
				'username' => $username,
				'name' => $displayName,
				'bio' => $bio,
				'profile_completed' => 1
			));
		}
		$user = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->row_array();
		echo json_encode($user);
	}
	
	public function get_premium_desc() {
	    echo $this->db->query("SELECT * FROM `settings`")->row_array()['premium_desc'];
	}
	
	public function get_premiums() {
	    echo json_encode($this->db->query("SELECT * FROM `premiums`")->result_array());
	}
	
	public function get_settings() {
	    echo json_encode($this->db->query("SELECT * FROM `settings`")->row_array());
	}
	
	public function get_premium_by_product_id() {
		$productID = $this->input->post('product_id');
		echo json_encode($this->db->query("SELECT * FROM `premiums` WHERE `product_id`='".$productID."'")->row_array());
	}
	
	public function get_blocked_users() {
		$userID = intval($this->input->post('user_id'));
		$blockedUsers = $this->db->query("SELECT * FROM `blocked_users` WHERE `user_id`=" . $userID)->result_array();
		for ($i=0; $i<sizeof($blockedUsers); $i++) {
			$blockedUsers[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $blockedUsers[$i]['blocked_user_id'])
				->row_array();
		}
		echo json_encode($blockedUsers);
	}
	
	public function get_blocked_user_count() {
		$userID = intval($this->input->post('user_id'));
		echo $this->db->query("SELECT * FROM `blocked_users` WHERE `user_id`=" . $userID)->num_rows();
	}
	
	public function unblock_user() {
		$userID = intval($this->input->post('user_id'));
		$blockedUserID = intval($this->input->post('blocked_user_id'));
		$this->db->query("DELETE FROM `blocked_users` WHERE `user_id`=" . $userID . " AND `blocked_user_id`=" . $blockedUserID);
	}
	
	public function purchase_premium() {
		$userID = intval($this->input->post('user_id'));
		$productID = $this->input->post('product_id');
		$premiumStart = $this->input->post('premium_start');
		$this->db->where('id', $userID);
		$this->db->update('users', array(
			'premium_start' => $premiumStart,
			'subscribed_product_id' => $productID
		));
	}
	
	public function delete_account() {
		$userID = intval($this->input->post('user_id'));
		$this->db->query("DELETE FROM `users` WHERE `id`=" . $userID);
	}
	
	public function get_chats() {
		$userID = intval($this->input->post('user_id'));
		$chats = $this->db->query("SELECT * FROM `chats` WHERE `sender_id`=" . $userID . " OR `receiver_id`=" . $userID)->result_array();
		for ($i=0; $i<sizeof($chats); $i++) {
			$chats[$i]['sender'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $chats[$i]['sender_id'])->row_array();
			$chats[$i]['receiver'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $chats[$i]['receiver_id'])->row_array();
		}
		echo json_encode($chats);
	}
	
	public function get_chat_messages() {
		$userID = intval($this->input->post('user_id'));
		$chatID = intval($this->input->post('chat_id'));
		$chat = $this->db->query("SELECT * FROM `chats` WHERE `id`=" . $chatID)->row_array();
		$opponent = array();
		if ($userID == intval($chat['sender_id'])) {
			$opponent = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $chat['receiver_id'])->row_array();
		} else {
			$opponent = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $chat['sender_id'])->row_array();
		}
		$messages = $this->db->query("SELECT * FROM `chat_messages` WHERE `chat_id`=" . $chatID . " ORDER BY `date` DESC")->result_array();
		for ($i=0; $i<sizeof($messages); $i++) {
			$messages[$i]['sender'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $messages[$i]['sender_id'])->row_array();
			$messages[$i]['receiver'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $messages[$i]['receiver_id'])->row_array();
		}
		echo json_encode(array(
			'messages' => $messages,
			'opponent_info' => $opponent
		));
	}
	
	public function get_random_chat_messages() {
		$userID = intval($this->input->post('user_id'));
		$chatID = intval($this->input->post('chat_id'));
		$chat = $this->db->query("SELECT * FROM `random_chats` WHERE `id`=" . $chatID)->row_array();
		$opponent = array();
		if ($userID == intval($chat['sender_id'])) {
			$opponent = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $chat['receiver_id'])->row_array();
		} else {
			$opponent = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $chat['sender_id'])->row_array();
		}
		$messages = $this->db->query("SELECT * FROM `chat_messages` WHERE `chat_id`=" . $chatID . " ORDER BY `date` DESC")->result_array();
		for ($i=0; $i<sizeof($messages); $i++) {
			$messages[$i]['sender'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $messages[$i]['sender_id'])->row_array();
			$messages[$i]['receiver'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $messages[$i]['receiver_id'])->row_array();
		}
		echo json_encode(array(
			'messages' => $messages,
			'opponent_info' => $opponent
		));
	}
	
	public function send_message() {
		$chatID = intval($this->input->post('chat_id'));
		$senderID = intval($this->input->post('sender_id'));
		$receiverID = intval($this->input->post('receiver_id'));
		$date = $this->input->post('date');
		$message = $this->input->post('message');
		$this->db->insert('chat_messages', array(
			'chat_id' => $chatID,
			'sender_id' => $senderID,
			'receiver_id' => $receiverID,
			'message_type' => 'text',
			'message' =>  $message,
			'date' => $date
		));
		$messageID = intval($this->db->insert_id());
		echo json_encode($this->db->query("SELECT * FROM `chat_messages` WHERE `id`=" . $messageID)->row_array());
	}
	
	public function send_random_chat_message() {
		$chatID = intval($this->input->post('chat_id'));
		$senderID = intval($this->input->post('sender_id'));
		$receiverID = intval($this->input->post('receiver_id'));
		$date = $this->input->post('date');
		$message = $this->input->post('message');
		$this->db->insert('random_chat_messages', array(
			'chat_id' => $chatID,
			'sender_id' => $senderID,
			'receiver_id' => $receiverID,
			'message_type' => 'text',
			'message' =>  $message,
			'date' => $date
		));
		$messageID = intval($this->db->insert_id());
		echo json_encode($this->db->query("SELECT * FROM `random_chat_messages` WHERE `id`=" . $messageID)->row_array());
	}
	
	public function send_image() {
		$chatID = intval($this->input->post('chat_id'));
		$senderID = intval($this->input->post('sender_id'));
		$receiverID = intval($this->input->post('receiver_id'));
		$date = $this->input->post('date');
		$config = array(
			'upload_path' => './userdata/',
			'allowed_types' => "*",
			'overwrite' => TRUE
		);
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file')) {
			$this->db->insert('chat_messages', array(
				'chat_id' => $chatID,
				'sender_id' => $senderID,
				'receiver_id' => $receiverID,
				'message_type' => 'image',
				'message' =>  '',
				'image' => $this->upload->data()['file_name'],
				'date' => $date
			));
			$messageID = intval($this->db->insert_id());
			echo json_encode($this->db->query("SELECT * FROM `chat_messages` WHERE `id`=" . $messageID)->row_array());
		}
	}
	
	public function send_random_chat_image() {
		$chatID = intval($this->input->post('chat_id'));
		$senderID = intval($this->input->post('sender_id'));
		$receiverID = intval($this->input->post('receiver_id'));
		$date = $this->input->post('date');
		$config = array(
			'upload_path' => './userdata/',
			'allowed_types' => "*",
			'overwrite' => TRUE
		);
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file')) {
			$this->db->insert('random_chat_messages', array(
				'chat_id' => $chatID,
				'sender_id' => $senderID,
				'receiver_id' => $receiverID,
				'message_type' => 'image',
				'message' =>  '',
				'image' => $this->upload->data()['file_name'],
				'date' => $date
			));
			$messageID = intval($this->db->insert_id());
			echo json_encode($this->db->query("SELECT * FROM `random_chat_messages` WHERE `id`=" . $messageID)->row_array());
		}
	}
	
	public function report_user() {
		$userID = intval($this->input->post('user_id'));
		$blockedUserID = intval($this->input->post('blocked_user_id'));
		$reason = $this->input->post('reason');
		$date = $this->input->post('date');
		$this->db->insert('reported_users', array(
			'user_id' => $userID,
			'blocked_user_id' => $blockedUserID,
			'reason' => $reason,
			'date' => $date
		));
		echo "INSERT INTO `reported_users` (`user_id`, `blocked_user_id`, `reason`, `date`) VALUES (" . $userID . ", " . $blockedUserID . ", '" . $reason . "', '" . $date . "')";
	}
	
	public function add_friend() {
		$userID = intval($this->input->post('user_id'));
		$addedUserID = intval($this->input->post('added_user_id'));
		$date = $this->input->post('date');
		$addedFriends = $this->db->query("SELECT * FROM `friend_requests` WHERE `user_id`=" . $userID . " AND `added_user_id`=" . $addedUserID)->num_rows();
		if ($addedFriends <= 0) {
			$this->db->insert('friend_requests', array(
				'user_id' => $userID,
				'added_user_id' => $addedUserID,
				'date' => $date
			));
		}
	}
	
	public function unfriend() {
		$userID = intval($this->input->post('user_id'));
		$addedUserID = intval($this->input->post('added_user_id'));
		$addedFriends = $this->db->query("SELECT * FROM `friend_requests` WHERE `user_id`=" . $userID . " AND `added_user_id`=" . $addedUserID)->num_rows();
		if ($addedFriends > 0) {
			$this->db->query("DELETE FROM `friend_requests` WHERE `user_id`=" . $userID . " AND `added_user_id`=" . $addedUserID);
		}
	}
	
	public function is_friend_added() {
		$userID = intval($this->input->post('user_id'));
		$addedUserID = intval($this->input->post('added_user_id'));
		echo $this->db->query("SELECT * FROM `friend_requests` WHERE `user_id`=" . $userID . " AND `added_user_id`=" . $addedUserID)->num_rows();
	}
	
	public function get_total_friend_requests() {
		$userID = intval($this->input->post('user_id'));
		echo $this->db->query("SELECT * FROM `friend_requests` WHERE `added_user_id`=" . $userID)->num_rows();
	}
	
	public function get_friends() {
		$userID = intval($this->input->post('user_id'));
		$friends = $this->db->query("SELECT * FROM `friends` WHERE `user_id_1`=" . $userID . " OR `user_id_2`=" . $userID)->result_array();
		for ($i=0; $i<sizeof($friends); $i++) {
			if (intval($friends[$i]['user_id_1']) == $userID) {
				$friends[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $friends[$i]['user_id_2'])->row_array();
			} else if (intval($friends[$i]['user_id_2']) == $userID) {
				$friends[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $friends[$i]['user_id_1'])->row_array();
			}
		}
		echo json_encode($friends);
	}
	
	public function get_received_friend_requests() {
		$userID = intval($this->input->post('user_id'));
		$requests = $this->db->query("SELECT * FROM `friend_requests` WHERE `added_user_id`=" . $userID)->result_array();
		for ($i=0; $i<sizeof($requests); $i++) {
			$requests[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $requests[$i]['user_id'])->row_array();
		}
		echo json_encode($requests);
	}
	
	public function get_sent_friend_requests() {
		$userID = intval($this->input->post('user_id'));
		$requests = $this->db->query("SELECT * FROM `friend_requests` WHERE `user_id`=" . $userID)->result_array();
		for ($i=0; $i<sizeof($requests); $i++) {
			$requests[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $requests[$i]['added_user_id'])->row_array();
		}
		echo json_encode($requests);
	}
	
	public function reject_friend_request() {
		$userID = intval($this->input->post('user_id'));
		$addedUserID = intval($this->input->post('added_user_id'));
		$this->db->query("DELETE FROM `friend_requests` WHERE `user_id`=" . $userID . " AND `added_user_id`=" . $addedUserID);
	}
	
	public function accept_friend_request() {
		$userID = intval($this->input->post('user_id'));
		$addedUserID = intval($this->input->post('added_user_id'));
		$date = $this->input->post('date');
		$this->db->query("DELETE FROM `friend_requests` WHERE `user_id`=" . $userID . " AND `added_user_id`=" . $addedUserID);
		$this->db->insert('friends', array(
			'user_id_1' => $userID,
			'user_id_2' => $addedUserID,
			'added_date' => $date
		));
	}
	
	public function cancel_friend_request() {
		$userID = intval($this->input->post('user_id'));
		$addedUserID = intval($this->input->post('added_user_id'));
		$this->db->query("DELETE FROM `friend_requests` WHERE `user_id`=" . $userID . " AND `added_user_id`=" . $addedUserID);
	}
	
	public function add_activity() {
		$userID = intval($this->input->post('user_id'));
		$opponentUserID = intval($this->input->post('opponent_user_id'));
		$type = $this->input->post('type');
		$date = $this->input->post('date');
		if ($type == 'chat') {
			$activities = $this->db->query("SELECT * FROM `activities` WHERE `user_id`=" . $userID . " AND `opponent_user_id`=" . $opponentUserID . " AND `type`='" . $type . "' ORDER BY `date` DESC LIMIT 1")->result_array();
			if (sizeof($activities) > 0) {
				$activity = $activities[0];
				$diffHours = round((strtotime($activity['date']) - strtotime($date))/3600, 1);
				if ($diffHours > 1) {
					$this->db->insert('activities', array(
						'user_id' => $userID,
						'opponent_user_id' => $opponentUserID,
						'type' => $type,
						'date' => $date
					));
					return;
				}
			}
		}
		$this->db->insert('activities', array(
			'user_id' => $userID,
			'opponent_user_id' => $opponentUserID,
			'type' => $type,
			'date' => $date
		));
	}
	
	public function get_activities() {
		$userID = intval($this->input->post('user_id'));
		$activities = $this->db->query("SELECT * FROM `activities` WHERE `user_id`=" . $userID . " OR `opponent_user_id`=" . $userID)->result_array();
		for ($i=0; $i<sizeof($activities); $i++) {
			if (intval($activities[$i]['user_id']) == $userID) {
				$activities[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $activities[$i]['opponent_user_id'])->row_array();
			} else if (intval($activities[$i]['opponent_user_id']) == $userID) {
				$activities[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $activities[$i]['user_id'])->row_array();
			}
			if ($activities[$i]['user'] != NULL) {
				$isFriend = 0;
				$friends = $this->db->query("SELECT * FROM `friends` WHERE (`user_id_1`=" . $userID . " AND `user_id_2`=" . $activities[$i]['user']['id'] . ") OR (`user_id_1`=" . $activities[$i]['user']['id'] . " AND `user_id_2`=" . $userID . ")")->result_array();
				if (sizeof($friends) > 0) {
					$isFriend = 1;
				}
				$friendRequests = $this->db->query("SELECT * FROM `friend_requests` WHERE `user_id`=" . $userID . " AND `added_user_id`=" . $activities[$i]['user']['id'])->result_array();
				if (sizeof($friendRequests) > 0) {
					$isFriend = 1;
				}
				$activities[$i]['user']['is_friend'] = $isFriend;
			}
		}
		echo json_encode($activities);
	}
	
	public function get_chat() {
		$userID = intval($this->input->post('user_id'));
		$opponentUserID = intval($this->input->post('opponent_user_id'));
		$date = $this->input->post('date');
		$chats = $this->db->query("SELECT * FROM `chats` WHERE (`sender_id`=" . $userID . " AND `receiver_id`=" . $opponentUserID . ") OR (`sender_id`=" . $opponentUserID . " AND `receiver_id`=" . $userID . ")")->result_array();
		if (sizeof($chats) > 0) {
			echo json_encode($chats[0]);
		} else {
			$this->db->insert('chats', array(
				'sender_id' => $userID,
				'receiver_id' => $opponentUserID,
				'last_update' => $date
			));
			$id = intval($this->db->insert_id());
			$chats = $this->db->query("SELECT * FROM `chats` WHERE `id`=" . $id)->result_array();
			if (sizeof($chats) > 0) {
				echo json_encode($chats[0]);
			} else {
				echo json_encode(array());
			}
		}
	}
	
	public function get_random_chat() {
		$userID = intval($this->input->post('user_id'));
		$opponentUserID = intval($this->input->post('opponent_user_id'));
		$date = $this->input->post('date');
		$chats = $this->db->query("SELECT * FROM `random_chats` WHERE (`sender_id`=" . $userID . " AND `receiver_id`=" . $opponentUserID . ") OR (`sender_id`=" . $opponentUserID . " AND `receiver_id`=" . $userID . ")")->result_array();
		if (sizeof($chats) > 0) {
			echo json_encode($chats[0]);
		} else {
			$this->db->insert('random_chats', array(
				'sender_id' => $userID,
				'receiver_id' => $opponentUserID,
				'last_update' => $date
			));
			$id = intval($this->db->insert_id());
			$chats = $this->db->query("SELECT * FROM `random_chats` WHERE `id`=" . $id)->result_array();
			if (sizeof($chats) > 0) {
				echo json_encode($chats[0]);
			} else {
				echo json_encode(array());
			}
		}
	}
	
	public function create_topic() {
		$userID = intval($this->input->post('user_id'));
		$topic = $this->input->post('topic');
		$date = $this->input->post('date');
		$topic = strtolower($topic);
		$topics = $this->db->query("SELECT * FROM `topics` WHERE LOWER(`topic`) LIKE '%" . $topic . "%'")->result_array();
		if (sizeof($topics) > 0) {
			echo json_encode(array('response_code' => -1));
			return;
		}
		$this->db->insert('topics', array(
			'user_id' => $userID,
			'topic' => $topic,
			'type' => 'private',
			'date' => $date
		));
		$id = $this->db->insert_id();
		$topicObj = $this->db->query("SELECT * FROM `topics` WHERE `id`=" . $id)->row_array();
		$topicObj['response_code'] = 1;
		echo json_encode($topicObj);
	}
	
	public function update_looking_for() {
		$userID = intval($this->input->post('user_id'));
		$lookingFor = $this->input->post('looking_for');
		$this->db->where('id', $userID);
		$this->db->update('users', array(
			'looking_for' => $lookingFor
		));
	}
	
	public function get_max_free_uses() {
		$userID = intval($this->input->post('user_id'));
		$date = $this->input->post('date');
		$premium = $this->is_premium_($userID, $date);
		if ($premium) {
			echo json_encode(array(
				'male' => -1,
				'female' => -1
			));
		} else {
			$day = date('d', strtotime($date));
			$month = date('m', strtotime($date));
			$maxMaleUses = intval($this->db->get('settings')->row_array()['max_male_uses']);
			$maxFemaleUses = intval($this->db->get('settings')->row_array()['max_female_uses']);
			$freeUsesMale = $this->db->query("SELECT * FROM `max_use_statistics` WHERE `user_id`=" . $userID . " AND DAY(`date`)=" . $day . " AND MONTH(`date`)=" . $month . " AND `gender`='male'")->num_rows();
			$freeUsesFemale = $this->db->query("SELECT * FROM `max_use_statistics` WHERE `user_id`=" . $userID . " AND DAY(`date`)=" . $day . " AND MONTH(`date`)=" . $month . " AND `gender`='female'")->num_rows();
			echo json_encode(array(
				'male' => $maxMaleUses-$freeUsesMale,
				'female' => $maxFemaleUses-$freeUsesFemale
			));
		}
	}
	
	public function get_max_free_direct_calls() {
		$userID = intval($this->input->post('user_id'));
		$date = $this->input->post('date');
		$type = $this->input->post('type'); //video_call, audio_call, chat
		$premium = $this->is_premium_($userID, $date);
		if ($premium) {
			echo json_encode(array(
				'max_free_direct_calls' => -1
			));
		} else {
			$day = date('d', strtotime($date));
			$month = date('m', strtotime($date));
			$year = date('Y', strtotime($date));
			$hour = date('H', strtotime($date));
			$minute = date('i', strtotime($date));
			$maxFreeDirectCalls = intval($this->db->get('settings')->row_array()['max_free_direct_call']);
			$freeDirectCalls = $this->db->query("SELECT * FROM `activities` WHERE `user_id`=" . $userID . " AND DAY(`date`)=" . $day . " AND MONTH(`date`)=" . $month . " AND YEAR(`date`)=" . $year . " AND HOUR(`date`)=" . $hour . " AND `type`='" . $type . "'")->num_rows();
			echo json_encode(array(
				'max_free_direct_calls' => $maxFreeDirectCalls-$freeDirectCalls
			));
			//echo "SELECT * FROM `activities` WHERE `user_id`=" . $userID . " AND DAY(`date`)=" . $day . " AND MONTH(`date`)=" . $month . " AND YEAR(`date`)=" . $year . " AND HOUR(`date`)=" . $hour . " AND `type`='" . $type . "'";
		}
	}
	
	private function is_premium_($userID, $date) {
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID)->row_array();
		if (intval($user['premium']) == 1) {
			$subscribedProductID = $user['subscribed_product_id'];
			$premiumStart = $user['premium_start'];
			$premium = $this->db->query("SELECT * FROM `premiums` WHERE `product_id`='" . $subscribedProductID . "'")->row_array();
			$premiumDays = intval($premium['days']);
			$diffDays = round((strtotime($date)-strtotime($premiumStart))/(60*60*24));
			if ($diffDays > $premiumDays) {
				$this->db->query("UPDATE `users` SET `premium`=0 WHERE `id`=" . $userID);
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	public function update_free_use_statistics() {
		$userID = intval($this->input->post('user_id'));
		$gender = $this->input->post('gender');
		$date = $this->input->post('date');
		$this->db->insert('max_use_statistics', array(
			'user_id' => $userID,
			'gender' => $gender,
			'date' => $date
		));
	}
	
	public function is_premium() {
		$userID = intval($this->input->post('user_id'));
		$date = $this->input->post('date');
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID)->row_array();
		if (intval($user['premium']) == 1) {
			$subscribedProductID = $user['subscribed_product_id'];
			$premiumStart = $user['premium_start'];
			$premium = $this->db->query("SELECT * FROM `premiums` WHERE `product_id`='" . $subscribedProductID . "'")->row_array();
			$premiumDays = intval($premium['days']);
			$diffDays = round((strtotime($date)-strtotime($premiumStart))/(60*60*24));
			if ($diffDays > $premiumDays) {
				$this->db->query("UPDATE `users` SET `premium`=0 WHERE `id`=" . $userID);
				echo 0;
			} else {
				echo 1;
			}
		} else {
			echo 0;
		}
	}
	
	public function user_find_candidate() {
		$userID = intval($this->input->post('user_id'));
		$partnerUserID = intval($this->input->post('partner_user_id'));
		$this->db->query("UPDATE `users` SET `user_find_candidate`=1 WHERE `id`=" . $userID);
		$this->db->query("UPDATE `users` SET `user_find_candidate`=1 WHERE `id`=" . $partnerUserID);
		$this->db->query("UPDATE `users` SET `candidate_user_id`=" . $partnerUserID . " WHERE `id`=" . $userID);
	}
	
	public function user_remove_candidate() {
		$userID = intval($this->input->post('user_id'));
		$partnerUserID = intval($this->input->post('partner_user_id'));
		$this->db->query("UPDATE `users` SET `user_find_candidate`=0 WHERE `id`=" . $userID);
		$this->db->query("UPDATE `users` SET `user_find_candidate`=0 WHERE `id`=" . $partnerUserID);
		$this->db->query("UPDATE `users` SET `candidate_user_id`=0 WHERE `id`=" . $userID);
		$this->db->query("UPDATE `users` SET `candidate_user_id`=0 WHERE `id`=" . $partnerUserID);
	}
	
	public function reset_user_connection_data() {
		$userID = intval($this->input->post('user_id'));
		$this->db->query("UPDATE `users` SET `is_searching`=0, `user_find_candidate`=0, `candidate_user_id`=0 WHERE `id`=" . $userID);
	}
	
	public function should_user_be_skipped() {
		$userID = intval($this->input->post('user_id'));
		$partnerUserID = intval($this->input->post('partner_user_id'));
		$userCount = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID . " AND `candidate_user_id`=" . $partnerUserID)
			->num_rows();
		if ($userCount > 0) {
			echo json_encode(array('response_code' => 0));
			return;
		}
		$userCount = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $partnerUserID . " AND `candidate_user_id`=" . $userID)
			->num_rows();
		if ($userCount > 0) {
			echo json_encode(array('response_code' => 0));
			return;
		}
		$userCount = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID . " AND `user_find_candidate`=1 AND `candidate_user_id`!=" . $partnerUserID)->num_rows();
		if ($userCount > 0) {
			echo json_encode(array('response_code' => 1));
			return;
		}
		$userCount = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $partnerUserID . " AND `user_find_candidate`=1 AND `candidate_user_id`!=" . $userID)->num_rows();
		if ($userCount > 0) {
			echo json_encode(array('response_code' => 1));
			return;
		}
		echo json_encode(array('response_code' => 0));
	}
}
