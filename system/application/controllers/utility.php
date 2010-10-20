<?php

class utility extends Controller { 
	
	public $data;
	public $table_name;	
	
	function utility() {
		parent::Controller();
		
		if(!$this->session->userdata('super_user')) {
			$this->load->view('framework/error');
			exit;
		}
		else {
		
			$this->load->model('MItems');
			$this->load->library('beex');
			$this->data['header']['title'] = 'Utilty';
			$this->data['data']['message'] = '';
			$this->data['data']['item'] = '';
			$this->data['data']['username'] = $this->session->userdata('username');
			$this->data['data']['user_id'] = $this->session->userdata('user_id');
			$this->table_name = 'challenges';
		}
	}
	
	function index() {
		
		echo "Utility Page";

	}
	
	function test() {
		$result = $this->MItems->getClusterActivities(1);
		print_r($result);
	}

	function process_challenges_to_activity() {
		
		$result = $this->MItems->get('challenges');
		
		foreach($result->result() as $c) {
			
			if($c->cluster_id) {
				echo $c->challenge_title.' - Cluster ID: '.$c->cluster_id."<br>";
				
				$data = array('created'=>$c->created, 'item_type'=>'challenge', 'item_id'=>$c->id, 'type'=>'join', 'piece_id'=>$c->id);
				if($this->MItems->add('activity', $data)) {
					echo "SUCCESS<br>";
				}
				
				
			}		
		}
	}
	
	function create_items($table = 'challenge') {
		
		$result = $this->MItems->get($table.'s');
		
		foreach($result->result() as $c) {
			if(!$c->item_id) {
				$item_array = array(
					'type' => $table,
					'created' => $c->created
				);
				
				if($item_id = $this->MItems->add('items', $item_array)) {
					if($this->MItems->update($table.'s', array('id'=>$c->id), array('item_id'=>$item_id))) {
						echo "Success - Type: $table, Item ID: ".$item_id.", ID: ".$c->id."<br>";
					}
					else {
						echo "Error - Couldn't update old item. Type: $table, ID: ".$c->id."<br>";
					}
				}
				else {
					echo "Error - Couldn't insert Item. Type: $table, ID: ".$c->id."<br>";
				}
			}
		}
		
	}
	
	function rewrite_activity() {
		
		$result = $this->MItems->get('activity');
		
		foreach($result->result() as $a) {
			
			if($item_id = $this->MItems->getChallenge(array('challenges.id'=>$a->item_id))->row()->item_id) {
				$act_array = array(
					'type'=>$a->type,
					'piece_id'=>$a->piece_id,
					'item_id'=>$item_id,
					'created'=>$a->created
				);
			
				if($act_id = $this->MItems->add('newactivity', $act_array)) {
					echo "Success - Item ID: ".$item_id.", ID: ".$a->id."<br>";
				}
				else {
					echo "Error - Couldn't insert activity. ID: ".$a->id."<br>";
				}
			}	
		}
		
	}
	
	function update_note_item_ids() {
		$result = $this->MItems->get('notes');
		
		foreach($result->result() as $n) {
			if($item_id = $this->MItems->getChallenge(array('challenges.id'=>$n->item_id))->row()->item_id) {
				if($this->MItems->update('notes', array('id'=>$n->id), array('item_id'=>$item_id))) {
					echo "SUCCESS<br>";
				}
				else {
					echo "FAIL<BR>";
				}
			}
		}
	}
	
	function remove_reply() {
		$this->MItems->delete('activity', array('type'=>'reply'));
	}
	
	function rewrite_donation_item_ids() {
		
		$result = $this->MItems->get('challenges');
		
		foreach($result->result() as $r) {
			
			if($this->MItems->update('donors', array('itemnumber'=>$r->id), array('itemnumber'=>$r->item_id))) {
				echo "Success<br>";
				
			}
			else {
				echo "Fail<br>";
			}	
		}	
	}
	
	function remove_activty_type($type) {
		$this->MItems->delete('newactivity', array('type'=>$type));
	}
	
	function update_proof_to_notes() {
		
		$result = $this->MItems->get('galleries', array('type'=>'proof', 'item_type'=>'challenge'));
		
		foreach($result->result() as $gallery) {
			
			$media = $this->MItems->get('media', array('gallery_id'=>$gallery->id));
			
			$item_id = $this->MItems->get_item_id('challenge', $gallery->item_id);
			$c_id = $gallery->item_id;
			foreach($media->result() as $m) {
				$note_image = '';
				$note_video = '';
				
				if($m->type == 'image') {
					$note_image = $m->link;
					if(is_file('./media/'.$c_id.'/'.$m->link)) {
						echo '<p>Theres a file!</p>';
						
						if(copy('./media/'.$c_id.'/'.$m->link, './media/notes/'.$m->link)) {
							echo "<p>Image moved</p>";
						}
					}
					
				}
				else {
					$note_video = $m->link;
				}
				$note_array = array(
					'proof' => '1',
					'item_id' => $item_id,
					'note' => $m->caption,
					'title' => $m->name,
					'note_video' => $note_video,
					'note_image' => $note_image,
					'created' => $m->created
					
				);
											
				if($n_id = $this->MItems->add('notes', $note_array)) {
					$this->MItems->addActivity('proof', $n_id, $item_id, $m->created);
					echo "<p>Proof Added!</p>";
				}
				
				
			}
			
		}	
		
	}
	
	function make_npo_admins_users() {
		
		$result = $this->MItems->getNPO('', '', '', '', '', '', false);
		
		if($result->num_rows()) {
			foreach($result->result() as $npo) {
				
				echo "<h1>".$npo->name."</h1>";
				
				$user = $this->MItems->getUser($npo->admin_email, 'email');
				if($user->num_rows()) {
					$u = $user->row();
					$this->MItems->update('npos', $npo->id, array('user_id'=>$u->id));
				}
				else {
					report_error('No User with that email');
					$created = date('Y-m-s H:i:s');
					$user_array = array(
						'email'=>$npo->admin_email,
						'password'=>$npo->admin_password,
						'created'=>$created,
						'official'=>'1'
					);
					if($user_id = $this->MItems->add('users', $user_array)) {
						$profile_array = array(
							'first_name'=>$npo->contact_firstname,
							'last_name'=>$npo->contact_lastname,
							'created'=>$created,
							'user_id'=>$user_id
						);
						$this->MItems->add('profiles', $profile_array);
						$this->MItems->update('npos', $npo->id, array('user_id'=>$user_id));
						
						report_error('User was created and NPO was updated');
					}
					else {
						report_error('User could not be created');
					}
				}
				
			}
		}
		else {
			report_error("No NPO!");
		}
		
	}
	
	/*
	function process_old_images($type = 'npos') {
		$data = $this->data;
		$data['header']['title'] = "Process Old Images";
		$this->load->library('beex_image');
		
		echo '<h1>Clusters</h1>';
		$this->beex_image->process_already_there('clusters');
		
		
		
		echo '<h1>challenges</h1>';
		$this->beex_image->process_already_there('challenges');
		
		echo '<h1>Users</h1>';
		$this->beex_image->process_already_there('profiles');
		
		echo "<h1>$type</h1>";
		$this->beex_image->process_already_there($type);
		
	}
	
	function image_awesome() {
		$this->load->library('beex_image');
		
		$image = "bob_dylan.jpg";
		
		$this->beex_image->process_media('media/challenges/', $image, 'media/challenges/test/');
		
		echo "<img src='".base_url()."media/challenges/$image' />"; 
		echo "<img src='".base_url()."media/challenges/test/cropped_$image' />"; 
		echo "<img src='".base_url()."media/challenges/test/sized_$image' />"; 
	}
	
	function send_test_email() {
		
		$this->beex_email->generate_new_registration_email('zkilgore@gmail.com');
		
	}
	
	*/
	
	
}
?>