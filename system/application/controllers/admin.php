<?php

class Admin extends Controller { 
	
	public $data;
	
	function Admin() {
		parent::Controller();
		
		$this->load->model('MItems');
		$this->load->model('MAdmin');
		$this->load->library('beex');
		$this->data['header']['title'] = 'Beex Admin';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
		$this->data['data']['username'] = $this->session->userdata('username');
		$this->data['data']['user_id'] = $this->session->userdata('user_id');
	}
	
	function index() {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			
			$this->load->view('admin/view_challenges', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
	}
	
	function challenges() {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			$data['list'] = $this->MAdmin->getList('challenges');
			$data['table'] = 'challenges';
			$this->load->view('admin/view_challenges', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
	
	function clusters() {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			
			$data['list'] = $this->MAdmin->getList('clusters');
			$data['table'] = 'clusters';
			$this->load->view('admin/view_list', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
	
	function users() {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			
			$data['list'] = $this->MAdmin->getList('users');
			$data['table'] = 'users';
			$this->load->view('admin/view_list', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
}