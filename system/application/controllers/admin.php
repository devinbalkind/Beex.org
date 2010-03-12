<?php

class Admin extends Controller { 
	
	public $data;
	
	function Admin() {
		parent::Controller();
		
		$this->load->model('MItems');
		$this->load->model('MAdmin');
		$this->load->library('beex');
		$this->data['header']['title'] = 'Beex Admin';
		$this->data['header']['admin'] = $this->data['footer']['admin'] = true;
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
			$data['id'] = '';
			$data['list'] = $this->MAdmin->getDonors('', $sort, $dir);
			$data['table'] = 'donors';
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			$data['datatable'] = '';
			
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
	
	function donorsfor($id, $sort = 'paymentdate', $dir = 'desc', $table = 'clusters') {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			
			// Dontation Results Table
			$data['id'] = $id;
			$data['list'] = $this->MAdmin->getDonors($id, $sort, $dir);
			$data['datatable'] = $table;
			$data['table'] = 'donors';
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			
			// Donation Numbers
			
			$sql = "SELECT sum(donors.mc_gross) as sum FROM donors, challenges, clusters WHERE donors.itemnumber = challenges.id AND".(($table == 'clusters') ? ' clusters.id = challenges.cluster_id AND' : '')." datecreation > ? GROUP BY challenges.id;";
			
			$twentyfour = date('Y-m-d', time() - (24 * 60 * 60));
			$ten = date('Y-m-d', time() - (24 * 60 * 60 * 10));
			$thirty = date('Y-m-d', time() - (24 * 60 * 60 * 30));
			
			$data['totalraised'] = $this->MAdmin->getDonorsByDate('0000-00-00', $id);
			$data['total24'] = $this->MAdmin->getDonorsByDate($twentyfour, $id);
			$data['total10'] = $this->MAdmin->getDonorsByDate($ten, $id);
			$data['total30'] = $this->MAdmin->getDonorsByDate($thirty, $id);
			
			$this->load->view('admin/donation', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
	
	function challenges($sort = 'created', $dir = 'desc') {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			$data['id'] = '';
			$data['list'] = $this->MAdmin->getChallenges('', $sort, $dir);
			$data['table'] = 'challenges';
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			$this->load->view('admin/view_list', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
	
	function clusters($sort = 'created', $dir = 'desc') {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			$data['id'] = '';
			$data['list'] = $this->MAdmin->getClusters('', $sort, $dir);
			$data['table'] = 'clusters';
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			$this->load->view('admin/view_list', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
	
	function cluster($id, $sort = 'created', $dir = 'desc') {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			$data['list'] = $this->MAdmin->getChallenges("challenges.cluster_id = $id", $sort, $dir);
			$data['cluster'] = $this->MAdmin->getCluster($id);
			$data['nochallenges'] = $this->MAdmin->getNoChallenges($id);
			//echo $this->db->last_query();
			$data['table'] = 'challenges';
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			$data['id'] = $id;
			$this->load->view('admin/view_cluster', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
	
	function npo($id, $sort = 'created', $dir = 'desc') {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			$data['list'] = $this->MAdmin->getChallenges("challenges.challenge_npo = $id", $sort, $dir);
			$data['npo'] = $this->MAdmin->getNpo($id);
			$data['nochallenges'] = $this->MAdmin->getNoChallenges($id, 'npos');
			//echo $this->db->last_query();
			$data['table'] = 'challenges';
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			$data['id'] = $id;
			$this->load->view('admin/view_npo', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
	
	function user($id, $sort = 'created', $dir = 'desc') {
		
		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			$data['challenges'] = $this->MAdmin->getChallenges(array("teammates.user_id"=>$id), $sort, $dir);
			$data['clusters'] = $this->MAdmin->getClusters(array("admins.user_id"=>$id), $sort, $dir);
			//$data['user'] = $this->MAdmin->getUser($id);
			
			print_r($data);
		
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			$data['id'] = $id;
			$this->load->view('admin/view_user', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
	
	
	function npos($sort = 'name', $dir = 'desc') {

		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			$data['id'] = '';
			$data['list'] = $this->MAdmin->getNpos('', $sort, $dir);
			$data['table'] = 'npos';
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			$this->load->view('admin/view_list', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
	
	function users($sort = 'created', $dir = 'desc') {

		$data = $this->data;
		
		if($this->session->userdata('super_user')) {
			$data['id'] = '';
			$data['list'] = $this->MAdmin->getUsers('', $sort, $dir);
			$data['table'] = 'users';
			$data['sort'] = array('by'=>$sort, 'dir'=>$dir);
			$this->load->view('admin/view_list', $data);
		}
		else {
			
			$this->load->view('admin/not_authorized', $data);
		}
		
	}
}