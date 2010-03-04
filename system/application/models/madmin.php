<?php

class MAdmin extends Model{
	
	function MAdmin(){
		parent::Model();
		$this->load->helper('array');
	}
	
	
	function generateTable($table = 'challenges', $results = '', $sort = array('by'=> '', 'dir'=>'')) {
		
		if(!$results) {
			$results = $this->MItems->get($table);
		}
		
		$challenges = array(
			'created' => array('name' => "Date Created", 'type' => 'data', 'format' => 'm/d/Y H:i', 'formattype' => 'date'),
			'lastname' => array('name' => "Last Name", 'type' => 'data', 'link' => 'user/view', 'speciallink' => 'user_id'),
			'firstname' => array('name' => "First Name", 'type' => 'data', 'link' => 'user/view', 'speciallink' => 'user_id'),
			'challenge_title' => array('name' => 'Title', 'link' => 'challenge/view', 'type' => 'data'),
			'nponame' => array('name' => "Nonprofit", 'type' => 'data', 'link' => 'npo/view', 'speciallink' => 'npoid'),
			'nodonors' => array('name'=>'# Donors', 'type'=>'data'),
			'raised' => array('name' => 'Amount Raised', 'type' => 'data', 'formattype' => 'money'),
			'challenge_goal' => array('name' => 'Goal', 'type' => 'data', 'formattype' => 'money'),
			'reached' => array('name' => 'Reached', 'type' => 'data'),
			'duration' => array('name'=>'Duration', 'type' => 'data'),
			'edit' => array('name' => 'Edit', 'value'=>'Edit', 'link'=> 'challenge/edit_a_challenge', 'type' => 'edit'),
			'delete' => array('name'=>'Delete', 'value' => 'Delete', 'type' => 'delete'),
			'featuredcheck' => array('name'=>'Featured?', 'type' => 'featuredcheck')
		);	
		
		$donors = array(
			
			'paymentdate' => array('name'=>"Date", 'type'=>'data', 'format' => 'm/d/Y H:i', 'formattype' => 'date'),
			'lastname' => array('name'=>"Last Name", 'type'=>'data'),
			'firstname' => array('name'=>"First Name", 'type'=>'data'),
			'buyer_email' => array('name'=>"Donor Email", 'type'=>'data'),
			'amount' => array('name' => 'Amount', 'type' => 'data', 'format' => 'money'),
			'challenge' => array('name'=>"Challenge", 'type'=>'data', 'link' => 'challenge/view', 'speciallink' => 'cid'),
			
		);
		
		
		$output = '<table class="admintable">';
		$output .= "<tr class='headers'>";
		
		foreach($$table as $title => $header) {
			
			$output .= "<th class='header header-".$title."'>";
			if($header['type'] == 'data') {
				$output .= anchor('admin/'.$table.'/'.$title.'/'.(($sort['by'] == $title) ? (($sort['dir'] == 'asc') ? 'desc' : 'asc') : 'asc'), $header['name']);				
			}
			else {
				$output .= $header['name'];
			}
			$output .= "</th>";
			
		}
		
		$output .= "</tr>";
		
 		if($table == "clusters") {
			
			$output .= "<tr><th>Title</th><th>Edit</th><th>Delete</th></tr>";
			
		}
		elseif($table == "users") {
			
			$output .= "<tr><th>User Email</th><th>Edit</th><th>Delete</th></tr>";
			
		}
		
		
		foreach($results->result() as $row) {
			
			$output .= "<tr class='row row-".$row->id."'>";
			
			foreach($$table as $title => $data) {
				
				$output .= "<td class='cell cell-".element('type', $data)." id='".$title."-".$row->id."'>";
				
				//specify contents of cell
				switch(element('type', $data)) :
					
					case 'data' :
						switch (element('formattype', $data)) :
							case 'date' :
								$value = date(element('format', $data), strtotime($row->$title));
								break;
							case 'money' :
								$value = "$".number_format($row->$title);
								break;
							default :
 								$value = ($row->$title) ? $row->$title : ' ';
								break;
						endswitch; 
						break;
					case 'featuredcheck' :
						$value = "<span class='featuredcheck' id='featuredcheck".(($row->featured) ? "0" : "1").$row->id."'>".(($row->featured) ? "Featured" : "Not Featured")."</span>";
						break;
					case 'delete' :
						$value = "<span class='deletebutton' id='delete".$row->id."'>".element('value', $data, 'Delete')."</span>";
						break;
					default :
						$value = element('value', $data);
						break;
				endswitch;
					
				if(element('link', $data)) {
					
					$output .= anchor(element('link', $data)."/".(($speciallink = element('speciallink', $data)) ? $row->$speciallink : $row->id), $value);
					
				}
				else {
					
					$output .= $value;
					
				}
			}
			
			$output .= "</tr>";
			/*
			if($table == 'challenges') {
				$output .= "
				<tr>
				 <td>".anchor('challenge/view/'.$row->id, $row->challenge_title)."</td>
				 <td>".anchor('challenge/edit_a_challenge/'.$row->id, "Edit")."</td>
				 <td><span class='deletebutton' id='delete".$row->id."'>Delete</span></td>
				 <td><span class='featuredcheck' id='featuredcheck".(($row->featured) ? "0" : "1").$row->id."'>". (($row->featured) ? "Featured" : "Not Featured")."</span></td>
				</tr>";
			}*/
			if($table == 'clusters') {
				
				$output .= "
				<tr>
				 <td>".anchor('cluster/view/'.$row->id, $row->cluster_title)."</td>
				 <td>".anchor('cluster/edit/'.$row->id, "Edit")."</td>
				 <td>".anchor('adminajax/delete/clusters/'.$row->id, "Delete")."</td>
				</tr>";
				
			}
			
			elseif($table == 'users') {
				
				$output .= "
				<tr>
				 <td>".anchor('user/view/'.$row->id, $row->email)."</td>
				 <td>".anchor('user/edit/'.$row->id, "Edit")."</td>
				 <td><span class='deletebutton' id='delete".$row->id."'>Delete</span></td>
				</tr>";
				
			}
		}
		
		$output .= "</table>";
		
		return $output;
	}
	
	function getChallenges($where = '', $sort = 'created', $dir = 'desc', $limit = '', $offset = '') {
		
		$this->db->select('challenges.id AS id, challenges.challenge_title AS challenge_title, challenges.challenge_goal AS challenge_goal, challenges.user_id AS user_id, challenges.featured AS featured,  challenges.created AS created, profiles.first_name AS firstname, profiles.last_name as lastname, SUM(donors.mc_gross) AS raised, npos.name AS nponame, npos.id AS npoid, COUNT(donors.itemnumber) AS nodonors, IF( SUM(donors.mc_gross) > challenges.challenge_goal, "Yes", "No" ) AS reached, DATEDIFF(challenges.challenge_fr_completed, challenges.created) AS duration', FALSE);

		$this->db->join('profiles', 'profiles.user_id = challenges.user_id');
		$this->db->join('donors', 'donors.itemnumber = challenges.id', 'left');
		$this->db->join('npos', 'npos.id = challenges.challenge_npo');
		$this->db->group_by('challenges.id');
		
		if($sort) {
			$this->db->order_by($sort, $dir);
		}
		
		return $this->db->get('challenges');
		
	}
	
	function getDonors($where = '', $sort = 'created', $dir = 'desc', $limit = '', $offset = '') {
		
		$this->db->select('donors.id AS id, CAST(donors.mc_gross AS DECIMAL(5,2)) AS amount, donors.paymentdate AS paymentdate, donors.firstname AS firstname, donors.lastname AS lastname, donors.buyer_email AS buyer_email, challenges.challenge_title AS challenge, challenges.id AS cid, npos.name AS nponame, npos.id AS npoid, challenges.user_id AS user_id, CONCAT(profiles.first_name, " ", profiles.last_name) AS user_name', FALSE);

		$this->db->join('challenges', 'challenges.id = donors.itemnumber');
		$this->db->join('profiles', 'profiles.user_id = challenges.user_id');
		$this->db->join('npos', 'npos.id = challenges.challenge_npo');
		
		$this->db->group_by('paymentdate');
		
		if($sort) {
			$this->db->order_by($sort, $dir);
			$this->db->order_by('challenge', 'asc');
			$this->db->order_by('paymentdate', 'asc');
		}
		
		return $this->db->get('donors');
	}
	
	function getList($table, $sort = '', $dir = '') {
		
		
		return $this->MItems->get($table, '', '', $sort, $dir);
		
	}
	
}