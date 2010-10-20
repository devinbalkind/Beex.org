<?php

class Ajaxcluster extends Controller { 
	
	public $data;
	
	function Ajaxcluster() {
		parent::Controller();
		$this->load->helper('email');
	}
	
	function is_already_invited($email, $cluster_id) {
		
		$this->db->select('id');
		$this->db->from('cluster_invites');
		$this->db->where(array('email'=>$email, 'cluster_id'=>$cluster_id));
		
		$result = $this->db->get();
		
		return ($result->num_rows()) ? true : false;
	}
	
	function process_invites() {
		
		$emails = explode(',', $_POST['emails']);
		$cluster_id = $_POST['id'];
		$user_id = $this->session->userdata('user_id');
		
		$cluster = $this->MItems->getCluster($cluster_id)->row();
		$user = $this->MItems->getUser($user_id)->row();
		$npo = $this->MItems->getNPO($cluster->cluster_npo)->row();
		$item['cluster']['id'] = $cluster_id;
		$item['cluster']['name'] = $cluster->cluster_title;
		$item['cluster']['password'] = $cluster->invite_code;
		
		$item['admin']['id'] = $user_id;
		$item['admin']['name'] = $user->first_name.' '.$user->last_name;
		
		$item['npo']['id'] = $npo->id;
		$item['npo']['name'] = $npo->name;
		
		foreach($emails as $email) {
			$email = trim($email);
			if(valid_email($email)) {
				if(!$this->is_already_invited($email, $cluster_id)) {
					$insert_data = array(
						'cluster_id'=>$cluster_id,
						'email' => $email, 
						'created' => date('Y-m-d H:i:s'),
						'status' => 'pending'
					);
					$this->db->insert('cluster_invites', $insert_data);
					$this->beex_email->generate_cluster_invite_email($email, $item);
				}
			}
		}
		$ret['emails'] = $emails;
		echo json_encode($ret);
	}
	
	function process_code() {
		
		$code = $_POST['code'];
		$cluster_id = $_POST['id'];
		
		$this->MItems->update('clusters', $cluster_id, array('invite_code'=>$code));
		
		echo $code;
		
	}
	
	function check_code() {
		
		$code = $this->input->post('code');
		$cluster_id = $this->input->post('cluster_id');
		
		$this->db->select("*");
		$result = $this->db->get_where('clusters', array('id'=>$cluster_id, 'invite_code'=>$code));
		if($result->num_rows()) {
			echo "success";
		}
		else {
			echo "You have entered an incorrect cluster invite code.";
		}
		
	}
	
	function deactivate_challenge() {
		
		$this->load->model('MAdmins');
		
		$cluster_id = $this->input->post('cluster_id');
		$challenge_id = $this->input->post('challenge_id');
		
		if($this->MAdmins->verifyUser($this->session->userdata('user_id'), $cluster_id, 'cluster')) {
			$this->MItems->update('challenges', $challenge_id, array('cluster_id'=>''));
			echo "success";
		}
		else {
			echo "You do not have permission to do that";
		}
	}
}

?>