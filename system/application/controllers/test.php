<?php

class test extends Controller { 
	
	public $data;
	public $table_name;	
	
	function test() {
		parent::Controller();
		
		if(!$this->session->userdata('super_user')) {
			$this->load->view('framework/error');
			exit;
		}
		else {
			$this->load->model('MItems');
			$this->load->library('beex');
			$this->data['header']['title'] = 'Test';
			$this->data['data']['message'] = '';
			$this->data['data']['item'] = '';
			$this->data['data']['username'] = $this->session->userdata('username');
			$this->data['data']['user_id'] = $this->session->userdata('user_id');
			$this->table_name = 'challenges';
		}
	}
	
	function index() {
		
		$data = $this->data;
		
		$browser = $this->MItems->getChallenge('', '', '', '', 5);
		
		$data['browser'] = $browser;
		$data['header']['title'] = "Challenges";
		
		$this->load->view('challenges', $data);
		
		
	}
	
	function browser() {
		$data = $this->data;
		$data['header']['title'] = "New Browser Test";
		
		$this->load->view('tests/browser', $data);
	}
	
	function ajaxTest($color) {
		echo "Ajax has worked. The color is $color";
	}
	
	function emailTest() {
		$id = 75;
		$this->beex_email->generate_new_registration_email('zkilgore@gmail.com', $id, '4343dd');
	}
	
}
?>