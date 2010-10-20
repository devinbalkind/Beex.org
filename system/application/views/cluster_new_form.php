<?php

//$new = true;

if($new) {

	$edit = true;
	$edit_id = '';
	$editing = false;
	
}

elseif($edit){
	
	$editing = true;
	$new = false;
	$edit = true;
	$item = $item->row();
	$edit_id = '';

	if($item) {
		$edit_id = $item->theid;
		$this->session->set_userdata('edit_id', $edit_id);
	}
}

if(!$edit_id) {
	$fb_user = $this->MUser->get_fb($this->session->userdata('user_id')); // whether or not we show fb connect dialog
}

$npos = $this->MItems->getDropdownArray('npos', 'name');

$data = array('name'=>'cluster_npo', 'id'=>'cluster_npo');
$value = ($new) ? set_value('cluster_npo') : $item->cluster_npo;
$npo_cell = ($edit) ? form_dropdown('cluster_npo', $npos, $value, 'id="cluster_npo" class="dark_gray"') : $item->cluster_npo;

// Check to see if cluster is being start for a specific organization
if($this->uri->segment(3) == 'organization') {
	$npo_id = $this->uri->segment(4);
	if($npo_id) {
		$npo = $this->MItems->getNpo($npo_id);
		$npo_name = $npo->row()->name;
		
		$npo_cell = "<p class='clustered' id='challenge_npo_at'>Benefitting Organization:<br> ".$npo_name."</p>".generate_input('challenge_npo', 'hidden', $edit, $npo_id);
	}
}


$name = 'cluster_title';
$value = ($new) ? set_value($name) : $item->$name;
$title_cell = generate_input($name, 'input', $edit, $value, '', 'dyna_input');


$name = 'cluster_goal';
$value = ($new) ? set_value($name) : $item->$name;
$goal_cell = generate_input($name, 'input', $edit, $value, '', 'dyna_input');


$name = 'cluster_blurb';
$value = ($new) ? set_value($name) : $item->$name;
$blurb_cell = generate_input($name, 'text', $edit, $value, '', 'dyna_input limited_text', '', array('maxlength'=>140));


$name = 'cluster_description';
$value = ($new) ? set_value($name) : $item->$name;
$description_cell = generate_input($name, 'text', $edit, $value, '', 'dyna_input limited_text', '', array('maxlength'=>800));


$name = 'cluster_video';
$value = ($new) ? set_value($name) : $item->$name;
$video_cell = generate_input($name, 'input', $edit, $value, '', 'short dyna_input video_input');


$name = 'cluster_image';
$value = ($new) ? set_value($name) : $item->$name;
$image_cell = generate_input($name, 'text', $edit, $value);

$name = 'cluster_location';
$value = ($new) ? set_value($name) : $item->$name;
$location_cell = generate_input($name, 'input', $edit, $value, '', 'dark_gray');

$name = 'cluster_link';
$value = ($new) ? set_value($name) : $item->$name;
$website_cell = generate_input($name, 'input', $edit, $value, '', 'dark_gray');

//Completion
$data = array('name'=>'cluster_completion', 'class'=>'datepicker dyna_input', 'id'=>'cluster_completion', 'size'=>25, 'value'=>($new) ? set_value('cluster_completion') : $item->cluster_completion);
$completion_cell = ($edit) ? form_input($data) : $item->cluster_completion;

$name = 'cluster_ch_title';
$value = ($new) ? set_value($name) : $item->$name;
$ch_title_cell = generate_input($name, 'input', $edit, $value, '', 'dyna_input');

$name = 'cluster_ch_declaration';
$value = ($new) ? set_value($name) : $item->$name;
$ch_declaration_cell = generate_input($name, 'text', $edit, $value, '', 'dyna_input limited_text', '', array('maxlength'=>120));

$name = 'cluster_ch_goal';
$value = ($new) ? set_value($name) : $item->$name;
$ch_goal_cell = generate_input($name, 'input', $edit, $value, '', 'short dark_gray');


// Cluster Challenge Where

$name = 'cluster_ch_location';
$value = ($new) ? set_value($name) : $item->$name;
$ch_location_cell = generate_input($name, 'input', $edit, $value, '', 'dark_gray');

$name = 'cluster_ch_link';
$value = ($new) ? set_value($name) : $item->$name;
$ch_link_cell = generate_input($name, 'input', $edit, $value, '', 'dark_gray');

$name = 'cluster_ch_proof_description';
$value = ($new) ? set_value($name) : $item->$name;
$ch_proof_description_cell = generate_input($name, 'text', $edit, $value, '', 'dark_gray limited_text', '', array('maxlength'=>120));


// Cluster Challenge When

$name = 'cluster_ch_completion';
$value = ($new) ? set_value($name) : $item->$name;
$ch_completion_cell = generate_input($name, 'input', $edit, $value, '', 'datepicker dyna_input', '', '');


// Cluster challenge Why

$name = 'cluster_ch_description';
$value = ($new) ? set_value($name) : $item->$name;
$ch_description_cell = generate_input($name, 'text', $edit, $value, '', 'dyna_input limited_text', '', array('maxlength'=>800));

$name = 'cluster_ch_video';
$value = ($new) ? set_value($name) : $item->$name;
$ch_video_cell = generate_input($name, 'input', $edit, $value, '', 'dyna_input video_input');

$this->load->view('framework/header', $header);

if($message) {

	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";

} 

?>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/beex_helper.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/start_login.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ajaxupload.3.5.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/cluster_form.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/dynamic_forms.js"></script>
<script language="javascript" type="text/javascript">
	var edit_id = '<?php echo $edit_id; ?>';
	var fb_user = '<?php echo @$fb_user; ?>';
	var new_cluster = <?php echo ($new) ? "true" : "false"; ?>;
</script>


<div id="ClusterStart" class="start_something">

<div id="LeftColumn">
	
	<p class="direction">REQUIRED FIELDS<span class="required">*</span></p>
	
	<div id="help">
		
    	<h3 class='help_title' id="start_cluster">Description</h3>
		
		<div class="help_section" id="section_start_cluster">
	        <p class='help_description'>Basic information about the cluster and why people should join it.</p>
			<img class="top_border block" src="<?php echo base_url(); ?>images/backgrounds/help-column-top.png" />
			<div class="help_column">
				Hello. This is advice on how to complete the current step.
			</div>
			<img class="bottom_border" src="<?php echo base_url(); ?>images/backgrounds/help-column-bottom.png" />
		</div>
		
		<h3 class='help_title' id="challenge_template">Template</h3>
		
		<div class="help_section" id="section_challenge_template" style="display:none;">
	        <p class='help_description'>Set parameters for all challenges within your cluster.  Your cluster's members can edit fields you leave blank.</p>
			<img class="top_border block" src="<?php echo base_url(); ?>images/backgrounds/help-column-top.png" />
			<div class="help_column">
				Hello. This is advice on how to complete the current step.
			</div>
			<img class="bottom_border" src="<?php echo base_url(); ?>images/backgrounds/help-column-bottom.png" />
		</div>
		
		<?php if(!$new) : ?>
		<h3 class="help_title" id="cluster_challengers">Challengers</h3>
		<div class="help_section" id="section_cluster_challengers" style="display:none">
			<p class='help_description'>Manage your challengers here.</p>
			<img class="top_border block" src="<?php echo base_url(); ?>images/backgrounds/help-column-top.png" />
			<div class="help_column">
			</div>
			<img class="bottom_border" src="<?php echo base_url(); ?>images/backgrounds/help-column-bottom.png" />
		</div>
		
		<h3 class='help_title' id="create_widgets">Widgets</h3>
		<div class="help_section" id="section_create_widgets" style="display:none;">
	        <p class='help_description'>Create an HTML widget that you can put on your website.</p>
			<img class="top_border block" src="<?php echo base_url(); ?>images/backgrounds/help-column-top.png" />
			<div class="help_column">
				You can match the colors of your widget with other colors around the web (such as your website or brand's colors) by using a color selector tool (we recommend <a href="http://www.colorzilla.com/firefox/" target="_blank">ColorZilla</a> for FireFox) to find the color's six digit code and inputing it into our color choosers.
				<br><br>
				For information about using BEEx widgets, <a href="http://learn.beex.org/index.php?option=com_wrapper&view=wrapper&Itemid=12" target="_blank">click here.</a>
			</div>
			<img class="bottom_border" src="<?php echo base_url(); ?>images/backgrounds/help-column-bottom.png" />
		</div>
		<?php endif; ?>
        <span class="errors error_field" id="error_field"></span>
		
    </div>

</div>



<div id="RightColumn">
	
	<?php if(!$this->session->userdata('user_id')) : ?>
	<?php displayStartLogin('start a cluster'); ?>
	<?php endif; ?>
	<?php 
	
	$attributes = array('id' => 'ClusterForm', 'class'=>'itemform');
	if(!$this->session->userdata('user_id')) {
		$attributes['style'] = 'display:none;';
		$attributes['onSubmit'] = 'return false;';
	}
	
	//echo form_open_multipart(''.$edit_id, $attributes); ?>
	<form id="ClusterForm" class="itemform" onsubmit="return false;" <?php if(!$this->session->userdata('user_id')) : ?>style="display:none;"<?php endif; ?>>
		
		<!-- Cluster Information -->
		<div id="clusterinfo" class="cluster_form_tab">
		    <h1 class='awesometitle'>
				<div class="long_text_input">
					<?php echo $title_cell; ?>
				</div>
			</h1>
	        <div id="InfoDisplay" class="InfoDisplay">
            
				<div id="MediaViewer" class="mediaviewer">
					<div class="media">
					<?php if(!$new && ($item->cluster_image || $item->cluster_video)) : $present_media = true; ?>
						<div id="MediaHolder_cluster" class="mediaholder" style="display:block;">
							<?php if($item->cluster_image) : ?>
								<img id="main_image" src="<?php echo base_url(); ?>/media/clusters/<?php echo $item->theid.'/sized_'.$item->cluster_image; ?>" />
							<?php else: ?>
								<div class="video">
				                   <?php echo process_video_link($item->cluster_video); ?>
				                </div>
							<?php endif; ?>
						</div>
					<?php else : ?>
						<div id="MediaHolder_cluster" class="mediaholder"></div>
					<?php endif; ?>
						
						<p class="gray italic">Upload Cluster Media</p>
						<div class="form_element">
							<div class="input_picture">
								<div id="upload_cluster" class="ajax_upload"><div class="short_text_input"><input type="text" class='italic' value="Add image (4mb max)..." /></div><img id="challenge_upload_button" class="upload_button_off rollover" src="<?php echo base_url(); ?>images/buttons/upload-off.png"></div><span id="status" class="ajax_upload_status"></span>
							</div>
						</div>
						<p class="gray italic">OR</p>
						<div class="form_element">
							<img id="PostVideoButton_cluster" class="upload_button_off rollover post_video_button" src="<?php echo base_url(); ?>images/buttons/post-off.png"><div class="short_text_input" style="margin-bottom:5px;"><?php echo $video_cell; ?></div>
							<span class="error status_video" id="status_video_cluster"></span>
						</div>
						
					</div>
					<a id="CancelButton_cluster" class="cancelbutton" <?php if(isset($present_media) && $present_media) echo "style='display:block;'"; ?>>Change Media</a>
					<div class="donation">                          
						<p class="gray">Join Deadline:</p>
           				<div class="short_text_input">
							<?php echo $completion_cell; ?>
						</div>
					</div>
				</div>
				<div id="Declaration" class="declaration_class">
				
					<div id="Body">
						<div class="declare">
							<div class="declaration_cntr">
								<img class="block" src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/declaration-top.png" />
								<div class="sub_declaration_cntr">
									<p class='italic'><span class="required">*</span></p>
									<?php echo $blurb_cell; ?>
								</div>
								<img src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/declaration-bottom.png" />
							</div>
							<div class="form_element">
								<div class="short_text_input"><span style='float:left; margin:3px 0 0 6px;' class='italic'>$</span><?php echo $goal_cell; ?></div>
							</div>
							<div class="form_element"><?php echo  $npo_cell; ?></div>
						</div>
					</div>
				</div>
			
			
				<div id="Blurb" class="blurb_class">
				
					<div class="description_cntr">
						<img class="block" src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/description-top.png" />
						<div class="input_textarea_long"><?php echo $description_cell; ?></div>
						<img src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/description-bottom.png" />	
					</div>
				
						
					<div class="form_element">
						<label>Website:</label>
						<div class="input_text"><?php echo $website_cell; ?></div>
					</div>
			
					<div class="form_element">
						<label>Cluster Location:</label>
						<div class="input_text"><?php echo $location_cell; ?></div>
					</div>
			
					
				</div>    
	            <div style="clear:both;"></div>
				<div class="form_save_cell"><img id="NextButton" class="rollover" src="<?php echo base_url(); ?>images/buttons/reg-next-off.png" /><?php if($edit_id) : ?><img class="save_cluster rollover" src="<?php echo base_url(); ?>images/buttons/save-off.png" /><?php endif; ?></div>
				
	        </div>
	    </div>
		<!-- End Cluster Information -->
		
		<!-- Cluster challenges form -->
		<div id="ClusterFormCH" class="cluster_form_tab" style="display:none;">
		    <h1 class='awesometitle'>
				<div class="long_text_input" style="display:none;">
					<?php echo $ch_title_cell; ?>
				</div>
				Challenge title will go here
			</h1>
	        <div class="InfoDisplay">
            
				<div id="MediaViewerCH" class="mediaviewer">
					<div class="media">
						<?php if(!$new && ($item->cluster_ch_image || $item->cluster_ch_video)) : $present_media_ch = true; ?>
						<div id="MediaHolder_cluster_ch" class="mediaholder" style="display:block;">
							<?php if($item->cluster_ch_image) : ?>
								<img class="main_image" src="<?php echo base_url(); ?>/media/clusters/<?php echo $item->theid.'/sized_'.$item->cluster_ch_image; ?>" />
							<?php else: ?>
								<div class="video">
				                   <?php echo process_video_link($item->cluster_ch_video); ?>
				                </div>
							<?php endif; ?>
						</div>
					<?php else : ?>
						<div id="MediaHolder_cluster_ch" class="mediaholder"></div>
					<?php endif; ?>
						<p class="gray italic">Upload Challenge Media</p>
						<div class="form_element">
							<div class="input_picture">
								<div id="upload_cluster_ch" class="ajax_upload"><div class="short_text_input"><input type="text" class='italic' value="Add image (4mb max)..." /></div><img id="cluster_ch_upload_button" class="upload_button_off rollover" src="<?php echo base_url(); ?>images/buttons/upload-off.png"></div><span id="status_cluster_ch" class="ajax_upload_status"></span>
							</div>
						</div>
						<p class="gray italic">OR</p>
						<div class="form_element">
							<img id="PostVideoButton_cluster_ch" class="upload_button_off rollover post_video_button" src="<?php echo base_url(); ?>images/buttons/post-off.png"><div class="short_text_input"><?php echo $ch_video_cell; ?></div>
							<span class="error status_video" id="status_video_cluster_ch"></span>
						</div>
					</div>
					<a id="CancelButton_cluster_ch" class="cancelbutton" <?php if(isset($present_media_ch) && $present_media_ch) echo "style='display:block;'"; ?>>Change Media</a>
					<div class="donation">                          
						<p class="gray">Fundraising end date:</p>
           				<div class="short_text_input">
							<?php echo $ch_completion_cell; ?>
						</div>
					</div>
					
				</div>
				<div id="DeclarationCH" class="declaration_class">
				
					<div id="BodyCH">
										
						<div class="declare">
							<div class="declaration_cntr">
								<img src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/declaration-top.png" />
								<div class="sub_declaration_cntr">
									<p class='italic'>I will</p>
									<?php echo $ch_declaration_cell; ?>
								</div>
								<img src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/declaration-bottom.png" />
							</div>
							
							<span class="israisedfor">
								<span class="if">if </span>
								<div class="short_text_input">
									<span style='float:left; margin:3px 0 0 6px;' class='italic'>$</span>
									<?php echo $ch_goal_cell; ?>
								</div>
								<span class="israised"> is raised for
							</span>
							<p id="ch_npo_cell"></p>
						</div>
					</div>
				</div>
			
			
				<div id="BlurbCH" class="blurb_class">
				
					<div class="description_cntr" style="display:none;">
						<img class="block" src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/description-top.png" />
						<div class="input_textarea_long"><?php echo $ch_description_cell; ?></div>
						<img src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/description-bottom.png" />	
					</div>
					<p style="font-size:12px; border-bottom:1px solid #BEC4C4; padding:15px 0;">This is where the description will go.</p>
						
					<div class="form_element">
						<label>Website:</label>
						<div class="input_text"><?php echo $ch_link_cell; ?></div>
					</div>
			
					<div class="form_element">
						<label>Challenge Location:</label>
						<div class="input_text"><?php echo $ch_location_cell; ?></div>
					</div>
			
					<div class="form_element" style="padding-top:2px; margin-bottom:0px; padding-bottom:10px;">
						<label style="vertical-align:top;">Proof Description:</label>
						<div class="input_textarea"><img src='<?php echo base_url(); ?>images/backgrounds/text-area-top.png'><?php echo $ch_proof_description_cell; ?><img src='<?php echo base_url(); ?>images/backgrounds/text-area-bottom.png'></div>
					</div>
				</div>    
	            <div style="clear:both;"></div>
				<div class="form_save_cell"><img class="back_button rollover" src="<?php echo base_url(); ?>images/buttons/back-off.png" /><img class="save_cluster rollover" src="<?php echo base_url(); ?>images/buttons/save-off.png" /></div>
				
	        </div>
	    </div>
		
		<?php if(!$new) : ?>
		<!-- Challengers Tab -->
		<div id="ClusterChallengers" class="cluster_form_tab" style="display:none">
			<h1 class='awesometitle'>Cluster Challengers</h1>
	        <div class="InfoDisplay">
				<div class="feed">
					<?php $this->beex->create_browser($this->MItems->getChallenge(array('cluster_id'=>$edit_id)), 'challenges', 'profile', false, true); ?>
				</div>
			</div>
			
			<h1 class='awesometitle'>Invite Code</h1>
	        <div class="InfoDisplay">
				<p>You can enter a code below that your challengers will have to know to join the cluster. If you leave this blank anyone can join your cluster.</p>
				<p>Current Invite Code: <b><span id="current_invite_code"><?php echo $item->invite_code; ?></span</b></p>
				
				<div class="form_element">
					<label>Invite Code</label>
					<input type="text" id="invite_code" />
					<div id="invite_code_button" class="submit_button small_button">Submit</div>
					<p id="invite_code_updated"></p>
				</div>
			</div>
<script>
$(document).ready(function() {
	
	$(".deactivate_challenge").click(function() {
		
		var id = $(this).attr('id').substr(11);
		
		$.ajax({
			url: base_url + "ajaxcluster/deactivate_challenge",
			type: 'post',
			data: 'challenge_id='+id+"&cluster_id=<?php $edit_id; ?>",
			success: function(ret) {
				if(ret == 'success') {
					$("#deactivate_"+id).parents('.row').fadeOut('slow', function() {
						$("#deactivate_"+id).parents('.row').remove();
					});
				}
				else {
					alert(ret);
				}
			}
		})
		
	})
	
	$("#invite_code_button").click(function() {
		var code = $("#invite_code").val();
		
		$.ajax({
				url: base_url+"ajaxcluster/process_code",
			type: 'post',
			data: 'code='+code+"&id="+<?php echo $edit_id; ?>,
			success: function(ret) {
				$("#current_invite_code").text(ret);
				$("#invite_code_updated").text("Your invite code has been updated.");
			}
		});
		
	});
	
	$("#invite_challengers_button").click(function() {
		
		var emails = $("#invite_challengers").val();
		if(emails) {

			$.ajax({
				url: base_url+"ajaxcluster/process_invites",
				type: "post",
				dataType: 'json',
				data: "emails="+emails+"&id="+<?php echo $edit_id; ?>,
				success: function(ret) {
					$("#invite_challengers_result").html("<p>Your invites have been sent.</p>")
					for(var i in ret['emails']) {
						$(".current_invites").append("<div class='row'><div class='email med'>"+ret['emails'][i]+"</div><div class='status'>pending</div></div>");
					}
				}
			});

		}
		
	});
});
</script>					
			<h1 class='awesometitle'>Invite Challengers</h1>
	        <div class="InfoDisplay">
				<h3>Current Invites</h3>
				<div class="current_invites">
				<?php 
					$invites = $this->MItems->get_cluster_invites($edit_id, 0);
					
					if($invites){
						foreach($invites as $invite) {
				?>
							<div class="row">
								<div class="email med"><?php echo $invite->email; ?></div>
								<div class="status"><?php echo $invite->status; ?></div>
							</div>
				<?php
						}
					}
				?>
				</div>
				<h3>Invite Challengers</h3>
				<p>Enter your challengers emails separated by a comma to send out invites.</p>
				<textarea id="invite_challengers" name="invite_challengers" /></textarea>
				<div id="invite_challengers_button" class="small_button">Invite</div>
				<div id="invite_challengers_result"></div>
			</div>
		</div>
		<!-- End Widgets Tab -->
		<?php endif; ?>
		
		<?php if(!$new) : ?>
		<!-- Widgets Tab -->
		<div id="ClusterWidgets" class="cluster_form_tab" style="display:none">
			<h1 class='awesometitle'>Create Widgets</h1>
	        <div class="InfoDisplay" style="padding:2%; width:96%; float:left;">
				<?php
					$data['id'] = $edit_id;
					$data['type'] = 'cluster';
					$data['inline'] = true;
				
					$this->load->view('widgets/create', $data);
				?>
			</div>
		</div>
		<!-- End Widgets Tab -->
		<?php endif; ?>
	</form>
	
	<div class="">
	
	<img src="<?php echo base_url(); ?>images/backgrounds/challenge-blue-bottom.gif">
</div>

	
<div style="clear:both;"></div>

</div>






<?php

$this->load->view('framework/footer');

?>