<?php

class Widgets extends Controller { 
	
	function Widgets() {
		parent::Controller();
	
	}
	
	function index() {
		
		echo "Widgets Page";

	}
	
	function create_widget() {
		
		$data = $this->data;
		$id = $this->uri->segment(3);
		$type = $this->uri->segment(4, 'npo');
		
		$data['type'] = $type;
		$data['npo_id'] = $id;
				
		$this->load->view('widgets/create', $data);
		
	}
	
	function cluster_widget() {
		
		$default_keys = array('id', 'border_color', 'link_color', 'hover_color', 'title_color');
		
		$params = $this->uri->uri_to_assoc(3, $default_keys);
		
		extract($params);
		
		if(!$border_color) {
			$border_color = "FFC400";
		}
		
		if(!$link_color) {
			$link_color = "CC7322";
		}
		
		if(!$hover_color) {
			$hover_color = "FFC400";
		}
		
		if(!$title_color) {
			$title_color = "FFC400";
		}
		
		$cluster = $this->MItems->getCluster($id);
		
		if($cluster->num_rows()) {
			
			$challenges = $this->MItems->getChallenge(array('cluster_id'=>$id), '', 'challenges.created', 'DESC');
			
			$data = array('border_color'=>$border_color, 'link_color'=>$link_color, 'hover_color'=>$hover_color, 'title_color'=>$title_color, 'cluster_title'=>$cluster->row()->cluster_title, 'cluster_id'=>$id, 'challenges'=>$challenges);
		
			$this->load->view('widgets/cluster_widget', $data);
			
		}
	
	}
	
	function npo_supporting_widget() {

		$default_keys = array('id', 'border_color', 'link_color', 'hover_color', 'title_color');

		$params = $this->uri->uri_to_assoc(3, $default_keys);

		extract($params);

		if(!$border_color) {
			$border_color = "FFC400";
		}

		if(!$link_color) {
			$link_color = "CC7322";
		}

		if(!$hover_color) {
			$hover_color = "FFC400";
		}

		if(!$title_color) {
			$title_color = "FFC400";
		}

		$npo = $this->MItems->getNpo($id);

		if($npo->num_rows()) {

			$challenges = $this->MItems->getChallenge(array('challenge_npo'=>$id), '', 'challenges.created', 'DESC');

			$data = array('border_color'=>$border_color, 'link_color'=>$link_color, 'hover_color'=>$hover_color, 'title_color'=>$title_color, 'npo_name'=>$npo->row()->name, 'npo_id'=>$id, 'challenges'=>$challenges);

			$this->load->view('widgets/npo_supporting_widget', $data);

		}
	}
	
	function npo_declaration_widget() {

		$default_keys = array('id', 'border_color', 'link_color', 'hover_color', 'title_color');

		$params = $this->uri->uri_to_assoc(3, $default_keys);

		extract($params);

		if(!$border_color) {
			$border_color = "FFC400";
		}

		if(!$link_color) {
			$link_color = "CC7322";
		}

		if(!$hover_color) {
			$hover_color = "FFC400";
		}

		if(!$title_color) {
			$title_color = "FFC400";
		}

		$npo = $this->MItems->getNpo($id);

		if($npo->num_rows()) {

			$data = array('border_color'=>$border_color, 'link_color'=>$link_color, 'hover_color'=>$hover_color, 'title_color'=>$title_color, 'npo_name'=>$npo->row()->name, 'npo_id'=>$id);

			$this->load->view('widgets/npo_declaration_widget', $data);

		}
	}
}
?>