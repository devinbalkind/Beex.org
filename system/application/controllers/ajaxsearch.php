<?php

class Ajaxsearch extends Controller { 
	
	function Ajaxsearch() {
		parent::Controller();
		
		$this->load->model('MSearch');
	}
		
	function index() {
		return false;
	}
	
	// Cluster Search: Process a search over only a specific cluster
	function cluster_search() {
		
		if(($id = $this->input->post('cluster_id')) && ($term = $this->input->post('term'))) {
			$ret['success'] = true;
			$ret['results'] = $this->process_search_results($this->MSearch->search_cluster($id, $term));
		}
		else {
			$ret['success'] = false;
		}
		
		echo json_encode($ret);
	}
	
	// MOVE THIS! Process Search Results: Generate the code to display the search results appropriately. 
	function process_search_results($result) {
		
		$folder = 'profile';
		
		//$output = '';
		$output = array();
		
		foreach($result->result() as $item) {
			
			if(false) {

				$pronoun = 'I';
				$pronoun = $this->MItems->hasTeammates($item->id);
				$profile = $this->MItems->getUserByChallenge($item->id)->row();
				
				if($profile) :
			
					if($folder == 'profile') {
						$image_name = $profile->profile_pic;
						$link_id = $profile->user_id;
					}
					else {
						$link_id = $item->id;
						if($item->challenge_video) {
							$image_name = get_video_thumbnail($item->challenge_video);
						}
						else {
							$image_name = $item->challenge_image;
						}
					}
				
					$data = array(
						'link_id'=>$link_id,
						'image_name'=>$image_name,
						'folder'=>$folder,
						'profile'=>$profile,
						'item'=>$item
					);
			
					$output .= $this->load->view('pieces/browser_item_challenge', $data, true);
				
				endif; 
			}
			
			$output[] = $item->id;
		}
		
		return $output;
	}
	
	function create_browser_item($item, $type) {
		
	}
}

?>