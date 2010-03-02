<?php

class MAdmin extends Model{
	
	function MAdmin(){
		parent::Model();
	}
	
	
	function generateTable($table = 'challenges', $results = '') {
		
		if(!$results) {
			$results = $this->MItems->get($table);
		}
		
		$output = '<table class="admintable">';
		
 		if($table == 'challenges') {
			
			$output .= "<tr><th>Title</th><th>Edit</th><th>Delete</th></tr>";
			
		}
		elseif($table == "clusters") {
			
			$output .= "<tr><th>Title</th><th>Edit</th><th>Delete</th></tr>";
			
		}
		elseif($table == "users") {
			
			$output .= "<tr><th>User Email</th><th>Edit</th><th>Delete</th></tr>";
			
		}
		elseif($table == "donors") {
			
			$output .= "<tr><th>".anchor('admin/donations/lastname/asc', 'Donor Name')."</th><th>".anchor('admin/donations/buyer_email/asc', 'Donor Email')."</th><th>".anchor('admin/donations/state/asc', 'State')."</th><th>".anchor('admin/donations/city/asc', 'City')."</th><th>".anchor('admin/donations/itemname/asc', 'Challenge')."</th><th>".anchor('admin/donations/receiver_email/asc', 'Benefitting Account')."</th><th>".anchor('admin/donations/mc_gross/desc', 'Amount')."</th></tr>";
			
		}
		
		foreach($results->result() as $row) {
			
			if($table == 'challenges') {
				$output .= "
				<tr>
				 <td>".anchor('challenge/view/'.$row->id, $row->challenge_title)."</td>
				 <td>".anchor('challenge/edit_a_challenge/'.$row->id, "Edit")."</td>
				 <td>".anchor('adminajax/delete/challenges/'.$row->id, "Delete")."</td>
				 <td><span class='featuredcheck' id='featuredcheck".(($row->featured) ? "0" : "1").$row->id."'>". (($row->featured) ? "Featured" : "Not Featured")."</span></td>
				</tr>";
			}
			elseif($table == 'clusters') {
				
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
			elseif($table == 'donors') {
				
				$output .= "
				<tr>
				 <td>".$row->firstname." ".$row->lastname."</td>
				 <td>".$row->buyer_email."</td>
				 <td>".$row->state."</td>
				 <td>".$row->city."</td>
				 <td>".$row->itemname."</td>
				 <td>".$row->receiver_email."</td>
				 <td>".$row->mc_gross."</td>
			    </tr>";
				
			}
		}
		
		$output .= "</table>";
		
		return $output;
	}
	
	function getList($table, $sort = '', $dir = '') {
		
		return $this->MItems->get($table, '', '', $sort, $dir);
		
	}
	
}