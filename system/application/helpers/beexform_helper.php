<?php

function challenge_form_setup($data) {
	
	$cluster = element('cluster', $data);
	$item = element('item', $data);
	$npo = element('npo', $data);
	$edit = element('edit', $data);
	$new = element('new', $data);
	$npos = element('npos', $data);
	$challenge_image = element('challenge_image', $data);
	$npo_name = element('npo_name', $data);
	
	/*
	Set up the form elements based on clusters and editing
	*/

	//Cluster ID
	$data = array('name'=>'cluster_id', 'id'=>'cluster_id', 'size'=>25, 'value'=>(($new) ? '' :$item->cluster_id));
	$cells['cluster_id_cell'] = (@$cluster->theid) ? $cluster->theid : ($edit) ? ((@$item->cluster_id) ? $item->cluster_id : form_input($data)) : $item->cluster_id;

	//Challenge Title
	$data = array('name'=>'challenge_title', 'class'=>'dyna_input', 'id'=>'challenge_title', 'size'=>25, 'value'=>($new) ? set_value('challenge_title') : $item->challenge_title);
	$cells['challenge_title_cell'] = (@$cluster->cluster_ch_title) ? '<p class="clustered" id="challenge_title_at">'.$cluster->cluster_ch_title.'</p>'.generate_input('challenge_title', 'hidden', 1, $cluster->cluster_ch_title) : form_input($data);
	
	//Challenge Declaration
	$data = array('name'=>'challenge_declaration', 'class'=>'dyna_input limited_text', 'maxlength'=>'120', 'rows'=>'4', 'id'=>'challenge_declaration', 'value'=>(($new) ? set_value('challenge_declaration') : $item->challenge_declaration));
	$cells['challenge_declaration_cell'] = (@$cluster->cluster_ch_declaration) ? '<p class="clustered" id="challenge_declaration_at">'.$cluster->cluster_ch_declaration."</p>".generate_input('challenge_declaration', 'hidden', $edit, $cluster->cluster_ch_declaration) : form_textarea($data);
	
	//Proof Description
	$data = array('name'=>'proof_description', 'class'=>'dyna_input limited_text', 'maxlength'=>'120', 'id'=>'proof_description', 'rows'=>'4', 'size'=>25, 'value'=>($new) ? set_value('proof_description') : $item->proof_description);
	$cells['proof_description_cell'] = (@$cluster->cluster_ch_proof_description) ? '<p class="clustered" id="proof_description_at">'.$cluster->cluster_ch_proof_description.'</p>'.generate_input('proof_description', 'hidden', 1, $cluster->cluster_ch_proof_description) : form_textarea($data);
	
	//Goal
	$data = array('name'=>'challenge_goal', 'id'=>'challenge_goal', 'size'=>25, 'class'=>'short dyna_input', 'value'=>($new) ? set_value('challenge_goal') : $item->challenge_goal);
	$cells['goal_cell'] = (@$cluster->cluster_ch_goal) ? '<p class="clustered" id="challenge_goal_at">'.$cluster->cluster_ch_goal.'</p>'.generate_input('challenge_goal', 'hidden', 1, $cluster->cluster_ch_goal) : (($edit) ? form_input($data) : $item->challenge_goal);

	//Link
	$data = array('name'=>'challenge_link', 'class'=>'dark_gray', 'id'=>'challenge_link', 'value'=>($new) ? set_value('challenge_link') : $item->challenge_link);
	$cells['link_cell'] = (@$cluster->cluster_ch_link) ? '<p class="clustered" id="challenge_link_at">'.$cluster->cluster_ch_link.'</p>'.generate_input('challenge_link', 'hidden', $edit, $cluster->cluster_ch_link) : form_input($data);

	//RSS
	$data = array('name'=>'challenge_rss', 'id'=>'challenge_rss', 'size'=>25, 'value'=>($new) ? set_value('challenge_rss') : $item->challenge_rss);
	$cells['rss_cell'] = (@$cluster->cluster_ch_rss) ? $cluster->cluster_ch_rss.generate_input('challenge_rss', 'hidden', $edit, $cluster->cluster_ch_rss) : form_input($data);


	//NPO
	$data = array('name'=>'challenge_npo', 'id'=>'challenge_npo');
	$value = ($new) ? set_value('challenge_npo') : $item->challenge_npo;
	if(@$cluster->cluster_npo) {
		$cells['npo_cell'] = '<p class="clustered" id="challenge_npo_at">'.$npo_name.'</p>'.generate_input('challenge_npo', 'hidden', $edit, $cluster->cluster_npo);
	}
	elseif($npo) {
		$cells['npo_cell'] = '<p class="clustered" id="challenge_npo_at">'.$npo_name.'</p>'.generate_input('challenge_npo', 'hidden', $edit, $npo);
	}
	else {
		$cells['npo_cell'] = ($new) ? form_dropdown('challenge_npo', $npos, $value, 'id="challenge_npo" class="dark_gray"') : "<p class='clustered' id='challenge_npo_at'>".$item->name."</p>".generate_input('challenge_npo', 'hidden', $edit, $item->challenge_npo);
	}

	//Completion
	$data = array('name'=>'challenge_completion', 'class'=>'datepicker dyna_input dark_gray', 'id'=>'challenge_completion', 'size'=>25, 'value'=> ( ($new) ? ((set_value('challenge_completion')) ? date('m/d/Y', strtotime(set_value('challenge_completion'))) : '') : (($item->challenge_completion) ? date('m/d/Y', strtotime($item->challenge_completion)) : '' )));
	$cells['completion_cell'] =  (@$cluster->cluster_ch_completion) ? '<p class="clustered" id="challenge_completion_at">'.$cluster->cluster_ch_completion.'</p>'.generate_input('challenge_completion', 'hidden', 1, $cluster->cluster_ch_completion) : form_input($data);

	//Fund Raising Completion
	$data = array('name'=>'challenge_fr_completed', 'class'=>'datepicker', 'id'=>'challenge_fr_completed', 'size'=>25, 'value'=> ( ($new) ? ((set_value('challenge_fr_completed')) ? date('m/d/Y', strtotime(set_value('challenge_fr_completed'))) : '') : (($item->challenge_fr_completed) ? date('m/d/Y', strtotime($item->challenge_fr_completed)) : '' )));
	$cells['fr_cell'] = (@$cluster->cluster_ch_fr_ends) ? $cluster->cluster_ch_fr_ends.generate_input('challenge_fr_completed', 'hidden', $edit, $cluster->cluster_ch_fr_ends) : form_input($data);

	// Proof Completion
	$data = array('name'=>'challenge_proof_upload', 'class'=>'datepicker','class'=>'dyna_input','id'=>'challenge_proof_upload', 'size'=>25, 'value'=>( ($new) ? ((set_value('challenge_proof_upload')) ? date('m/d/Y', strtotime(set_value('challenge_proof_upload'))) : '') : (($item->challenge_proof_upload) ? date('m/d/Y', strtotime($item->challenge_proof_upload)) : '')));
	$cells['proof_cell'] = (@$cluster->cluster_ch_proofdate) ? $cluster->cluster_ch_proofdate.generate_input('challenge_proof_upload', 'hidden', 1, $cluster->cluster_ch_proofdate) : form_input($data);

	//Location
	$data = array('name'=>'challenge_location', 'class'=>'dark_gray', 'id'=>'challenge_location', 'size'=>25, 'value'=>($new) ? set_value('challenge_location') : $item->challenge_location);
	$cells['location_cell'] = (@$cluster->cluster_ch_location) ? '<p class="clustered" id="challenge_location_at">'.$cluster->cluster_ch_location."</p>".generate_input('challenge_location', 'hidden', 1, $cluster->cluster_ch_location) : form_input($data);

	//Address
	$data = array('name'=>'challenge_address1', 'id'=>'challenge_address1', 'size'=>25, 'class'=>'dyna_input', 'value'=>($new) ? set_value('challenge_address1') : $item->challenge_address1);
	$cells['address_cell'] = (@$cluster->cluster_ch_address) ? $cluster->cluster_ch_address.generate_input('challenge_address1', 'hidden', 1, $cluster->cluster_ch_address) : form_input($data);

	//Address 2
	$data = array('name'=>'challenge_address2', 'id'=>'challenge_address2', 'size'=>25, 'value'=>($new) ? set_value('challenge_address2') : $item->challenge_address2);
	$cells['address2_cell'] = (@$cluster->cluster_ch_address2) ? $cluster->cluster_ch_address2.generate_input('challenge_address2', 'hidden', 1, $cluster->cluster_ch_address2) : form_input($data);

	//City
	$data = array('name'=>'challenge_city', 'id'=>'challenge_city', 'size'=>25, 'value'=>($new) ? set_value('challenge_city') : $item->challenge_city);
	$cells['city_cell'] = (@$cluster->cluster_ch_city) ? $cluster->cluster_ch_city.generate_input('challenge_city', 'hidden', 1, $cluster->cluster_ch_city) : form_input($data);

	//State
	$name = 'challenge_state';
	$value = ($new) ? set_value('challenge_state') : $item->challenge_state;
	$cells['state_cell'] = (@$cluster->cluster_ch_state) ? $cluster->cluster_ch_state.generate_input('challenge_state', 'hidden', 1, $cluster->cluster_ch_state) : generate_input($name, 'dropdown', $edit, $value, get_special_array('states'));

	//Zip
	$data = array('name'=>'challenge_zip', 'id'=>'challenge_zip', 'class'=>'short', 'maxlength'=> '5', 'value'=>($new) ? set_value('challenge_zip') : $item->challenge_zip);
	$cells['zip_cell'] = (@$cluster->cluster_ch_zip) ? $cluster->cluster_ch_zip.generate_input('challenge_zip', 'hidden', 1, $cluster->cluster_ch_zip) : form_input($data);

	//Attend
	$attends = array(
			   'anyone' => 'Yes, anyone can attend',
			   'donors' => 'Only donors',
			   'invited' => 'Invited guests',
			   'none' => 'No, people cannot attend'
	);
	$data = array('name'=>'challenge_attend', 'id'=>'challenge_attend');
	$value = ($new) ? set_value('challenge_attend') : $item->challenge_attend;
	$cells['attend_cell'] = (@$cluster->cluster_ch_attend) ? $cluster->cluster_ch_attend.generate_input('challenge_attend', 'hidden', 1, $cluster->cluster_ch_attend) : form_dropdown('challenge_attend', $attends, $value,  'id="challenge_attend"');

	//Blurb
	$name = 'challenge_blurb';
	$value = ($new) ? set_value($name) : $item->$name;
	$cells['blurb_cell'] = (@$cluster->cluster_ch_blurb) ? $cluster->cluster_blurb.generate_input('challenge_blurb', 'hidden', 1, $cluster->cluster_ch_blurb) : generate_input($name, 'text', $edit, $value);

	//Description
	$name = 'challenge_description';
	$value = ($new) ? set_value($name) : $item->$name;
	$cells['description_cell'] = (@$cluster->cluster_ch_description) ? '<p class="clustered" id="challenge_description_at">'.$cluster->cluster_ch_description."</p>".generate_input('challenge_description', 'hidden', 1, $cluster->cluster_ch_description) : generate_input($name, 'text', $edit, $value, '', 'challenge_description_text limited_text dyna_input', '', array('maxlength'=>800));

	
	//Video
	$name = 'challenge_video';
	$value = ($new) ? set_value($name) : $item->$name;
	$cells['video_cell'] = generate_input($name, 'input', $edit, $value, '', 'dyna_input video_input');
	

	//Image
	$name = 'challenge_image';
	$value = ($new) ? $challenge_image : $item->$name;
	$cells['image_cell'] = $value;



	//Challenge Why
	$name = 'challenge_whydo';
	$value = ($new) ? set_value($name) : $item->$name;
	$cells['whydo_cell'] = generate_input($name, 'text', $edit, $value);



	$name = 'challenge_whycare';
	$value = ($new) ? set_value($name) : $item->$name;
	$cells['whycare_cell'] = generate_input($name, 'text', $edit, $value);
	
	
	return $cells;
	
}

function cluster_form_setup($data) {
	
	$cluster = element('cluster', $data);
	$item = element('item', $data);
	$edit = element('edit', $data);
	$new = element('new', $data);
	$npos = element('npos', $data);
	$challenge_image = element('challenge_image', $data);
	
}




?>