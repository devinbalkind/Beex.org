<?php

//$new = true;

//$challenge_info = $this->session->userdata('challenge_info');

if($message) {

	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";

} 



$attributes = array('id' => 'challengeform', 'class'=>'itemform');

if($new) {

	$challenge_info = array();
	//$this->session->set_userdata('challenge_info',$challenge_info);
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
		$edit_id = $item->id;
		$this->session->set_userdata('edit_id', $edit_id);
	}
}

if(!$edit_id) {
	$fb_user = $this->MUser->get_fb($this->session->userdata('user_id')); // whether or not we show fb connect dialog
}

if(isset($join) && $join) {
	
	$cluster_code = $cluster->theid;
	
}
elseif(isset($cluster)) {
	
	$cluster_code = $cluster->theid;
	
}


if(isset($cluster_code)) {
	$setup['npo_name'] = $this->beex->name_that_npo(($cluster_code));
}

$setup['edit'] = $edit;
$setup['new'] = $new;
$setup['item'] = $item;

$setup['npos'] = $this->MItems->getDropdownArray('npos', 'name');
if(isset($cluster_code) && $cluster_code) {

	$setup['npo_name'] = $this->beex->name_that_npo($cluster_code);
	$setup['cluster'] = $cluster;
}

if($this->uri->segment(3) == 'organization') {
	$npo_id = $this->uri->segment(4);
	if($npo_id) {
		$setup['npo'] = $npo_id;
		$npo = $this->MItems->getNpo($npo_id);
		$setup['npo_name'] = $npo->row()->name;
	}
}

$this->load->helper('array');
$this->load->helper('beexform');
$cells = challenge_form_setup($setup);
extract($cells);

$this->load->view('framework/header', $header);

//Sets up cluster code present variable
$is_code = (isset($cluster->invite_code) && $new);

?>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/beex_helper.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/start_login.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ajaxupload.3.5.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/challenge_form.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/dynamic_forms.js"></script>

<script language="javascript" type="text/javascript">
var edit_id = '<?php echo $edit_id; ?>';
var fb_user = '<?php echo @$fb_user; ?>';
</script>
<div id="ChallengeStart" class="start_something">

<div id="LeftColumn">
	
	<p class="direction">REQUIRED FIELDS<span class="required">*</span></p>
	
	<div id="help">
		
    	<h3><?php echo $help_title; ?></h3>
        <p><?php echo $help_copy; ?></p>
		<img class="top_border block" class="top_border" src="<?php echo base_url(); ?>images/backgrounds/help-column-top.png" />
		<div id="help_column">
			Hello. This is advice on how to complete the current step.
		</div>
		<img class="bottom_border" src="<?php echo base_url(); ?>images/backgrounds/help-column-bottom.png" />
        <span class="errors error_field" id="error_field"></span>
    </div>

</div>



<div id="RightColumn">
	
	<?php if(isset($cluster) && $this->MUser->part_of_cluster($this->session->userdata('user_id'), $cluster->theid) && $new) : ?>
		<p class="message">You have already created a challenge for this cluster. Are you sure you wish to create another?</p>
	<?php endif; ?>
	
	<?php if(!$this->session->userdata('user_id')) : ?>
	<?php 
		$text = 'start a challenge';
		if(isset($join) && $join) {
			$text='join a cluster';
		}
		displayStartLogin($text); 
	?>
	<?php elseif($is_code) :
		
		displayClusterInvite();
		
	?>
	<?php else: ?>
		<script>
		code_validated = true;
		</script>
 	<?php endif; ?>
	<form id="ChallengeForm" class="itemform" onsubmit="return false;" <?php if(!$this->session->userdata('user_id') || $is_code) : ?>style="display:none;"<?php endif; ?>>
		<div id="challengeInfo">
		    <h1 class='awesometitle'>
				<div class="long_text_input">
					<?php echo $challenge_title_cell; ?>
				</div>
				<?php if(isset($cluster)) : ?>
					<span class='cluster_title'>A member of the cluster <?php echo anchor('cluster/view/'.$cluster->theid, $this->MItems->getClusterName($cluster->theid)); ?></span>
				<?php endif; ?>
			</h1>
			
	        <div id="InfoDisplay" class="InfoDisplay">
            	<?php if(isset($cluster) && $cluster) : ?>
					<input type="hidden" name="cluster_id" id="cluster_id" value="<?php echo $cluster->theid; ?>" />
				<?php else : ?>
					<input type="hidden" name="cluster_id" id="cluster_id" value="" />
				<?php endif; ?>
				<div id="MediaViewer" class="mediaviewer">
					<div class="media">
					<?php if(isset($cluster) && ($cluster->cluster_ch_image || $cluster->cluster_ch_video)) : ?>
						<div id="MediaHolder_challenge" class="mediaholder" style="display:block;">
							<?php if($cluster->cluster_ch_image) : 
									$this->session->set_userdata('challenge_image', $cluster->cluster_ch_image); 
							?>
								<img id="main_image" src="<?php echo base_url(); ?>/media/clusters/<?php echo $cluster->theid.'/sized_'.$cluster->cluster_ch_image; ?>" />
								<input type="hidden" name="cluster_challenge_image" id="cluster_challenge_image" value="<?php echo $cluster->cluster_ch_image; ?>">
								<input type="hidden" name="challenge_video" id="challenge_video" value="" />
							<?php else: ?>
								<div class="video">
				                   <?php echo process_video_link($cluster->cluster_ch_video); ?>
									<input type="hidden" name="challenge_video" id="challenge_video" value="<?php echo $cluster->cluster_ch_video; ?>">
				                </div>
							<?php endif; ?>
							<div id="upload" style="display:none;"></div>
						</div>
					<?php elseif(!$new && ($item->challenge_image || $item->challenge_video)) : $present_media = true; ?>
						<div id="MediaHolder_challenge" class="mediaholder" style="display:block;">
							<?php if($item->challenge_image) : ?>
								<img id="main_image" src="<?php echo base_url(); ?>/media/challenges/<?php echo $item->id.'/sized_'.$item->challenge_image; ?>" />
							<?php else: ?>
								<div class="video">
				                   <?php echo process_video_link($item->challenge_video); ?>
				                </div>
							<?php endif; ?>
						</div>
						<p class="gray italic">Upload Challenge Media</p>
						<div class="form_element">
							<div class="input_picture">
								<div id="upload_challenge" class="ajax_upload"><div class="short_text_input"><input type="text" class='italic' value="Add image (4mb max)..." /></div><img id="challenge_upload_button" class="upload_button_off rollover" src="<?php echo base_url(); ?>images/buttons/upload-off.png"></div><span id="status_challenge" class="ajax_upload_status"></span>
							</div>
						</div>
						<p class="gray italic">OR</p>
						<div class="form_element">
							<img id="PostVideoButton_challenge" class="upload_button_off rollover post_video_button" src="<?php echo base_url(); ?>images/buttons/post-off.png"><div class="short_text_input" style="margin-bottom:5px;"><?php echo $video_cell; ?></div>
							<span class="error status_video" id="status_video" ></span>
						</div>
					<?php else: ?>
						<div id="MediaHolder_challenge" class="mediaholder"></div>
						<p class="gray italic">Upload Challenge Media</p>
						<div class="form_element">
							<div class="input_picture">
								<div id="upload_challenge" class="ajax_upload"><div class="short_text_input"><input type="text" class='italic' value="Add image (4mb max)..." /></div><img id="challenge_upload_button" class="upload_button_off rollover" src="<?php echo base_url(); ?>images/buttons/upload-off.png"></div><span id="status_challenge" class="ajax_upload_status"></span>
							</div>
						</div>
						<p class="gray italic">OR</p>
						<div class="form_element">
							<img id="PostVideoButton_challenge" class="upload_button_off rollover post_video_button" src="<?php echo base_url(); ?>images/buttons/post-off.png"><div class="short_text_input" style="margin-bottom:5px;"><?php echo $video_cell; ?></div>
							<span class="error status_video" id="status_video" ></span>
						</div>
					<?php endif; ?>
					</div>
					<a id="CancelButton_challenge" class="cancelbutton" <?php if(isset($present_media) && $present_media) echo "style='display:block;'"; ?>>Change Media</a>
					<div class="donation">                          
						<p class="gray"><span class="required">*</span> Fundraising end date:</p>
           				<div class="short_text_input">
							<?php echo $completion_cell; ?>
						</div>
					</div>
				</div>
				<div id="Declaration" class="declaration_class">
				
					<div id="Body">
						<?php if($new) :?>
						<div class="partner_cntr">
							<p class="gray_italic"><span class="required">*</span>Do you have a partner for this challenge?</p>
							<div class="gray"><input type="radio" name="partner_bool" value="yes"> Yes <input type="radio" name="partner_bool" value="no" checked> No</div>
						</div>
						<?php endif; ?>
					
						<div class="partner_info_cntr" style="display:none; margin-top:15px;">
							<div class="form_element">
								<label>Partner Name:</label>
								<div class="short_text_input"><input type="text" class="dark_gray" name="partner_name" id="partner_name" value="<?php set_value('partner_name'); ?>" ></div>
							</div>
							<div class="form_element">
								<label>Partner Email:</label>
								<div class="short_text_input"><input type="text" class="dark_gray" name="partner_email" id="partner_email" value="<?php set_value('partner_email'); ?>"></div>
							</div>
							<div class="errors" id="partner_errors">
								
							</div>
							<img id="partner_next" class="rollover" src="<?php echo base_url(); ?>images/buttons/reg-next-off.png" />
							
						</div>
						
						<div class="declare">
							
							<div class="declaration_cntr">
								<img src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/declaration-top.png" />
								<div class="sub_declaration_cntr">
									<p class='italic'><span class="required">*</span><span class='declare_pronoun'><?php echo ($edit_id) ? $this->MItems->hasTeammates($edit_id) : 'I' ; ?></span> will</p>
									<?php echo $challenge_declaration_cell; ?>
								</div>
								<img src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/declaration-bottom.png" />
							</div>
							<span class="israisedfor">
								<span class="if">if </span>
								<div class="short_text_input">
									<span style='float:left; margin:3px 0 0 6px;' class='italic'>$</span>
									<?php echo $goal_cell; ?>
								</div> 
								<span class="israised">is raised for</span>
							</span>
							<?php echo  $npo_cell; ?>
						</div>
					</div>
				</div>
			
			
				<div id="Blurb">
				
					<div class="description_cntr">
						<img class="block" src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/description-top.png" />
						<div class="input_textarea_long"><?php echo $description_cell; ?></div>
						<img src="<?php echo base_url(); ?>images/backgrounds/challenge_forms/description-bottom.png" />	
					</div>
				
						
					<div class="form_element">
						<label>Website:</label>
						<div class="input_text"><?php echo $link_cell; ?></div>
					</div>
			
					<div class="form_element">
						<label>Challenge Location:</label>
						<div class="input_text"><?php echo $location_cell; ?></div>
					</div>
			
					<div class="form_element" style="padding-top:2px; margin-bottom:0px; padding-bottom:10px;">
						<label style="vertical-align:top;">Proof Description:<span class="required">*</span></label>
						<div class="input_textarea"><img src='<?php echo base_url(); ?>images/backgrounds/text-area-top.png'><?php echo $proof_description_cell; ?><img src='<?php echo base_url(); ?>images/backgrounds/text-area-bottom.png'></div>
					</div>
				</div>    
	            <div style="clear:both;"></div>
				<div class="form_save_cell"><img class="save_challenge rollover" src="<?php echo base_url(); ?>images/buttons/<?php echo ($edit) ? "save" : "reg-form-submit"; ?>-off.png" /></div>
				
	        </div>
	    </div>
	
	</form>
	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/challenge-blue-bottom.gif">
</div>

	
<div style="clear:both;"></div>

</div>






<?php

$this->load->view('framework/footer');

?>