<?php

include "Util.php";
include "FCM.php";

class Admin extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('admin', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://116.193.190.184/omeltv/login');
		}
	}

	public function add() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('admin/add', array(
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
			$this->load->view('admin/edit', array(
				'adminID' => $adminID,
				'editedAdminID' => $id
			));
		} else {
			header('Location: http://116.193.190.184/omeltv/login');
		}
	}

	public function login() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$this->db->where('email', $email);
		$users = $this->db->get('admins')->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			if ($user['password'] == $password) {
				$this->session->set_userdata(array(
					'logged_in' => 1,
					'user_id' => intval($user['id']),
					'name' => $user['name']
				));
				echo json_encode(array('response_code' => 1,
					'user_id' => intval($user['id'])));
			} else {
				echo json_encode(array('response_code' => -1));
			}
		} else {
			echo json_encode(array('response_code' => -2));
		}
	}

	public function get_notifications() {
		if ($this->session->logged_in == 1) {
			echo json_encode($this->db->query("SELECT * FROM `admin_notifications` ORDER BY `date` DESC LIMIT 2")
				->result_array());
		} else {
			echo json_encode(array(
				'error' => 'not_authenticated'
			));
		}
	}

	public function add_notification() {
		$adminID = intval($this->input->post('user_id'));
		$content = $this->input->post('content');
		$date = $this->input->post('date');
		$this->db->insert('notifications', array(
			'admin_id' => $adminID,
			'content' => $content,
			'date' => $date
		));
		$notificationID = intval($this->db->insert_id());
		FCM::send_message('/topics/general', 1, 'New notification from admin',
			strlen($content)>30?substr($content, 0, 30) . "...":$content, array(
				'notification_id' => $notificationID,
				'content' => $content,
				'date' => $date
			));
	}

	public function update_notification() {
		$id = intval($this->input->post('id'));
		$content = $this->input->post('content');
		$date = $this->input->post('date');
		$this->db->where('id', $id);
		$this->db->update('notifications', array(
			'content' => $content,
			'date' => $date
		));
		FCM::send_message('/topics/general', 2, 'New notification update from admin',
			strlen($content)>30?substr($content, 0, 30) . "...":$content, array(
				'notification_id' => $id,
				'content' => $content,
				'date' => $date
			));
	}

	public function delete_notification() {
		$id = intval($this->input->post('id'));
		$this->db->query("DELETE FROM `notifications` WHERE `id`=" . $id);
	}

	public function get_notification_by_id() {
		$id = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `notifications` WHERE `id`=" . $id)->row_array());
	}

	public function get_questions() {
		$questions = $this->db->query("SELECT * FROM `questions` ORDER BY `date` DESC")->result_array();
		for ($i=0; $i<sizeof($questions); $i++) {
			$questions[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $questions[$i]['user_id'])->row_array();
		}
		echo json_encode($questions);
	}

	public function search_questions() {
		$keyword = $this->input->post('keyword');
		$questions = $this->db->query("SELECT * FROM `questions` WHERE `question` LIKE '%" . $keyword . "%' ORDER BY `date` DESC")->result_array();
		for ($i=0; $i<sizeof($questions); $i++) {
			$questions[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $questions[$i]['user_id'])->row_array();
		}
		echo json_encode($questions);
	}

	public function get_question_by_id() {
		$id = intval($this->input->post('id'));
		$question = $this->db->query("SELECT * FROM `questions` WHERE `id`=" . $id)->row_array();
		$question['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $question['user_id'])->row_array();
		echo json_encode($question);
	}

	public function answer_question() {
		$id = intval($this->input->post('id'));
		$answer = $this->input->post('answer');
		$question = $this->db->query("SELECT * FROM `questions` WHERE `id`=" . $id)->row_array();
		$userID = $question['user_id'];
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID)->row_array();
		$this->db->query("UPDATE `questions` SET `answer`='" . $answer . "', `answered`=1 WHERE `id`=" . $id);
		$fcmID = $user['fcm_id'];
		FCM::send_message($fcmID, 3, 'Your answer has arrived', 'Click to check your answer for your question',
			array(
				'question_id' => "" . $id,
				'question' => $question,
				'answer' => $answer
			));
	}

	public function delete_question() {
		$id = intval($this->input->post('id'));
		$this->db->query("DELETE FROM `questions` WHERE `id`=" . $id);
	}

	public function get_admins() {
		echo json_encode($this->db->query("SELECT * FROM `admins` ORDER BY `name` ASC")->result_array());
	}

	public function delete_admin() {
		$id = intval($this->input->post('id'));
		$this->db->query("DELETE FROM `admins` WHERE `id`=" . $id);
	}

	public function add_admin() {
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$profilePictureChanged = intval($this->input->post('profile_picture_changed'));
		$adminCount = $this->db->query("SELECT * FROM `admins` WHERE `email`='" . $email . "'")->num_rows();
		if ($adminCount > 0) {
			echo json_encode(
				array(
					'response_code' => -1
				)
			);
		} else {
			if ($profilePictureChanged == 1) {
				$config['upload_path']          = './userdata/';
				$config['allowed_types']        = '*';
				$config['max_size']             = 2147483647;
				$config['file_name']            = Util::generateUUIDv4();
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('file')) {
					$this->db->insert('admins', array(
						'name' => $name,
						'email' => $email,
						'password' => $password,
						'profile_picture' => $this->upload->data()['file_name']
					));
					echo json_encode(
						array(
							'response_code' => 1
						)
					);
				} else {
					echo json_encode($this->upload->display_errors());
				}
			} else {
				$this->db->insert('admins', array(
					'name' => $name,
					'email' => $email,
					'password' => $password
				));
				echo json_encode(
					array(
						'response_code' => 1
					)
				);
			}
		}
	}

	public function edit_admin() {
		$id = intval($this->input->post('id'));
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$emailChanged = intval($this->input->post('email_changed'));
		$profilePictureChanged = intval($this->input->post('profile_picture_changed'));
		if ($emailChanged == 1) {
			$adminCount = $this->db->query("SELECT * FROM `admins` WHERE `email`='" . $email . "'")->num_rows();
			if ($adminCount > 0) {
				echo json_encode(
					array(
						'response_code' => -1
					)
				);
				return;
			}
		}
		if ($profilePictureChanged == 1) {
			$config['upload_path']          = './userdata/';
			$config['allowed_types']        = '*';
			$config['max_size']             = 2147483647;
			$config['file_name']            = Util::generateUUIDv4();
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('file')) {
				$this->db->where('id', $id);
				$this->db->update('admins', array(
					'name' => $name,
					'email' => $email,
					'password' => $password,
					'profile_picture' => $this->upload->data()['file_name']
				));
				echo json_encode(
					array(
						'response_code' => 1
					)
				);
			} else {
				echo json_encode($this->upload->display_errors());
			}
		} else {
			$this->db->where('id', $id);
			$this->db->update('admins', array(
				'name' => $name,
				'email' => $email,
				'password' => $password
			));
			echo json_encode(
				array(
					'response_code' => 1
				)
			);
		}
	}

	public function get_admin_by_id() {
		$id = intval($this->input->post('id'));
		$admin = $this->db->query("SELECT * FROM `admins` WHERE `id`=" . $id)->row_array();
		echo json_encode($admin);
	}

	public function get_premium_by_id() {
		$id = intval($this->input->post('id'));
		$premium = $this->db->query("SELECT * FROM `premiums` WHERE `id`=" . $id)->row_array();
		echo json_encode($premium);
	}

	public function update_fcm_id() {
		$adminID = intval($this->input->post('id'));
		$fcmID = $this->input->post('fcm_id');
		$this->db->query("UPDATE `admins` SET `fcm_id`='" . $fcmID . "' WHERE `id`=" . $adminID);
	}

	public function get_cities() {
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		echo json_encode($this->db->query("SELECT * FROM `cities` ORDER BY `name`LIMIT " . $start . "," . $length)->result_array());
	}

	public function add_city() {
		$name = $this->input->post('name');
		$this->db->insert('cities', array(
			'name' => $name
		));
	}

	public function edit_city() {
		$id = intval($this->input->post('id'));
		$name = $this->input->post('name');
		$this->db->where('id', $id);
		$this->db->update('cities', array(
			'name' => $name
		));
	}

	public function get_city_by_id() {
		$id = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `cities` WHERE `id`=" . $id)->row_array());
	}

	public function get_credit_prices() {
		echo json_encode($this->db->query("SELECT * FROM `credit_prices` ORDER BY `credits`")->result_array());
	}

	public function get_premium_prices() {
		echo json_encode($this->db->query("SELECT * FROM `premiums` ORDER BY `days`")->result_array());
	}

	public function add_credit_price() {
		$productID = $this->input->post('product_id');
		$credits = $this->input->post('credits');
		$price = $this->input->post('price');
		$this->db->insert('credit_prices', array(
			'product_id' => $productID,
			'credits' => $credits,
			'price' => $price
		));
	}

	public function edit_credit_price() {
		$id = $this->input->post('id');
		$productID = $this->input->post('product_id');
		$credits = $this->input->post('credits');
		$price = $this->input->post('price');
		$this->db->where('id', $id);
		$this->db->update('credit_prices', array(
			'product_id' => $productID,
			'credits' => $credits,
			'price' => $price
		));
	}

	public function delete_credit_price() {
		$id = $this->input->post('id');
		$this->db->query("DELETE FROM `credit_prices` WHERE `id`=" . $id);
	}

	public function delete_premium() {
		$id = $this->input->post('id');
		$this->db->query("DELETE FROM `premiums` WHERE `id`=" . $id);
	}

	public function delete_reported_user() {
		$id = $this->input->post('id');
		$this->db->query("DELETE FROM `reported_users` WHERE `id`=" . $id);
	}

	public function get_credit_price_by_id() {
		$id = $this->input->post('id');
		echo json_encode($this->db->query("SELECT * FROM `credit_prices` WHERE `id`=" . $id)->row_array());
	}

	public function get_premium_price_by_id() {
		$id = $this->input->post('id');
		echo json_encode($this->db->query("SELECT * FROM `prices` WHERE `id`=" . $id)->row_array());
	}

	public function add_premium() {
		$productCode = $this->input->post('product_code');
		$nameEn = $this->input->post('name_en');
		$nameId = $this->input->post('name_id');
		$descEn = $this->input->post('desc_en');
		$descId = $this->input->post('desc_id');
		$days = $this->input->post('days');
		$price = $this->input->post('price');
		$this->db->insert('premiums', array(
			'product_id' => $productCode,
			'name_en' => $nameEn,
			'name_id' => $nameId,
			'desc_en' => $descEn,
			'desc_id' => $descId,
			'days' => $days,
			'price' => $price
		));
	}

	public function update_premium() {
		$id = $this->input->post('id');
		$productCode = $this->input->post('product_code');
		$nameEn = $this->input->post('name_en');
		$nameId = $this->input->post('name_id');
		$descEn = $this->input->post('desc_en');
		$descId = $this->input->post('desc_id');
		$days = $this->input->post('days');
		$price = $this->input->post('price');
		$this->db->where('id', $id);
		$this->db->update('premiums', array(
			'product_id' => $productCode,
			'name_en' => $nameEn,
			'name_id' => $nameId,
			'desc_en' => $descEn,
			'desc_id' => $descId,
			'days' => $days,
			'price' => $price
		));
	}

	public function edit_premium_price() {
		$id = $this->input->post('id');
		$productID = $this->input->post('product_id');
		$month = $this->input->post('month');
		$price = $this->input->post('price');
		$benefitsId = $this->input->post('benefits_id');
		$benefitsEn = $this->input->post('benefits_en');
		$benefitsZh = $this->input->post('benefits_zh');
		$this->db->where('id', $id);
		$this->db->update('prices', array(
			'product_id' => $productID,
			'month' => $month,
			'price' => $price,
			'benefits_id' => $benefitsId,
			'benefits_en' => $benefitsEn,
			'benefits_zh' => $benefitsZh
		));
	}

	public function get_quotes() {
		$quotes = $this->db->query("SELECT * FROM `quotes` ORDER BY `date` DESC")->result_array();
		echo json_encode($quotes);
	}

	public function add_quote() {
		$name = $this->input->post('name');
		$quoteIn = $this->input->post('quote_in');
		$quoteEn = $this->input->post('quote_en');
		$quoteZh = $this->input->post('quote_zh');
		$date = $this->input->post('date');
		$this->db->insert('quotes', array(
			'name' => $name,
			'quote_in' => $quoteIn,
			'quote_en' => $quoteEn,
			'quote_zh' => $quoteZh,
			'date' => $date
		));
	}

	public function edit_quote() {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$quoteIn = $this->input->post('quote_in');
		$quoteEn = $this->input->post('quote_en');
		$quoteZh = $this->input->post('quote_zh');
		$date = $this->input->post('date');
		$this->db->where('id', $id);
		$this->db->update('quotes', array(
			'name' => $name,
			'quote_in' => $quoteIn,
			'quote_en' => $quoteEn,
			'quote_zh' => $quoteZh,
			'date' => $date
		));
	}

	public function delete_quote() {
		$id = $this->input->post('id');
		$this->db->query("DELETE FROM `quotes` WHERE `id`=" . $id);
	}

	public function get_quote_by_id() {
		$id = $this->input->post('id');
		echo json_encode($this->db->query("SELECT * FROM `quotes` WHERE `id`=" . $id)->row_array());
	}

	public function get_settings() {
		echo json_encode($this->db->query("SELECT * FROM `settings` LIMIT 1")->row_array());
	}

	public function update_free_questions_per_month() {
		$freeQuestionsPerMonth = $this->input->post('free_questions_per_month');
		$this->db->query("UPDATE `settings` SET `free_questions_per_month`=" . $freeQuestionsPerMonth);
	}

	public function update_howto() {
		$howtoId = str_replace('\'', '\\\'', $this->input->post('howto_id'));
		$howtoEn = str_replace('\'', '\\\'', $this->input->post('howto_en'));
		$howtoZh = str_replace('\'', '\\\'', $this->input->post('howto_zh'));
		$this->db->query("UPDATE `settings` SET `howto_in`='" . $howtoId . "', `howto_en`='" . $howtoEn . "', `howto_zh`='" . $howtoZh . "'");
	}

	public function update_terms() {
		$termsIn = str_replace('\'', '\\\'', $this->input->post('terms_in'));
		$termsEn = str_replace('\'', '\\\'', $this->input->post('terms_en'));
		$termsZh = str_replace('\'', '\\\'', $this->input->post('terms_zh'));
		$this->db->query("UPDATE `settings` SET `terms_in`='" . $termsIn . "', `terms_en`='" . $termsEn . "', `terms_zh`='" . $termsZh . "'");
	}

	public function update_privacy_policy() {
		$privacyPolicyIn = str_replace('\'', '\\\'', $this->input->post('privacy_policy_in'));
		$privacyPolicyEn = str_replace('\'', '\\\'', $this->input->post('privacy_policy_en'));
		$privacyPolicyZh = str_replace('\'', '\\\'', $this->input->post('privacy_policy_zh'));
		$this->db->query("UPDATE `settings` SET `privacy_policy_in`='" . $privacyPolicyIn . "', `privacy_policy_en`='" . $privacyPolicyEn . "', `privacy_policy_zh`='" . $privacyPolicyZh . "'");
	}

	public function get_users() {
		echo json_encode($this->db->query("SELECT * FROM `users` ORDER BY `name`")->result_array());
	}

	public function search_users() {
		$keyword = $this->input->post('keyword');
		echo json_encode($this->db->query("SELECT * FROM `users` WHERE `name` LIKE '%" . $keyword . "%' ORDER BY `name`")->result_array());
	}

	public function add_user() {
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$password = $this->input->post('password');
		$birthPlace = $this->input->post('birth_place');
		$birthday = $this->input->post('birthday');
		$gender = $this->input->post('gender');
		$job = $this->input->post('job');
		$relationshipStatus = $this->input->post('relationship_status');
		$emailVerified = intval($this->input->post('email_verified'));
		$phoneVerified = intval($this->input->post('phone_verified'));
		$profileCompleted = intval($this->input->post('profile_completed'));
		$credits = intval($this->input->post('credits'));
		$premium = intval($this->input->post('premium'));
		$monthPremium = intval($this->input->post('month_premium'));
		$profilePictureChanged = intval($this->input->post('profile_picture_changed'));
		$userCount = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->num_rows();
		if ($userCount > 0) {
			echo json_encode(array(
				'response_code' => -1
			));
			return;
		}
		$userCount = $this->db->query("SELECT * FROM `users` WHERE `phone`='" . $phone . "'")->num_rows();
		if ($userCount > 0) {
			echo json_encode(array(
				'response_code' => -2
			));
			return;
		}
		if ($profilePictureChanged == 1) {
			$config['upload_path']          = './userdata/';
			$config['allowed_types']        = '*';
			$config['max_size']             = 2147483647;
			$config['file_name']            = Util::generateUUIDv4();
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('file')) {
				$this->db->insert('users', array(
					'name' => $name,
					'email' => $email,
					'phone' => $phone,
					'password' => $password,
					'birth_place' => $birthPlace,
					'birthday' => $birthday,
					'gender' => $gender,
					'job' => $job,
					'relationship_status' => $relationshipStatus,
					'email_verified' => $emailVerified,
					'phone_verified' => $phoneVerified,
					'profile_completed' => $profileCompleted,
					'credits' => $credits,
					'premium' => $premium,
					'premium_months' => $monthPremium,
					'profile_picture' => $this->upload->data()['file_name']
				));
				echo json_encode(array(
					'response_code' => 1
				));
			} else {
				echo json_encode($this->upload->display_errors());
			}
		} else {
			$this->db->insert('users', array(
				'name' => $name,
				'email' => $email,
				'phone' => $phone,
				'password' => $password,
				'birth_place' => $birthPlace,
				'birthday' => $birthday,
				'gender' => $gender,
				'job' => $job,
				'relationship_status' => $relationshipStatus,
				'email_verified' => $emailVerified,
				'phone_verified' => $phoneVerified,
				'profile_completed' => $profileCompleted,
				'credits' => $credits,
				'premium' => $premium,
				'premium_months' => $monthPremium
			));
			echo json_encode(array(
				'response_code' => 1
			));
		}
	}

	public function update_user() {
		$id = intval($this->input->post('id'));
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$emailChanged = intval($this->input->post('email_changed'));
		$phone = $this->input->post('phone');
		$phoneChanged = intval($this->input->post('phone_changed'));
		$password = $this->input->post('password');
		$birthPlace = $this->input->post('birth_place');
		$birthday = $this->input->post('birthday');
		$gender = $this->input->post('gender');
		$job = $this->input->post('job');
		$relationshipStatus = $this->input->post('relationship_status');
		$emailVerified = intval($this->input->post('email_verified'));
		$phoneVerified = intval($this->input->post('phone_verified'));
		$profileCompleted = intval($this->input->post('profile_completed'));
		$credits = intval($this->input->post('credits'));
		$premium = intval($this->input->post('premium'));
		$monthPremium = intval($this->input->post('month_premium'));
		$profilePictureChanged = intval($this->input->post('profile_picture_changed'));
		if ($emailChanged == 1) {
			$userCount = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->num_rows();
			if ($userCount > 0) {
				echo json_encode(array(
					'response_code' => -1
				));
				return;
			}
		}
		if ($phoneChanged == 1) {
			$userCount = $this->db->query("SELECT * FROM `users` WHERE `phone`='" . $phone . "'")->num_rows();
			if ($userCount > 0) {
				echo json_encode(array(
					'response_code' => -2
				));
				return;
			}
		}
		if ($profilePictureChanged == 1) {
			$config['upload_path']          = './userdata/';
			$config['allowed_types']        = '*';
			$config['max_size']             = 2147483647;
			$config['file_name']            = Util::generateUUIDv4();
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('file')) {
				$this->db->where('id', $id);
				$this->db->update('users', array(
					'name' => $name,
					'email' => $email,
					'phone' => $phone,
					'password' => $password,
					'birth_place' => $birthPlace,
					'birthday' => $birthday,
					'gender' => $gender,
					'job' => $job,
					'relationship_status' => $relationshipStatus,
					'email_verified' => $emailVerified,
					'phone_verified' => $phoneVerified,
					'profile_completed' => $profileCompleted,
					'credits' => $credits,
					'premium' => $premium,
					'premium_months' => $monthPremium,
					'profile_picture' => $this->upload->data()['file_name']
				));
				echo json_encode(array(
					'response_code' => 1
				));
			} else {
				echo json_encode($this->upload->display_errors());
			}
		} else {
			$this->db->where('id', $id);
			$this->db->update('users', array(
				'name' => $name,
				'email' => $email,
				'phone' => $phone,
				'password' => $password,
				'birth_place' => $birthPlace,
				'birthday' => $birthday,
				'gender' => $gender,
				'job' => $job,
				'relationship_status' => $relationshipStatus,
				'email_verified' => $emailVerified,
				'phone_verified' => $phoneVerified,
				'profile_completed' => $profileCompleted,
				'credits' => $credits,
				'premium' => $premium,
				'premium_months' => $monthPremium
			));
			echo json_encode(array(
				'response_code' => 1
			));
		}
	}

	public function delete_user() {
		$id = intval($this->input->post('id'));
		$this->db->query("DELETE FROM `users` WHERE `id`=" . $id);
	}

	public function get_user_by_id() {
		$id = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `users` WHERE `id`=" . $id)->row_array());
	}
	
	public function reset_purchases() {
		$users = $this->db->get('users')->result_array();
		for ($i=0; $i<sizeof($users); $i++) {
			$user = $users[$i];
			if (intval($user['premium']) == 1) {
				$lastPremiumPurchase = $user['last_premium_purchase'];
				$premiumMonths = intval($user['premium_months']);
				$d1 = new DateTime(substr($lastPremiumPurchase, 0, strpos($lastPremiumPurchase, " ")));
				$d2 = new DateTime();
				$interval = $d2->diff($d1);
				$diffMonths = intval($interval->format('%y')) * 12 + intval($interval->format('%m'));
				if ($diffMonths >= $premiumMonths) {
					$this->db->query("UPDATE `users` SET `premium`=0, `premium_months`=0 WHERE `id`=" . $user['id']);
				}
			}
			$questionsAskedMonthly = intval($user['questions_asked_monthly']);
			if ($premium == 1 && $questionsAskedMonthly >= 10) {
				$this->db->query("UPDATE `users` SET `premium`=0 WHERE `id`=" . $userID);
			} else if ($premium == 3 && $questionsAskedMonthly >= 30) {
				$this->db->query("UPDATE `users` SET `premium`=0 WHERE `id`=" . $userID);
			} else if ($premium == 6 && $questionsAskedMonthly >= 60) {
				$this->db->query("UPDATE `users` SET `premium`=0 WHERE `id`=" . $userID);
			} else if ($premium == 12 && $questionsAskedMonthly >= 120) {
				$this->db->query("UPDATE `users` SET `premium`=0 WHERE `id`=" . $userID);
			}
		}
	}

	public function get_donations() {
		echo json_encode($this->db->get('donations')->result_array());
	}

	public function delete_donation() {
		$id = $this->input->post('id');
		$this->db->query("DELETE FROM `donations` WHERE `id`=" . $id);
	}

	public function add_donation() {
		$name = $this->input->post('name');
		$bank = $this->input->post('bank');
		$accountNumber = $this->input->post('account_number');
		$this->db->insert('donations', array(
			'name' => $name,
			'bank' => $bank,
			'account_number' => $accountNumber
		));
	}

	public function update_donation() {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$bank = $this->input->post('bank');
		$accountNumber = $this->input->post('account_number');
		$this->db->where('id', $id);
		$this->db->update('donations', array(
			'name' => $name,
			'bank' => $bank,
			'account_number' => $accountNumber
		));
	}

	public function get_donation() {
		$id = $this->input->post('id');
		echo json_encode($this->db->query("SELECT * FROM `donations` WHERE `id`=" . $id)->row_array());
	}

	public function get_contacts() {
		echo json_encode($this->db->query("SELECT * FROM `contacts`")->result_array());
	}

	public function add_contact() {
		$type = $this->input->post('type');
		$number = $this->input->post('number');
		$this->db->insert('contacts', array(
			'type' => $type,
			'number' => $number
		));
	}

	public function delete_contact() {
		$id = $this->input->post('id');
		$this->db->query("DELETE FROM `contacts` WHERE `id`=" . $id);
	}

	public function get_contact() {
		$id = $this->input->post('id');
		echo json_encode($this->db->query("SELECT * FROM `contacts` WHERE `id`=" . $id)->row_array());
	}

	public function update_contact() {
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$number = $this->input->post('number');
		$this->db->where('id', $id);
		$this->db->update('contacts', array(
			'type' => $type,
			'number' => $number
		));
	}

	public function update_settings() {
		$loginHelpEn = $this->input->post('login_help_en');
		$loginHelpId = $this->input->post('login_help_id');
		$signupHelpEn = $this->input->post('signup_help_en');
		$signupHelpId = $this->input->post('signup_help_id');
		$premiumDescEn = $this->input->post('premium_desc_en');
		$premiumDescId = $this->input->post('premium_desc_id');
		$aboutEn = $this->input->post('about_en');
		$aboutId = $this->input->post('about_id');
		$welcomePremiumEn = $this->input->post('welcome_premium_en');
		$welcomePremiumId = $this->input->post('welcome_premium_id');
		$maxMaleUses = $this->input->post('max_male_uses');
		$maxFemaleUses = $this->input->post('max_female_uses');
		$maxFreeDirectCall = $this->input->post('max_free_direct_call');
		$this->db->update('settings', array(
			'login_help_en' => $loginHelpEn,
			'login_help_id' => $loginHelpId,
			'signup_help_en' => $signupHelpEn,
			'signup_help_id' => $signupHelpId,
			'premium_desc_en' => $premiumDescEn,
			'premium_desc_id' => $premiumDescId,
			'about_en' => $aboutEn,
			'about_id' => $aboutId,
			'welcome_premium_en' => $welcomePremiumEn,
			'welcome_premium_id' => $welcomePremiumId,
			'max_male_uses' => $maxMaleUses,
			'max_female_uses' => $maxFemaleUses,
			'max_free_direct_call' => $maxFreeDirectCall
		));
	}

	public function get_activities() {
		$activities = $this->db->query("SELECT * FROM `activities` ORDER BY `date` DESC")->result_array();
		for ($i=0; $i<sizeof($activities); $i++) {
			$activities[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $activities[$i]['user_id'])->row_array();
			$activities[$i]['opponent'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $activities[$i]['opponent_user_id'])->row_array();
		}
		echo json_encode($activities);
	}

	public function delete_activity() {
		$id = $this->input->post('id');
		$this->db->query("DELETE FROM `activities` WHERE `id`=" . $id);
	}

	public function get_blocked_users() {
		$blockedUsers = $this->db->query("SELECT * FROM `blocked_users` ORDER BY `date` DESC")->result_array();
		for ($i=0; $i<sizeof($blockedUsers); $i++) {
			$blockedUsers[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $blockedUsers[$i]['user_id'])->row_array();
			$blockedUsers[$i]['blocked_user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $blockedUsers[$i]['blocked_user_id'])->row_array();
		}
		echo json_encode($blockedUsers);
	}

	public function delete_blocked_user() {
		$id = $this->input->post('id');
		$this->db->query("DELETE FROM `blocked_users` WHERE `id`=" . $id);
	}

	public function get_friends() {
		$friends = $this->db->query("SELECT * FROM `friends` ORDER BY `added_date` DESC")->result_array();
		for ($i=0; $i<sizeof($friends); $i++) {
			$friends[$i]['user_1'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $friends[$i]['user_id_1'])->row_array();
			$friends[$i]['user_2'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $friends[$i]['user_id_2'])->row_array();
		}
		echo json_encode($friends);
	}

	public function get_friend_requests() {
		$friends = $this->db->query("SELECT * FROM `friend_requests` ORDER BY `date` DESC")->result_array();
		for ($i=0; $i<sizeof($friends); $i++) {
			$friends[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $friends[$i]['user_id'])->row_array();
			$friends[$i]['added_user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $friends[$i]['added_user_id'])->row_array();
		}
		echo json_encode($friends);
	}

	public function delete_friend() {
		$id = intval($this->input->post('id'));
		$this->db->query("DELETE FROM `friends` WHERE `id`=" . $id);
	}

	public function delete_friend_request() {
		$id = intval($this->input->post('id'));
		$this->db->query("DELETE FROM `friend_requests` WHERE `id`=" . $id);
	}

	public function get_reported_users() {
		$reportedUsers = $this->db->query("SELECT * FROM `reported_users` ORDER BY `date` DESC")->result_array();
		for ($i=0; $i<sizeof($reportedUsers); $i++) {
			$reportedUsers[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $reportedUsers[$i]['user_id'])->row_array();
			$reportedUsers[$i]['blocked_user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $reportedUsers[$i]['blocked_user_id'])->row_array();
		}
		echo json_encode($reportedUsers);
	}

	public function block_user() {
		$userID = intval($this->input->post('user_id'));
		$blockedUserID = intval($this->input->post('blocked_user_id'));
		$date = $this->input->post('date');
		$this->db->insert('blocked_users', array(
			'user_id' => $userID,
			'blocked_user_id' => $blockedUserID,
			'date' => $date
		));
	}
}
