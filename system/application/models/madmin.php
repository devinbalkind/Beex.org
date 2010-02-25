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
		}
		
		$output .= "</table>";
		
		return $output;
	}
	
	function getList($table) {
		
		return $this->MItems->get($table);
		
	}
	
}