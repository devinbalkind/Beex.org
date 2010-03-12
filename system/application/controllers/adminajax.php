<?php

class Adminajax extends Controller { 
	
	function Adminajax() {
		parent::Controller();
		
		$this->load->model('MItems');
		$this->data['header']['title'] = 'challenge';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
	}
	
	function makefeatured($id, $featured, $table) {
		
		$this->MItems->update($table, $id, array('featured' => $featured));
		
		$ret = ($featured) ? 'Featured' : "Not Featured";
		
		echo $ret;
		
	}
	
	function makeapproved($id, $approved) {
		
		$this->MItems->update('npos', $id, array('approved' => $approved));
		
		$ret = ($approved) ? 'Approved' : "Not Approved";
		
		echo $ret;
		
	}
	
	function delete($table, $id) {
		
		$this->MItems->delete($table, $id);
		echo true;
	}
		
	
}

?>