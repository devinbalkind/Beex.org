<?php

class MAdmin extends Model{
	
	function MAdmin(){
		parent::Model();
	}
	
	
	function generateTable($table = 'challenges') {
		
		$results = $this->MItems->get($table);
		
		$output = '<table class="admintable">';
		
 		if($table == 'challenges') {
			
			$output .= "<tr><th>Title</th><th>Edit</th><th>Delete</th></tr>";
			
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
		}
		
		$output .= "</table>";
		
		return $output;
	}
	
	
}