<?php

class Ajaxeditor extends Controller { 
	
	function Ajaxeditor() {
		parent::Controller();
	}
	
	function delete_teammate($id, $challenge_id) {
		
		if($this->session->userdata('user_id') != $id) {
			$this->MItems->delete('teammates', array('user_id'=>$id, 'challenge_id'=>$challenge_id));
		}
		
	}

}

?>