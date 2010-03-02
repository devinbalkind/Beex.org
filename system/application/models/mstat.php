<?php

class MStat extends Model{
	
	function MStat(){
		parent::Model();
	}
	
	
	function addStat($zone = 1) {
	
	    $this->load->library('user_agent');
	    if($this->agent->is_robot())
	    {
	        return FALSE;
	    }   
	    else  
	    {

	        if ($this->agent->is_browser())
	        {
	            $agent = $this->agent->browser().' '.$this->agent->version();
	        }
	        elseif ($this->agent->is_mobile())
	        {
	            $agent = $this->agent->mobile();
	        }
	        else
	        {
	            $agent = 'Unidentified User Agent';
	        }

	        $browser = $this->agent->browser();     
	        $browser_version = $this->agent->version();
	        $os = $this->agent->platform();


	        //$zone (frontend / admin / members)
	        $general = $this->uri->segment( 1 );        //products
	        $specific = $this->uri->segment( 2 );        //products/shoes
	        $item = $this->uri->segment( 3 );        //products/view_shoe/34
	        $session = $this->session->userdata( 'session_id' );
	        $ip = $this->session->userdata( 'ip_address' );
	        $user_id = $this->session->userdata( 'user_id' );      //if user is logged in
	        $user_agent = $this->session->userdata( 'user_agent' );

	        //use a model for inserting data
	        $this->db->insert('stats', array('zone' => $zone, 'general' => $general, 'specific' => $specific, 'item' => $item, 'session' => $session, 'ip' => $ip, 'user_id' => $user_id, 'user_agent' => $user_agent, 'browser' => $browser, 'browser_version' => $browser_version, 'os' => $os, 'agent' => $agent));
	    }
	}
	
}

?>