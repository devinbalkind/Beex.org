<?php

class Ajax extends Controller { 
	
	function Ajax() {
		parent::Controller();
		
		$this->load->model('MItems');
		$this->data['header']['title'] = 'challenge';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
	}
	
	function cluster_validate() {
		
		if(!ctype_digit($_POST['cluster_code'])) {
			echo json_encode('false');
			return false;
		}
		
		$str = $_POST['cluster_code'] / 3459;
		if(!($this->MItems->getCluster($str)->num_rows() > 0)) {
			echo json_encode('false');
			return false;
		}
		else {
			
			$item =  $this->MItems->getCluster($str);
			$cluster = $item->row();
			foreach($cluster as $key=>$value) {
				if(substr($key,0,10) == 'cluster_ch') {
					$key = substr($key,11);
					if($key == 'address') {
						$key = 'address1';
					}					
					$ret[$key] = $value;
				}
			}
			
			$challenge_info = $this->session->userdata("challenge_info");
			$challenge_info['cluster_id'] = $str;
			$this->session->set_userdata($challenge_info);
			
			echo json_encode($ret);
			
			return true;
		}
		
	}
	

	function challenge_what() {
		$challenge_info_post = $_POST;
		$challenge_info = $this->session->userdata("challenge_info");
		foreach($challenge_info_post as $key=>$val) {
			$challenge_info[$key] = $val;
		}
		$this->session->set_userdata("challenge_info", $challenge_info);
		$this->session->set_userdata("challenge_creation_step", "when_where");
		echo json_encode(array('success' => true));  // or we could do some error validation, whatevs
				
		return;
	}
	
	function challenge_when_where() {
		$challenge_info_post = $_POST;
		$challenge_info = $this->session->userdata("challenge_info");
		foreach($challenge_info_post as $key=>$val) {
			$challenge_info[$key] = $val;
		}
		$this->session->set_userdata("challenge_info", $challenge_info);
		$this->session->set_userdata("challenge_creation_step", "why");
		echo json_encode(array('success' => true));  // or we could do some error validation, whatevs
		return;		
	}
	
	function challenge_why() {
		$challenge_info_post = $_POST;
		$challenge_info = $this->session->userdata("challenge_info");
		foreach($challenge_info_post as $key=>$val) {
			$challenge_info[$key] = $val;
		}
		$this->session->set_userdata("challenge_info", $challenge_info);
//		$this->session->unsetset_userdata("challenge_creation_step");// wtf? buggy
	
		
		
		$_POST = $challenge_info; 
		$edit_id = $this->session->userdata('edit_id');
		
				
		$_POST['user_id'] = $this->session->userdata['user_id'];
		
		// Process Teammate 
		if(@$_POST['teammate_email']) {
			$teammate = array('name'=>@$_POST['teammate_name'], 'email'=>$_POST['teammate_email']);
			unset($_POST['teammate_email'], $_POST['teammate_name']);
		}



		// these fields do not yet exist in the db...
		
		unset($_POST['partner_bool']);
		unset($_POST['partner_name']);
		unset($_POST['partner_email']);
		
		// Process Special Fields
		$_POST['challenge_completion'] = ($_POST['challenge_completion']) ? date('Y-m-d', strtotime($_POST['challenge_completion'])) : '';
		$_POST['challenge_fr_completed'] = ($_POST['challenge_fr_completed']) ? date('Y-m-d', strtotime($_POST['challenge_fr_completed'])) : '';
		$_POST['challenge_proof_upload'] = ($_POST['challenge_proof_upload']) ? date('Y-m-d', strtotime($_POST['challenge_proof_upload'])) : '';
		
		
		if(!$edit_id) {
			$_POST['created'] = date('Y-m-d H:i:s');
		}
		
		foreach($_POST as $key => $val) {
			if(!$val) {
				unset($_POST[$key]);	
			}
		}
		

		
		if(isset($edit_id) && $edit_id != '') {
			
			unset($_POST['user_id']);		
			$this->MItems->update('challenges', $edit_id, $_POST);
			$ret['challenge_id'] = $edit_id;
			$ret['success'] = true;
			$this->session->unset_userdata('edit_id');
			echo json_encode($ret);
			return;

		}
		elseif($challenge_id = $this->MItems->add('challenges', $_POST)) {
			$data['message'] = $_POST['challenge_title']." has successfully been created.";
			$this->MItems->add('teammates', array('user_id'=>$_POST['user_id'], 'challenge_id'=>$challenge_id));
			if(@$teammate) {
				$this->add_teammate($teammate, array('id'=>$challenge_id, 'name'=>$_POST['challenge_title']));
			}
			
			if($sponsor_data = $this->session->userdata('sponsor_info')) {
				
				$sponsor_data['item_id'] = $challenge_id;
				$sponsor_data['item_type'] = 'challenge';
				$sponsor_data['link'] = "http://www.google.com";
				$sponsor_data['name'] = "Google";
				
				$this->MItems->add('sponsors', $sponsor_data);
				
			}
			
			$ret['challenge_id'] = $challenge_id;			
		}
		else {
			$data['message'] = "We're sorry, there has been a problem processing your request.";

		}

		$data['data']['new'] = true;

		$ret['success'] = true;
		echo json_encode($ret);
		return;		
	}
	
	
	function image_upload($forCluster = NULL) {
		
		$filename = strip_tags($_REQUEST['filename']);
		$maxSize = strip_tags($_REQUEST['maxSize']);
		$maxW = strip_tags($_REQUEST['maxW']);
		$fullPath = strip_tags($_REQUEST['fullPath']);
		$relPath = strip_tags($_REQUEST['relPath']);
		$colorR = strip_tags($_REQUEST['colorR']);
		$colorG = strip_tags($_REQUEST['colorG']);
		$colorB = strip_tags($_REQUEST['colorB']);
		$maxH = strip_tags($_REQUEST['maxH']);		
		
		$foldername = is_null($forCluster) ? "challenges" : "clusters";
		
		$filesize_image = $_FILES[$filename]['size'];
		if((strpos($_FILES[$filename]['type'], 'image') !== FALSE) && $filesize_image > 0) {
			$upload_result = $this->beex->do_upload($_FILES, 'filename', './media/'. $foldername .'/');
			$upload_filepath = base_url() . 'media/'. $foldername .'/' . $upload_result;
			$upload_metadata = $this->upload->data();

			$width = $upload_metadata['image_width'];
			$height = $upload_metadata['image_height'];
			if($foldername == 'challenges') {			
					$challenge_info = $this->session->userdata("challenge_info");
					$challenge_info['challenge_image'] = $upload_result;
					$this->session->set_userdata("challenge_info", $challenge_info);				
			}	
			else {
				$this->session->set_userdata("cluster_image", $upload_result);
			}		
			echo <<<IMG
				<img src="{$upload_filepath}">
IMG;
			$imgUploaded = true;
		}
		else {
			$imgUploaded = false;
			echo "There was a problem with your upload - try again!";
		}


	}
	
	function sponsor_image_upload() {
		
		$filename = strip_tags($_REQUEST['filename']);
		$maxSize = strip_tags($_REQUEST['maxSize']);
		$maxW = strip_tags($_REQUEST['maxW']);
		$fullPath = strip_tags($_REQUEST['fullPath']);
		$relPath = strip_tags($_REQUEST['relPath']);
		$colorR = strip_tags($_REQUEST['colorR']);
		$colorG = strip_tags($_REQUEST['colorG']);
		$colorB = strip_tags($_REQUEST['colorB']);
		$maxH = strip_tags($_REQUEST['maxH']);		
		
		$foldername = "sponsors";
		
		$filesize_image = $_FILES['sponsor_filename']['size'];
		if((strpos($_FILES['sponsor_filename']['type'], 'image') !== FALSE) && $filesize_image > 0) {
			$upload_result = $this->beex->do_upload($_FILES, 'sponsor_filename', './media/'. $foldername .'/');
			$upload_filepath = base_url() . 'media/'. $foldername .'/' . $upload_result;
			$upload_metadata = $this->upload->data();

			$width = $upload_metadata['image_width'];
			$height = $upload_metadata['image_height'];
			if($foldername == 'sponsors') {			
					$sponsor_info = $this->session->userdata("sponsor_info");
					unset($sponsor_info['sponsor_image']);
					$sponsor_info['image'] = $upload_result;
					$this->session->set_userdata("sponsor_info", $sponsor_info);				
			}	
			else {
				$this->session->set_userdata("cluster_image", $upload_result);
			}		
			echo <<<IMG
				<img src="{$upload_filepath}">
IMG;
			$imgUploaded = true;
		}
		else {
			$imgUploaded = false;
			echo "There was a problem with your upload - try again!";
		}


	}
	
	

	function login_user() {
		/* Only called in context of challenge or cluster creation */		
		if($result = $this->MUser->validate_user($_POST['email'], $_POST['password'])) {
		
			$user = $result->row();

			$userdata = array('logged_in'=>true, 'user_id'=>$user->id, 'username'=>$user->email);
			if($_POST['email'] == 'zkilgore@gmail.com' || $_POST['email'] == 'devin@beex.org' || $_POST['email'] == 'matt@beex.org') {
				$userdata['super_user'] = true;	
			}
			$userdata['challenge_creation_step'] = 'what';
			$this->session->set_userdata($userdata);			
			$this->MItems->update('users', array('id'=>$user->id), array('official'=>'1'));
			echo json_encode(array('success'=>true));
						
		}

		else {
			echo json_encode(array('success'=>false, 'errors' => 'There was a problem with your information. Please try again.'));
		}
		
	}

	
	function create_user() {
		/* Only called in the context of challenge/cluster creation. */


				
		if(isset($_POST['legal_name'])) {
			$full_name = $_POST['legal_name'];
			$full_name_words = split(' ', $full_name);
			$profile['last_name'] = array_pop($full_name_words);  
			$profile['first_name'] = join(' ', $full_name_words);			
		}

		 
		$user['created'] = date("Y-m-d H:i:s");
		$user['email'] = $_POST['email'];
		$user['password'] = $_POST['password'];
		$user['official'] = 1;
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|callback_username_check');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array('success'=>false, 'errors' => validation_errors()));
			return;
		}
		else {
			$id = $this->MItems->add('users', $user);
			
			
			$profile['created'] = $user['created'];
			$profile['user_id'] = $id;
			$this->MItems->add('profiles', $profile);
			
			$userdata = array('logged_in'=>true, 'user_id'=>$id, 'username'=>$_POST['email'], 'challenge_creation_step'=> 'what');		
			$this->session->set_userdata($userdata);
			echo json_encode(array('success'=>true));
		}
		
		
	}

	function username_check($str)
	{
		if ($this->MUser->checkUsername($str))
		{
			$this->form_validation->set_message('username_check', 'This email is already in the system');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function delete_note($id) {
		
		$this->MItems->delete('notes', $id);
		
	}
	
	function delete_note_reply($id) {
		
		$this->MItems->delete('note_replies', $id);
		
	}
	
	function get_browsers() {
	 	
	 	if($_POST['type'] == 'challenges') {
			if($_POST['sort'] == 'featured') {
				echo $this->create_browser($this->MItems->getChallenge(1, 'featured', 'challenges.created', 'desc', 5), 'challenges');
			}
			elseif($_POST['sort'] == 'ending') {
				echo $this->beex->create_browser($this->MItems->getChallenge(date('Y-m-d'), 'challenge_completion >', 'challenge_completion', 'asc', 5), 'challenges');
			}
			elseif($_POST['sort'] == 'new') {
				echo $this->beex->create_browser($this->MItems->getChallenge('', '', 'challenges.created', 'desc', 5), 'challenges');
			}
			elseif($_POST['sort'] == 'raised') {
				echo $this->beex->create_browser($this->MItems->getChallengesMostRaised(5));
			}
			else {
				echo $this->beex->create_browser($this->MItems->getChallenge('', '', 'challenges.created', 'desc', 5), 'challenges');
			}

		}	

		if($_POST['type'] == 'clusters') {
			if($_POST['sort'] == 'featured') {
				echo $this->beex->create_browser($this->MItems->getCluster(1, 'clusters.featured', 'clusters.created', 'desc', 5), 'clusters');
			}
		else {
				echo $this->beex->create_browser($this->MItems->getCluster('', '', 'clusters.created', 'asc', 5), 'clusters');
			}

		}	

		if($_POST['type'] == 'users') {
			if($_POST['sort'] == 'popular') {
				$browser = $this->MItems->get('profiles', '', '', 'created', 'desc');
			}
			else {
				$browser = $this->MItems->get('profiles', '', '', 'created', 'desc');
			}
		}
	}
	 
}

?>