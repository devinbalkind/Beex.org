<?php

class Beex_email {	

	public $styles;
	
	function Beex_email() {

		$CI =& get_instance();

		$CI->config->item('base_url');
		
		$this->styles['title_a'] = 'style="text-decoration:none; color:#0b2222;"';
		$this->styles['p'] = 'style="font:12px Verdana;"';

	}
	
	function send_beex_email($email, $mdata) {
		
		$CI =& get_instance();
		
		$message = $CI->load->view('email/email_template', $mdata, TRUE);
		
		$CI->load->library('email');		
		
		// Initialize the email library
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 's85554.gridserver.com';
		$config['smtp_user'] = 'thefolks@beex.org';
		$config['smtp_pass'] = 'newkids22';
		$config['mailtype'] = 'html';
		
		$CI->email->initialize($config);
		
		$CI->email->from('folks@beex.org', 'The Folks at Beex');
		$CI->email->to($email);

		$CI->email->subject($mdata['subject']);
		$CI->email->message($message);
		
		if($CI->config->item('production_level') != 'local') {
			$CI->email->send();
		}
	}
	
	function generate_temppass_email($email, $vars) {
		
		$CI =& get_instance();
		
		$data['item'] = $vars;
		
		$mdata['subject'] = $mdata['title'] = "Reset Your BEEx.org Password";
		$mdata['message'] = $CI->load->view('email/temppass_email', $data, TRUE);
		$mdata['ps'] = "If you didn't request a temporary password, please let us know at <a href='mailto:thefolks@beex.org'>folks@beex.org</a>";
		
		$this->send_beex_email($email, $mdata);
		
	}
	
	function generate_new_registration_email($email, $id, $code) {
		
		$CI =& get_instance();
		
		$data['styles'] = $this->styles;
		$data['code'] = $code;
		$data['id'] = $id;
		
		$mdata['subject'] = "Welcome to BEEx.org";
		$mdata['title'] = "Welcome to <a ".$data['styles']['title_a']." href='http://www.beex.org/'>BEEx.org</a>";
		$mdata['message'] = $CI->load->view('email/new_registration', $data, TRUE);
		
		$this->send_beex_email($email, $mdata);
		
	}
	
	function generate_new_npo_email($email) {
		
		$CI =& get_instance();
		
		$data['styles'] = $this->styles;
			
		$mdata['subject'] = "We Received Your Application";
		$mdata['title'] = "We Received Your Application";
		$mdata['message'] = $CI->load->view('email/new_npo', $data, TRUE);
		
		$this->send_beex_email($email, $mdata);
		
	}
	
	function generate_new_challenge_email($user_id, $vars, $partner = false) {
		
		$CI =& get_instance();
		
		$data['styles'] = $this->styles;
		$data['item'] = $vars;
		
		$user = $CI->MItems->getUser($user_id, 'users.id', '', '', '', '', false)->row();
		
		$email = $user->email;
		
		$subject = ($partner) ? "You've been made a partner for a BEEx.org challenge! Now What?" : "You've created a challenge. Now what?";
		$title = ($partner) ? "Congratulations. You've been made a partner for a challenge" : "Congratulations. You've created a challenge";
		
		
		$mdata['subject'] = "You've created a challenge. Now what?";
		$mdata['title'] = $title." on <a ".$data['styles']['title_a']." href='http://www.beex.org/'>BEEx.org</a>. Now what!?";
		$mdata['message'] = $CI->load->view('email/new_challenge', $data, TRUE);
		
		$this->send_beex_email($email, $mdata);
		
	}
	
	function generate_new_cluster_email($userid, $vars) {
		
		$CI =& get_instance();
		
		$data['styles'] = $this->styles;
		$data['item'] = $vars;
		
		$user = $CI->MItems->getUser($userid, 'users.id')->row();
		$email = $user->email;
		
		$mdata['subject'] = "You've created a cluster. Now what?";
		$mdata['title'] = "Congratulations. You've created a cluster on <a ".$data['styles']['title_a']." href='http://www.beex.org/'>BEEx.org</a>. Now what!?";
		
		$mdata['message'] = $CI->load->view('email/new_cluster', $data, TRUE);
		
		$this->send_beex_email($email, $mdata);
		
	}
	
	function generate_join_cluster_email($email, $vars) {
		
		$CI =& get_instance();
		
		$data['styles'] = $this->styles;
		$data['item'] = $vars;
		
		$mdata['subject'] = "You've been asked to join a cluster fund raising initiative on BEEx";
		$mdata['title'] = "You've been asked to join the ".anchor('cluster/view/'.$vars['cluster']['id'], $vars['cluster']['name'], $data['styles']['title_a'])." Cluster on BEEx.org";
		
		$mdata['message'] = $CI->load->view('email/join_cluster', $data, TRUE);
		
		$this->send_beex_email($email, $mdata);
		
	}
	
	function generate_teammate_invite_email($email, $vars) {
		
		$CI =& get_instance(); 
		
		$data['styles'] = $this->styles;
		$data['item'] = $vars;
		
		$mdata['subject'] = "You've been asked to be part of a fundraising team on BEEx.org";
		$mdata['title'] = "You've been asked to be part of the ".anchor('challenge/view/'.$vars['challenge']['id'], $vars['challenge']['title'])." Challenge fundraising team on BEEx.org";
		$mdata['message'] = $CI->load->view('email/invite_teammate', $data, TRUE);

		$this->send_beex_email($email, $mdata);	
	}
	
	function generate_cluster_note_email($email, $vars) {
		
		$CI =& get_instance();
		
		$data['styles'] = $this->styles;
		$data['item'] = $vars;
		
		$mdata['subject'] = '"'.$vars['cluster']['cluster_title'].'" has posted a note.';
		$mdata['title'] = $vars['note_title'];
		$mdata['message'] = $CI->load->view('email/cluster_note', $data, TRUE);
		
		$this->send_beex_email($email, $mdata);
	}
	
	function generate_cluster_invite_email($email, $vars) {
		
		$CI =& get_instance();
		
		$data['styles'] = $this->styles;
		$data['item'] = $vars;
		
		$mdata['subject'] = "You're Invited to Join our Fundraising Cluster";
		$mdata['title'] = "You're Invited to Join our Fundraising Cluster";
		$mdata['message'] = $CI->load->view('email/invite_cluster', $data, TRUE);
		
		$this->send_beex_email($email, $mdata);
	}
}

?>