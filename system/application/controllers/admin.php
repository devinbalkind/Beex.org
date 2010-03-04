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
			
			$sql = "SELECT sum(mc_gross) as sum FROM donors WHERE datecreation > ?;";
			
			$twentyfour = date('Y-m-d', time() - (24 * 60 * 60));
			$ten = date('Y-m-d', time() - (24 * 60 * 60 * 10));
			$thirty = date('Y-m-d', time() - (24 * 60 * 60 * 30));
			
			$data['totalraised'] = $this->db->query($sql, array('0000-00-00'))->row()->sum;
			$data['total24'] = $this->db->query($sql, array($twentyfour))->row()->sum;
			$data['total10'] = $this->db->query($sql, array($ten))->row()->sum;
			$data['total30'] = $this->db->query($sql, array($thirty))->row()->sum;
			
			$this->load->view('admin/index', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
	}
	
	function donors($sort = 'paymentdate', $dir = 'desc') {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			
			// Dontation Results Table
			
			$data['list'] = $this->MAdmin->getDonors('', $sort, $dir);
			$data['table'] = 'donors';
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			
			// Donation Numbers
			
			$sql = "SELECT sum(mc_gross) as sum FROM donors WHERE datecreation > ?;";
			
			$twentyfour = date('Y-m-d', time() - (24 * 60 * 60));
			$ten = date('Y-m-d', time() - (24 * 60 * 60 * 10));
			$thirty = date('Y-m-d', time() - (24 * 60 * 60 * 30));
			
			$data['totalraised'] = $this->db->query($sql, array('0000-00-00'))->row()->sum;
			$data['total24'] = $this->db->query($sql, array($twentyfour))->row()->sum;
			$data['total10'] = $this->db->query($sql, array($ten))->row()->sum;
			$data['total30'] = $this->db->query($sql, array($thirty))->row()->sum;
			
			$this->load->view('admin/donation', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
	
	function challenges($sort = 'created', $dir = 'desc') {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			$data['list'] = $this->MAdmin->getChallenges('', $sort, $dir);
			$data['table'] = 'challenges';
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			$this->load->view('admin/view_list', $data);
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