<?php

class MAdmin extends Model{
	
	function MAdmin(){
		parent::Model();
		$this->load->helper('array');
	}
	
	
	function generateTable($table = 'challenges', $results = '', $sort = array('by'=> '', 'dir'=>''), $id = '', $datatable = '') {
		
		if(!$results) {
			$results = $this->MItems->get($table);
		}
		
		$challenges = array(
			'created' => array('name' => "Date Created", 'type' => 'data', 'format' => 'm/d/Y H:i', 'formattype' => 'date'),
			'lastname' => array('name' => "Last Name", 'type' => 'data', 'link' => 'user/view', 'speciallink' => 'user_id'),
			'firstname' => array('name' => "First Name", 'type' => 'data', 'link' => 'user/view', 'speciallink' => 'user_id'),
			'challenge_title' => array('name' => 'Title', 'link' => 'challenge/view', 'type' => 'data'),
			'nponame' => array('name' => "Nonprofit", 'type' => 'data', 'link' => 'admin/npo', 'speciallink' => 'npoid'),
			'nodonors' => array('name'=>'# Donors', 'type'=>'data', 'link'=>'admin/donorsfor', 'speciallink' => 'addtable'),
			'raised' => array('name' => 'Amount Raised', 'type' => 'data', 'formattype' => 'money'),
			'challenge_goal' => array('name' => 'Goal', 'type' => 'data', 'formattype' => 'money'),
			'reached' => array('name' => 'Reached', 'type' => 'data'),
			'duration' => array('name'=>'Duration', 'type' => 'data'),
			'hits' => array('name'=>'Hits', 'type' => 'data'),
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
		
		$clusters = array(
			
			'created' => array('name' => "Date Created", 'type' => 'data', 'format' => 'm/d/Y H:i', 'formattype' => 'date'),
			'lastname' => array('name' => "Last Name", 'type' => 'data', 'link' => 'user/view', 'speciallink' => 'user_id'),
			'firstname' => array('name' => "First Name", 'type' => 'data', 'link' => 'user/view', 'speciallink' => 'user_id'),
			'cluster_title' => array('name' => 'Title', 'link' => 'cluster/view', 'type' => 'data'),
			'nponame' => array('name' => "Nonprofit", 'type' => 'data', 'link' => 'admin/npo', 'speciallink' => 'npoid'),
			'nochallenges' => array('name' => '# Challenges (Click to View Challenges)', 'link'=>'admin/cluster', 'type' => 'nochallenges'),
			'nodonors' => array('name'=>'# Donors', 'type'=>'data', 'link' => 'admin/donorsfor', 'speciallink' => 'addtable'),
			'raised' => array('name' => 'Amount Raised', 'type' => 'data', 'formattype' => 'money'),
			'challenge_goal' => array('name' => 'Goal', 'type' => 'data', 'formattype' => 'money'),
			'reached' => array('name' => 'Reached', 'type' => 'data'),
			/*'hits' => array('name'=>'Hits', 'type' => 'data'),*/
			'edit' => array('name' => 'Edit', 'value'=>'Edit', 'link'=> 'cluster/edit', 'type' => 'edit'),
			'delete' => array('name'=>'Delete', 'value' => 'Delete', 'type' => 'delete'),
			'featuredcheck' => array('name'=>'Featured?', 'type' => 'featuredcheck')
			
		);
		
		$users = array(
			
			'lastname' => array('name' => "Last Name", 'type' => 'data', 'link' => 'admin/user'),
			'firstname' => array('name' => "First Name", 'type' => 'data', 'link' => 'admin/user'),
			'email' => array('name'=> 'Email', 'type'=>'data'),
			'edit' => array('name' => 'Edit', 'value'=>'Edit', 'link'=> 'user/edit', 'type' => 'edit'),
			'delete' => array('name'=>'Delete', 'value' => 'Delete', 'type' => 'delete')
			
		);
		
		$npos  = array(
			
			'name' => array('name' => "NPO Name", 'type' => 'data', 'link' => 'admin/npo'),
			'approve' => array('name'=>'Approved', 'type'=>'approve'),
			'edit' => array('name' => 'Edit', 'value'=>'Edit', 'link'=> 'npo/edit', 'type' => 'edit'),
			'delete' => array('name'=>'Delete', 'value' => 'Delete', 'type' => 'delete')
			
		);
		
		
		$output = '<table class="admintable">';
		$output .= "<tr class='headers'>";
		
		foreach($$table as $title => $header) {
			
			$output .= "<th class='header header-".$title."'>";
			if($header['type'] == 'data') {
				$output .= anchor('admin/'.$this->uri->segment(2).'/'.(($id) ? $id.'/' : '').$title.'/'.(($sort['by'] == $title) ? (($sort['dir'] == 'asc') ? 'desc' : 'asc') : 'asc') .(($datatable) ? '/'.$datatable : ''), $header['name']);				
			}
			else {
				$output .= $header['name'];
			}
			$output .= "</th>";
			
		}
		
		$output .= "</tr>";
		
 		
		
		
		foreach($results->result() as $row) {
			
			$output .= "<tr class='row row-".$row->id."'>";
			
			foreach($$table as $title => $data) {
				
				$output .= "<td class='cell cell-".element('type', $data)."' id='".$title."-".$row->id."'>";
				
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
					case 'approve' : 
						$value = "<span class='approvebutton' id='approved".(($row->approve == 'Approved') ? "0" : "1").$row->id."'>".$row->approve."</span>";
						break;
					case 'nochallenges' :
						$value = $this->getNoChallenges($row->id);
						break;
					default :
						$value = element('value', $data);
						break;
				endswitch;
					
				if($link = element('link', $data)) {
					
					switch(element('speciallink', $data)) :
						
						case 'addtable' :
							$link .= "/".( ($datatable) ? $datatable : $table).'_'.$row->id;
							break;
						case '' :
							$link .= "/".$row->id;
							break;
						default :
							$speciallink = element('speciallink', $data);
							$link .= "/".$row->$speciallink;
							break;
					endswitch;
					
					$output .= anchor($link, $value);
					
				}
				else {
					
					$output .= $value;
					
				}
			}
			
			$output .= "</tr>";
		
		}
		
		$output .= "</table>";
		
		return $output;
	}
	
	function getChallenges($where = '', $sort = 'created', $dir = 'desc', $limit = '', $offset = '') {
		
		$this->db->select('challenges.id AS id, challenges.challenge_title AS challenge_title, CAST(challenges.challenge_goal AS DECIMAL(5,2)) AS challenge_goal, challenges.user_id AS user_id, challenges.featured AS featured,  challenges.created AS created, profiles.first_name AS firstname, profiles.last_name as lastname, SUM(donors.mc_gross) AS raised, npos.name AS nponame, npos.id AS npoid, COUNT(donors.itemnumber) AS nodonors, IF( SUM(donors.mc_gross) > challenges.challenge_goal, "Yes", "No" ) AS reached, hits.hits AS hits, DATEDIFF(challenges.challenge_fr_completed, challenges.created) AS duration', FALSE);

		$this->db->join('profiles', 'profiles.user_id = challenges.user_id');
		$this->db->join('donors', 'donors.itemnumber = challenges.id', 'left');
		$this->db->join('npos', 'npos.id = challenges.challenge_npo');
		$this->db->join('hits', 'hits.item_id = challenges.id', 'left');
		$this->db->join('teammates', 'teammates.challenge_id = challenges.id', 'left');
		$this->db->group_by('challenges.id');
		
		if($where) {
			$this->db->where($where);
		}
		if($sort) {
			$this->db->order_by($sort, $dir);
		}
				
		return $this->db->get('challenges');
		
	}
	
	function getClusters($where = '', $sort = 'created', $dir = 'desc', $limit = '', $offset = '') {
		
		$this->db->select('clusters.id AS id, clusters.cluster_title AS cluster_title, CAST(clusters.cluster_goal AS DECIMAL(10,2)) AS challenge_goal, clusters.user_id AS user_id, clusters.featured AS featured,  clusters.created AS created, profiles.first_name AS firstname, profiles.last_name as lastname, CAST( SUM(donors.mc_gross) AS DECIMAL(10,2) ) AS raised, npos.name AS nponame, npos.id AS npoid, COUNT(donors.itemnumber) AS nodonors, COUNT(challenges.id) AS nochallenges, IF( SUM(donors.mc_gross) > CAST(clusters.cluster_goal AS DECIMAL(10,2)) , "Yes", "No" ) AS reached', FALSE);

		$this->db->join('profiles', 'profiles.user_id = clusters.user_id');
		$this->db->join('challenges', 'challenges.cluster_id = clusters.id', 'left');
		$this->db->join('donors', 'donors.itemnumber = challenges.id', 'left');
		$this->db->join('npos', 'npos.id = clusters.cluster_npo');
		$this->db->join('admins', 'admins.cluster_id = admins.id', 'left');

		$this->db->group_by(array('clusters.id'));
		
		
		if($where) {
			$this->db->where($where);
		}
		if($sort) {
			$this->db->order_by($sort, $dir);
		}
		
		return $this->db->get('clusters');
		
	}
	
	function getCluster($id) {
		
		$this->db->select('clusters.id AS id, clusters.cluster_title AS cluster_title, clusters.cluster_goal AS challenge_goal, clusters.user_id AS user_id, clusters.featured AS featured,  clusters.created AS created, profiles.first_name AS firstname, profiles.last_name as lastname, SUM(donors.mc_gross) AS raised, npos.name AS nponame, npos.id AS npoid, COUNT(donors.itemnumber) AS nodonors, COUNT(challenges.id) AS nochallenges, IF( SUM(donors.mc_gross) > CAST(clusters.cluster_goal AS DECIMAL(5,2)) , "Yes", "No" ) AS reached', FALSE);

		$this->db->join('profiles', 'profiles.user_id = clusters.user_id');
		$this->db->join('challenges', 'challenges.cluster_id = clusters.id', 'left');
		$this->db->join('donors', 'donors.itemnumber = challenges.id', 'left');
		$this->db->join('npos', 'npos.id = clusters.cluster_npo');

		$this->db->group_by(array('clusters.id'));
		
		$this->db->where('clusters.id', $id);

		return $this->db->get('clusters')->row();

		
	}
	
	function getNpo($id) {
		
		$this->db->select('npos.*, SUM(donors.mc_gross) AS raised');
		
		$this->db->join('challenges', 'challenges.challenge_npo = npos.id', 'left');
		$this->db->join('donors', 'donors.itemnumber = challenges.id', 'left');
		
		$this->db->group_by(array('npos.id'));
		
		$this->db->where('npos.id', $id);
		
		return $this->db->get('npos')->row();
		
	}
	
	function getNoChallenges($id, $table = 'clusters') {
		
		$this->db->select('COUNT(*) AS num');
		
		if($table == 'clusters') {
		
			$this->db->join('challenges', 'challenges.cluster_id = clusters.id');
		
			return $this->db->get_where('clusters', array('clusters.id'=>$id))->row()->num;
		}
		elseif($table == 'npos') {
			
			$this->db->join('challenges', 'challenges.challenge_npo = npos.id');
		
			return $this->db->get_where('npos', array('npos.id'=>$id))->row()->num;
			
		}
	}
	
	function getUsers($where = '', $sort = 'created', $dir = 'desc', $limit = '', $offset = '') {
		
		$this->db->select('users.id AS id, users.created AS created,  profiles.first_name AS firstname, profiles.last_name AS lastname, users.email AS email');
		
		$this->db->join('profiles', 'profiles.user_id = users.id');
		
		if($sort) {
			$this->db->order_by($sort, $dir);
		}
		
		return $this->db->get('users');
		
		
		
	}
	
	function getNpos($where = '', $sort = 'name', $dir = 'desc', $limit = '', $offset = '') {
		
		$this->db->select('npos.id AS id, npos.created AS created,  npos.name AS name, IF(npos.approved > 0, \'Approved\', \'Not Approved\') AS approve', FALSE);
		
		if($sort) {
			$this->db->order_by($sort, $dir);
		}
		
		return $this->db->get('npos');
		
		
		
	}
	
	function getDonors($where = '', $sort = 'created', $dir = 'desc', $limit = '', $offset = '') {
		
		
		
		$this->db->select('donors.id AS id, CAST(donors.mc_gross AS DECIMAL(5,2)) AS amount, donors.paymentdate AS paymentdate, donors.firstname AS firstname, donors.lastname AS lastname, donors.buyer_email AS buyer_email, challenges.challenge_title AS challenge, challenges.id AS cid, npos.name AS nponame, npos.id AS npoid, challenges.user_id AS user_id, CONCAT(profiles.first_name, " ", profiles.last_name) AS user_name', FALSE);
		
		
		$this->db->join('challenges', 'challenges.id = donors.itemnumber');
		$this->db->join('profiles', 'profiles.user_id = challenges.user_id');
		$this->db->join('npos', 'npos.id = challenges.challenge_npo');
		
		if(substr($where, 0, 8) == 'clusters') {
			
			$id = substr($where, 9);
			
			$this->db->join('clusters', 'clusters.id = challenges.cluster_id', 'left');
			$this->db->where(array('clusters.id' => $id));
			
		}
		elseif(substr($where, 0, 10) == 'challenges') {
			
			$id = substr($where, 11);
			$this->db->where(array('itemnumber' => $id));
			
		}
		
		$this->db->group_by('paymentdate');
		
		if($sort) {
			$this->db->order_by($sort, $dir);
			$this->db->order_by('challenge', 'asc');
			$this->db->order_by('paymentdate', 'asc');
		}
		
		return $this->db->get('donors');
	}
	
	function getDonorsByDate($when, $where) {
		
		$this->db->select("SUM(donors.mc_gross) AS amount");
		
		$this->db->join('challenges', 'challenges.id = donors.itemnumber');
		
		if(substr($where, 0, 8) == 'clusters') {
			
			$id = substr($where, 9);
			
			$this->db->join('clusters', 'clusters.id = challenges.cluster_id', 'left');
			$this->db->where(array('clusters.id' => $id));
			
		}
		elseif(substr($where, 0, 10) == 'challenges') {
			
			$id = substr($where, 11);
			$this->db->where(array('challenges.id' => $id));
			
		}
		
		$this->db->where("datecreation >", $when);
		
		return $this->db->get('donors')->row()->amount;
		
	}
	
	function getList($table, $sort = '', $dir = '') {
		
		
		return $this->MItems->get($table, '', '', $sort, $dir);
		
	}
	
}