<?php

class Ajaxforms extends Controller { 
	
	public $data;
	
	function Ajaxforms() {
		parent::Controller();

		$this->data['header']['title'] = 'Ajax Functions';
		$this->data['me'] = '';
		$this->load->library('facebook', array(
		  'appId' => $this->config->item('facebook_api_key'),
		  'secret' => $this->config->item('facebook_secret_key'),
		  'cookie' => true,
		));
	
		$session = $this->facebook->getSession();
	
		$me = null;
		// Session based API call.
		if ($session) {
		  try {
		    $uid = $this->facebook->getUser();		
		    $me = $this->facebook->api('/me');
			$this->data['me'] = $me;
		  } catch (FacebookApiException $e) {
		    error_log($e);
		  }
		}
		
	}
	
	// Enable FB Connet: Function to enable Facebook Connect
	function enable_fb_connect() {
		
		if($id = $this->input->post('id')) {
		
			$me = $this->data['me'];
		
			if($me) {
				$result = $this->db->get_where('users', array('fb_user'=>$me['id']));
				if($result->num_rows()) {
					$ret['error'] = "This facebook user has already been connected to another Beex user";
				}
				else {
					$this->MItems->update('users', array('id'=>$id), array('fb_user'=>$me['id']));
					$ret['success'] = 'Facebook has been connected for you, '.$me['first_name'];
				}
			}
			else {
				$ret['error'] = 'Could not be signed in to facebook';
			}
		}
		else {
			$ret['error'] = "Did not pass an ID";
		}
		echo json_encode($ret);
		return true;
		
	}
	
	function enable_fb_connect_new() {
		
		if($me = $this->data['me']) {
			
			$result = $this->db->get_where('users', array('fb_user'=>$me['id']));
			if($result->num_rows()) {
				$ret['error'] = "This facebook user has already been connected to another Beex user";
			}
			else {
				$ret['success'] = 'Facebook has been connected for you, '.$me['first_name'];
				$ret['me'] = $me;
				$newimage = 'media/profiles/'.$me['id'].'.jpg';
				$this->beex_image->process_html_image('http://graph.facebook.com/'.$me['id'].'/picture?type=large', $newimage);
				$this->beex_image->crop_square('media/profiles/', $me['id'].'.jpg', 'media/profiles/', 134, 134);
				$ret['image'] = base_url().'/media/profiles/cropped134_'.$me['id'].'.jpg';
				$this->session->set_userdata('profile_picture', $me['id'].'.jpg');
			}		
		}
		else {
			$ret['error'] = 'Could not be signed in to facebook';
		}
		
		echo json_encode($ret);
			
	}
	
	function disable_fb_connect() {
		
		if($id = $this->input->post('id')) {
			
			if($this->MItems->update('users', array('id'=>$id), array('fb_user'=>'')));
			
		}
		
	}
	
	function process_fresh_video() {
		
		if($video = $this->input->post('video')) {
			
			if($video != 'wrong_type') {	
				echo process_video_link($video);
			}
		}
		else {
			echo 'fail';
		}
		
	}
	
	function clear_media() {
		
		$type = $this->uri->segment(3);
		
		$images = array($type.'_image'=>'');
		$this->session->unset_userdata($images);
		
		if($id = $this->uri->segment(4)) {
			if($type == 'challenge') {
				$table = 'challenges';
			}
			else {
				$table = 'clusters';
			}

			if($this->MItems->update($table, $id, array($type.'_image'=>'', $type.'_video'=>''))) {
				echo $this->db->last_query();
				echo true;
			}
			else {
				echo false;
			}
			return;
		}
		echo true;
		
	}
	
	function process_cluster_basic() {
						
		$id = $this->uri->segment(3, 'add');
		
		//Process image
		if($cluster_image = $this->session->userdata('cluster_image')) {
			if($cluster_image == 'NULL' && $id) {
				$this->db->update('cluster', array('cluster_image' => ''), array('id'=>$id));
			}
			elseif($cluster_image == 'NULL') {
				$_POST['cluster_image'] = NULL;				
			}
			else {
				$_POST['cluster_image'] = $cluster_image;
			}
		}
		
		if($cluster_ch_image = $this->session->userdata('cluster_ch_image')) {
			if($cluster_image == 'NULL' && $id) {
				$this->db->update('cluster', array('cluster_ch_image' => ''), array('id'=>$id));
			}
			elseif($cluster_ch_image == 'NULL') {
				$_POST['cluster_ch_image'] = NULL;				
			}
			else {
				$_POST['cluster_ch_image'] = $cluster_ch_image;
			}
		}
		
		$id;
				
		$new = ($id == 'add') ? true : false;
		
		if($user_id = $this->session->userdata('user_id')) {
			$_POST['user_id'] = $user_id;
		}
				
		if(!$_POST['user_id']) {			
			echo 'fail';
			return false;
		}
		
		else {
		
			$this->load->library('form_validation');
	
			//Required Fields	
			$this->form_validation->set_rules('cluster_title', 'Cluster Title', 'trim|required');
			$this->form_validation->set_rules('cluster_npo', 'Cluster NPO', 'trim|required');
			$this->form_validation->set_rules('cluster_goal', 'Cluster Goal', 'trim');
			$this->form_validation->set_rules('cluster_blurb', 'Cluster Blurb', 'trim|required');
			$this->form_validation->set_rules('cluster_completion', 'Cluster Fund Raising Completion Date', 'trim');

			
			//Other fields
	
			$this->form_validation->set_rules('cluster_description', 'Cluster Description', 'trim');
			$this->form_validation->set_rules('cluster_video', 'Cluster Video', 'trim');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {

				// User has been logged in, processing continues
			
				if($id == 'add')
					$_POST['created'] = date("Y-m-d H:i:s");
				
				foreach($_POST as $key => $val) {
					if(!$val) {
						unset($_POST[$key]);
					}
				}
				
					$_POST['cluster_ch_completion'] = (isset($_POST['cluster_ch_completion']) && $_POST['cluster_ch_completion']) ? date('Y-m-d', strtotime($_POST['cluster_ch_completion'])) : NULL;
					$_POST['cluster_completion'] = (isset($_POST['cluster_completion']) && $_POST['cluster_completion']) ? date('Y-m-d', strtotime($_POST['cluster_completion'])) : NULL;
				
			
								
				unset($_POST['x']);
				unset($_POST['y']);
				
				$ret['success'] = true;
				
				if($id == 'add') {
					if($cluster_id = $this->MItems->add('clusters', $_POST)) {
						$this->MItems->add('admins', array('user_id'=>$this->session->userdata('user_id'), 'cluster_id'=>$cluster_id));
						
						//Process the new item
						$this->MItems->process_new_item($cluster_id, 'cluster', $_POST['created']);
						
						$data['message'] = $_POST['cluster_title']." has successfully been created.";
						
						$ret['cluster_image'] = '';
						if($image = $this->session->userdata('cluster_image')) {
							$this->beex_image->process_media('media/clusters/', $image, 'media/clusters/'.$cluster_id.'/');
							$ret['cluster_image'] = $image;
							$this->session->unset_userdata('cluster_image');
						}
						
						if($image = $this->session->userdata('cluster_ch_image')) {
							$this->beex_image->process_media('media/clusters/', $image, 'media/clusters/'.$cluster_id.'/');
							$this->session->unset_userdata('cluster_image');
						}
						
						$this->beex_email->generate_new_cluster_email($this->session->userdata('user_id'), array('id'=>$cluster_id));
						//$this->editor('', '', $cluster_id, 'challengers', $data['message']);
						
						$ret['cluster_id'] = $cluster_id;
						
						
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					}
					
				}

				else {
					if($this->MItems->update('clusters', $id, $_POST)) {
						
						if($image = $this->session->userdata('cluster_image')) {
							$this->beex_image->process_media('media/clusters/', $image, 'media/clusters/'.$id.'/');
							$this->session->unset_userdata('cluster_image');
						}
						
						if($image = $this->session->userdata('cluster_ch_image')) {
							$this->beex_image->process_media('media/clusters/', $image, 'media/clusters/'.$id.'/');
							$this->session->unset_userdata('cluster_image');
						}
						
						$this->session->unset_userdata('edit_id');
					
						$data['message'] = $_POST['cluster_title']." has successfully been updated. ".anchor('cluster/view/'.$id, 'Back to cluster');
						//redirect('cluster/challengers/'.$id, 'refresh');					
						//$this->editor('', '', $id, 'edit', $data['message']);						
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					}
										
					$data['data']['message'] = $data['message'];
					$data['data']['item'] = $this->MItems->getCluster($id);
					$data['data']['edit'] = true;
					$data['data']['new'] = 0;
					$ret['cluster_id'] = $id;
				}
				echo json_encode($ret);
				return;
				
				
			}

		}
	}
}

?>