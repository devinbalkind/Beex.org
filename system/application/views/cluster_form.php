<?php



//$new = true;



if($new) {

	$edit = true;
	$attributes = array('id' => 'clusterform', 'class'=>'itemform');
	$edit_id = '';

}



elseif($edit){

	$edit = true;
	$attributes = array('id' => 'clusterform', 'class'=>'itemform');
	$item = $item->row();
	$edit_id = '';
	if($item) {
		$edit_id = $item->theid;
	}
	
	$this->session->set_userdata("cluster_image", $item->cluster_image);
		
}





if($username = $this->session->userdata('username')) {



	$name = 'admin_email';
	$logged_in = true;

	$admin_email_cell =  $username;
	//generate_input($name, 'hidden', $edit, $username);



}

else {

$data = array('name'=>'admin_email', 'id'=>'admin_email', 'size'=>25, 'value'=>($new) ? set_value('admin_email') : $item->admin_email);
$admin_email_cell = ($edit) ? form_input($data) : $item->admin_email;



$name = 'password';
$value = ($new) ? set_value($name) : $item->$name;
$password_cell = generate_input($name, 'password', $edit, $value);



}



if($new) {



$name = 'admin1_name';
$value = ($new) ? set_value($name) : $item->$name;
$admin1_name_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin2_name';
$value = ($new) ? set_value($name) : $item->$name;
$admin2_name_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin3_name';

$value = ($new) ? set_value($name) : $item->$name;

$admin3_name_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin4_name';

$value = ($new) ? set_value($name) : $item->$name;

$admin4_name_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin5_name';

$value = ($new) ? set_value($name) : $item->$name;

$admin5_name_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin1_email';

$value = ($new) ? set_value($name) : $item->$name;

$admin1_email_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin2_email';

$value = ($new) ? set_value($name) : $item->$name;

$admin2_email_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin3_email';

$value = ($new) ? set_value($name) : $item->$name;

$admin3_email_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin4_email';

$value = ($new) ? set_value($name) : $item->$name;

$admin4_email_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin5_email';

$value = ($new) ? set_value($name) : $item->$name;

$admin5_email_cell = generate_input($name, 'input', $edit, $value);



$name = 'personal_message';
$value = ($new) ? set_value($name) : $item->$name;
$personal_message_cell = generate_input($name, 'text', $edit, $value);

}



$name = 'affiliate_organization';
$value = ($new) ? set_value($name) : $item->$name;
$affiliate_cell = generate_input($name, 'text', $edit, $value);



//NPO



$npos = $this->MItems->getDropdownArray('npos', 'name');



/*$npos = array(

			'Brooklyn for Peace' => 'Brooklyn for Peace',

           'Greenpeace' => 'Greenpeace',

		   'Project Kindle' => 'Project Kindle',

		   'Bear Necessities' => 'Bear Necessities',

		   "Children's Heart Foundation" => "Children's Heart Foundation",

		   'Juvenile Diabetes Research Foundation' => 'Juvenile Diabetes Research Foundation'



			);*/



$data = array('name'=>'cluster_npo', 'id'=>'cluster_npo');
$value = ($new) ? set_value('cluster_npo') : $item->cluster_npo;
$npo_cell = ($edit) ? form_dropdown('cluster_npo', $npos, $value) : $item->cluster_npo;


$name = 'cluster_title';
$value = ($new) ? set_value($name) : $item->$name;
$title_cell = generate_input($name, 'input', $edit, $value);


$name = 'cluster_goal';
$value = ($new) ? set_value($name) : $item->$name;
$goal_cell = generate_input($name, 'input', $edit, $value, '', 'short');


$name = 'cluster_blurb';
$value = ($new) ? set_value($name) : $item->$name;
$blurb_cell = generate_input($name, 'text', $edit, $value);


$name = 'cluster_description';
$value = ($new) ? set_value($name) : $item->$name;
$description_cell = generate_input($name, 'text', $edit, $value, '', 'bigtext');


$name = 'cluster_video';
$value = ($new) ? set_value($name) : $item->$name;
$video_cell = generate_input($name, 'text', $edit, $value);


$name = 'cluster_image';
$value = ($new) ? set_value($name) : $item->$name;
$image_cell = generate_input($name, 'text', $edit, $value);

$name = 'cluster_location';
$value = ($new) ? set_value($name) : $item->$name;
$location_cell = generate_input($name, 'input', $edit, $value);



/*

//Completion

$data = array('name'=>'cluster_completion', 'class'=>'datepicker', 'id'=>'cluster_completion', 'size'=>25, 'value'=>($new) ? set_value('cluster_completion') : $item->cluster_completion);

$completion_cell = ($edit) ? form_input($data) : $item->cluster_completion;



//Time

$name = 'cluster_time';

$value = ($new) ? set_value($name) : $item->$name;

$time_cell = generate_input($name, 'input', $edit, $value);



//Fund Raising Completion

$data = array('name'=>'cluster_fr_completed', 'class'=>'datepicker', 'id'=>'cluster_fr_completed', 'size'=>25, 'value'=>($new) ? set_value('cluster_fr_completed') : $item->cluster_fr_completed);

$fr_cell = ($edit) ? form_input($data) : $item->cluster_fr_completed;



// Proof Completion

$data = array('name'=>'cluster_proof_upload', 'class'=>'datepicker', 'id'=>'cluster_proof_upload', 'size'=>25, 'value'=>($new) ? set_value('cluster_proof_upload') : $item->cluster_proof_upload);

$proof_cell = ($edit) ? form_input($data) : $item->cluster_proof_upload;



*/







$name = 'cluster_ch_title';

$value = ($new) ? set_value($name) : $item->$name;

$ch_title_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_declaration';

$value = ($new) ? set_value($name) : $item->$name;

$ch_declaration_cell = generate_input($name, 'text', $edit, $value);



$name = 'cluster_ch_goal';
$value = ($new) ? set_value($name) : $item->$name;
$ch_goal_cell = generate_input($name, 'input', $edit, $value, '', 'short');







// Cluster Challenge Where



$name = 'cluster_ch_location';
$value = ($new) ? set_value($name) : $item->$name;
$ch_location_cell = generate_input($name, 'input', $edit, $value);


$name = 'cluster_ch_address';
$value = ($new) ? set_value($name) : $item->$name;
$ch_address_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_address2';
$value = ($new) ? set_value($name) : $item->$name;
$ch_address2_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_city';
$value = ($new) ? set_value($name) : $item->$name;
$ch_city_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_state';
$value = ($new) ? set_value($name) : $item->$name;
$ch_state_cell = generate_input($name, 'dropdown', $edit, $value, get_special_array('states'));



$name = 'cluster_ch_zip';
$value = ($new) ? set_value($name) : $item->$name;
$ch_zip_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_network';
$value = ($new) ? set_value($name) : $item->$name;
$ch_network_cell = generate_input($name, 'dropdown', $edit, $value, get_special_array('networks'));



$name = 'cluster_ch_attend';
$value = ($new) ? set_value($name) : $item->$name;
$ch_attend_cell = generate_input($name, 'dropdown', $edit, $value, get_special_array('attend'));



// Cluster Challenge When



$name = 'cluster_ch_fr_ends';
$value = ($new) ? set_value($name) : $item->$name;
$ch_fr_ends_cell = generate_input($name, 'input', $edit, $value, '', 'datepicker');



$name = 'cluster_ch_completion';
$value = ($new) ? set_value($name) : $item->$name;
$ch_completion_cell = generate_input($name, 'input', $edit, $value, '', 'datepicker');



$name = 'cluster_ch_proofdate';
$value = ($new) ? set_value($name) : $item->$name;
$ch_proofdate_cell = generate_input($name, 'input', $edit, $value, '', 'datepicker');





// Cluster challenge Why



$name = 'cluster_ch_blurb';
$value = ($new) ? set_value($name) : $item->$name;
$ch_blurb_cell = generate_input($name, 'text', $edit, $value);



$name = 'cluster_ch_description';
$value = ($new) ? set_value($name) : $item->$name;
$ch_description_cell = generate_input($name, 'text', $edit, $value);



$name = 'cluster_ch_video';
$value = ($new) ? set_value($name) : $item->$name;
$ch_video_cell = generate_input($name, 'text', $edit, $value);











?>



<?php if($new) :?>
<div id="ClusterForm" class="form">

<div id="LeftColumn">
</div>
<?php endif; ?>


<div id="RightColumn">



	<div class="featuredbox">

	    <?php if($message) {

	echo "<p class='message'>".$message."<span class='val_errors'>";

	echo validation_errors();

	echo "</span></p>";

} ?>

    </div>



    <div class="module">

        <h2 class="title titlebg"><?php echo ($new) ? "Start A" : "Edit"; ?> Cluster</h2>

        <div class="InfoDisplay FormBG">

<?php



if(!$edit) {

	echo "<tr><td colspan=2>".anchor('item/view/cluster/'.$item->id.'/1', 'Edit', array('class'=>'editbutton'))."</td></tr>";

}





if($new)

	$edit = true;



if($edit){



	echo form_open_multipart('cluster/process/cluster/'.$edit_id, $attributes);

}

?>


<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/beex_helper.js"></script>	
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ajaxupload.js"></script>	
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
<script type="text/javascript">
	FB.init("a8656fd483cd0ba9c14474feb455bc98", "/xd_receiver.htm");
</script>

<script type="text/javascript">
if (!Array.prototype.indexOf) // IE6 compatibility for Array.prototype.indexOf
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length >>> 0;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}

$(document).ready(function() {
	

	$("#clusterform").keypress(function(e) { 
		if(e.keyCode === 13) {
			return false;		
		}
	});
	
	
	
	var num_admin_cells = 1;
	var tab_list = ["who_tab", "admin_invite_tab", "what_tab", "media_tab", "challenge_control_tab"];
	current_tab = 'who_tab'; 

<?php	

	if(isset($logged_in) && $logged_in==true) {
		echo "current_tab = 'admin_invite_tab'; $('#who_tab').hide();\n\n";
	}

	if(isset($edit_id) && $edit_id != '') {
//		$challenge_creation_step = 'what';
		echo 'field_array = ';
		echo json_encode($item) . ';';
		if(isset($item->cluster_image)) {
			$ch_img = base_url() . 'media/clusters/' . $item->cluster_image;
			echo <<<JS_IMG
				ch_img = document.createElement("img");
				ch_img.src = "{$ch_img}";
				$("#upload_area").append(ch_img);

JS_IMG;
		}
		echo <<<JAVASCRIPT

			for(fieldName in field_array) {
				if($("#" + fieldName).length > 0) {
					$("#" + fieldName).val(field_array[fieldName]);
				}
			}
			
			current_tab = 'what_tab';
			$("#who_tab, #admin_invite_tab, #what_tab_prev_btn").remove();

JAVASCRIPT;
			
	}
?>


	nextTab(current_tab);
		
	function nextTab(param) {
		$("#error_field").html("");
		if(typeof param != 'object') {
			next_index = tab_list.indexOf(param);
		}
		else {
			next_index = tab_list.indexOf(current_tab)+1;	
		}
		toTab = tab_list[next_index];	
		for(tab in tab_list) {
			$("#" + tab_list[tab]).hide();
		}
		$("#" + toTab).show();
		current_tab = toTab;		
	}
	function prevTab() {
		next_index = tab_list.indexOf(current_tab)-1;	
		toTab = tab_list[next_index];	
		for(tab in tab_list) {
			$("#" + tab_list[tab]).hide();
		}
		$("#" + toTab).show();
		current_tab = toTab;		
	}
	
	function newAdminCell() {
		var admin_cell = document.createElement("input");
		admin_cell.name = "admin" + (++num_admin_cells) + "_name";		
		admin_cell.id = "admin" + num_admin_cells + "_name";
		admin_cell.type = "text";
		admin_cell.onblur = makeMoreAdmins;
		return admin_cell;
	}
	
	function newLabel(text) {
		var label_cell = document.createElement("label");
		label_cell.innerHTML = text;
		return label_cell;
	}
	
	function makeMoreAdmins() {
		var all_full = true;
		for(var i=1;i<=num_admin_cells;i++) {
			var cur_cell_contents = $("#admin" + i + "_name").val();
			if(cur_cell_contents == '' || cur_cell_contents.indexOf('@')==-1) {
				all_full = false;
			}
		}
		if(all_full) {
			$(this).parent().append("<br>"); // would rather do this by having CSS set a clear:left on the label selector
			$(this).parent().append(newLabel("Admin " + i + " email: "));
			$(this).parent().append(newAdminCell());
		}				
	}
	$("#admin1_name").blur(makeMoreAdmins);	
	$('.next_btn').click(nextTab);
	$('.prev_btn').click(prevTab);
	
	$("#who_tab_next_btn").unbind();
	$("#who_tab_next_btn").click(function() {
		
		var email = $("#admin_email").val();
		var password = $("input[name='password']").val();		
		
		var signup_email = $("#signup_email").val();
		var signup_name = $("#signup_name").val();
		var signup_pass = $("#signup_pass").val();
		var signup_passconf = $("#signup_passconf").val();
				
		if(signup_passconf != signup_pass) {
			$("#error_field").html("Your passwords must match, son!");
			return;
		}
		
		if(signup_email && signup_name && signup_pass  && signup_passconf) {
			jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/ajax/create_user",
				 dataType: "json",
				 data: "email=" + signup_email + "&legal_name=" + signup_name + "&password=" + MD5(signup_pass),
				 success: function(ret){
					if(ret['success']) { // advance to the next step. 
						window.location = window.location;
					}
					else {
						$("#error_field").html(ret['errors']);
					}
				 }
			});
			// do the ajax reg
		}
		else {
			jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/ajax/login_user",
				 dataType: "json",
				 data: "email=" + email + "&password=" + password,
				 success: function(ret){
					if(ret['success']) { // advance to the next step. 
						window.location = window.location;
					}
					else {
						$("#error_field").html(ret['errors']);
					}
				 }
			});
		}
		
	

		
	});
	
	$("#what_tab_next_btn").unbind();
	$("#what_tab_next_btn").click(function() {
		cluster_title = $('input[name=cluster_title]').val();
		if(cluster_title.length == 0) {
			$("#error_field").html("Cluster title is required.");
			return false;
		}
		else {
			nextTab('media_tab');
		}
	});
	
	
	$("#already_have_account").click(function() {
		$("#existing_account_div").show();
		$("#user_registered_yet").hide();
		$("#who_tab_next_btn").show();
	});
	$("#no_account_yet").click(function() {
		$("#new_account_div").show();
		$("#user_registered_yet").hide();		
		$("#who_tab_next_btn").show();
	});
	

	
});
</script>

<div id="cluster_area"> <!-- enclosure .. -->
	<div id="nav_bar">
		<span class="nav_button" id="nav_who">Who</span><span class="nav_button" id="nav_what">Administratiors</span><span class="nav_button" id="nav_what">What</span><span class="nav_button" id="nav_media">Media</span><span class="nav_button" id="nav_challenge">Challenges</span>
	</div>
	<div id="help">
    	<h3>Need Help???</h3>
        <p>This column has revelent info for the creation step you're on. Check back here if you get stuck.</p>
		<div id="help_column">
			Hello. This is advice on how to complete the current step.
		</div>
        <span class="errors error_field" id="error_field"></span>
    </div>
	
			<div id="cluster_data_area"> <!-- data enclosure .. -->
				<div id="who_tab" class="cluster_tab">										
					<div id="user_registered_yet">
						<h2>Do you already have an account on BeEx?</h2>
						<div class="input_buttons" style="text-align:left; margin:5px 0px 32px;">
		                	<img src="<?php echo base_url(); ?>images/buttons/yes.gif" name="already_have_account" id="already_have_account" class="account_yet" value="Yes">
							<img src="<?php echo base_url(); ?>images/buttons/no.gif" name="no_account_yet" id="no_account_yet" class="account_yet" value="Not Yet!">
		                </div>
						<h2>Or, login/register through Facebook connect!</h2>
						<div class="input_buttons" style="text-align:left; margin:5px 0px;">					
							<fb:login-button onlogin="window.location='<?=base_url()?>index.php/user/login'"></fb:login-button>
						</div>
					</div>		
					<div id="existing_account_div" style="display:none">
						<h5>Existing Users Log-In</h5>
						<div class="input_wrapper">
							<label>Admin Email:</label>
							<?php echo $admin_email_cell; ?>
						</div>	
						<div class="input_wrapper">
							<label>Password:</label>
							<?php echo $password_cell; ?>
						</div>	
					</div>
					<div id="new_account_div" style="display:none">					
		            	<h5>If you haven't registered yet for Beex.org, don't worry.</h5>
						<h6>You can enter your name, email and password below.</h6>
			            <div class="input_wrapper">
							<label>Name:</label>
							<?php echo generate_input('signup_name', 'input', true, ''); ?>
						</div>
				        <div class="input_wrapper">
							<label>Email:</label>
							<?php echo generate_input('signup_email', 'input', true, ''); ?>
						</div>
			            <div class="input_wrapper">
							<label>Password:</label>
							<?php echo generate_input('signup_pass', 'password', true, ''); ?>
						</div>
			            <div class="input_wrapper">
							<label>Password Confirm:</label>
							<?php echo generate_input('signup_passconf', 'password', true, ''); ?>
						</div>
					</div>		
					<div class="input_buttons">
						<img src="<?php echo base_url(); ?>images/buttons/next.gif" alt="Next Step" id="who_tab_next_btn" class="next_btn" style="display:none">
					</div>
				</div> <!-- end who_tab -->
				
				
				<div id="admin_invite_tab" class="cluster_tab">						
                	<h5>Invite Additional Adminstrators</h5>
	                <div class="input_wrapper">
						<label>Admin 1 email:</label>
						<input type="text" name="admin1_name" id="admin1_name">
					</div>
					<div class="input_wrapper">
						<label>Personal Message:</label>
						<?php echo $personal_message_cell; ?>
					</div>
					<div class="input_buttons">
						<img src="<?php echo base_url(); ?>/images/buttons/next.gif" alt="Next Step" id="admin_invite_tab_next_btn" class="next_btn">
					</div>
					
	 			</div> <!-- end admin_invite_tab -->

				<!--  ***********  -->
				<div id="what_tab" class="cluster_tab">
  				    <h5>Cluster Information</h5>
		            <div class="input_wrapper">
						<label>Cluster Title:</label>
						<?php echo $title_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Fundraising Goal (optional):</label>
						<?php echo $goal_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Select your Nonprofit:</label>
						<?php echo $npo_cell; ?>						
					</div>
					<div class="input_wrapper">
						<label>Blurb (120 characters):</label>
						<?php echo $blurb_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Description:</label>					
						<?php echo $description_cell; ?>
					</div>
					<div class="input_buttons">
						<img src="<?php echo base_url(); ?>images/buttons/prev.gif" alt="Prev Step" id="what_tab_prev_btn" class="prev_btn">					
						<img src="<?php echo base_url(); ?>images/buttons/next.gif" value="Next Step" id="what_tab_next_btn" class="next_btn" />
					</div>
					
				</div> <!-- end what_tab div-->
				<!--  ***********  -->
				<div id="media_tab" class="cluster_tab">
					<h5>Media</h5>
					<?php if(!$new && $item->cluster_image) : ?>
						<div class="input_wrapper">
							<label>Current Image</label>
							<img src="/media/clusters/<?php echo $item->cluster_image; ?>" />
						</div>
                 	<?php endif; ?>
		            <div class="input_wrapper">
						<label>Select your image:<br><span class="small">(4MB max)</span></label>
						<fieldset>
							<form action="<?php echo base_url(); ?>index.php/ajax/image_upload" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
								<input type="hidden" name="maxSize" value="9999999999" />
								<input type="hidden" name="maxW" value="200" />
								<input type="hidden" name="fullPath" value="<?php echo base_url(); ?>/media/challenges/" />
								<input type="hidden" name="relPath" value="../uploads/" />
								<input type="hidden" name="colorR" value="255" />
								<input type="hidden" name="colorG" value="255" />
								<input type="hidden" name="colorB" value="255" />
								<input type="hidden" name="maxH" value="300" />
								<input type="hidden" name="filename" value="filename" />
								<p><input type="file" name="filename" onchange="ajaxUpload(this.form,'<?php echo base_url(); ?>index.php/ajax/image_upload','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload.'); return false;" /></p>
							</form>					
						</fieldset>
						<div id="upload_area" name="upload_area">					
						</div>			
						<?php //echo generate_input('cluster_image', 'file', $edit, ''); ?>
					</div>
					<div class="input_wrapper">
						<label>Embed Your Video:</label>
						<?php echo generate_input('cluster_video', 'text', $edit, ''); ?>
					</div>
					<div class="input_buttons">
						<img src="<?php echo base_url(); ?>images/buttons/prev.gif" alt="Prev Step" id="media_tab_prev_btn" class="prev_btn">
						<img src="<?php echo base_url(); ?>images/buttons/next.gif" alt="Next Step" id="media_tab_next_btn" class="next_btn">
					</div>
				</div> <!-- end media_tab div -->
				<!--  ***********  -->		
		 		<div id="challenge_control_tab" class="cluster_tab">
			        <h5>Challenge Control: 
						<span style="font-weight:normal;">Editing the fields below will change all challenges within your cluster...</span>
					</h5>
					<div class="input_wrapper">
						<label>Challenge Title:</label>
						<?php echo $ch_title_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Challenge Declaration: I/we will</label>
						<?php echo $ch_declaration_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Challenge Fundraising Goal:</label>
						$<?php echo $ch_goal_cell; ?>
					</div>
					
					<h5>When</h5>
					<div class="input_wrapper">
						<label>Challenge Fund Rasing Ends:</label>
						<?php echo $ch_fr_ends_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Challenge Completion:</label>
						<?php echo $ch_completion_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Challenge Proof Uploaded:</label>	
						<?php echo $ch_proofdate_cell; ?>
					</div>
					
					<h5>Where</h5>
					<div class="input_wrapper">
						<label>Location:</label>
						<?php echo $ch_location_cell; ?>
					</div>					
					<div class="input_wrapper">
						<label>Address:</label>
						<?php echo $ch_address_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Address 2 (if needed):</label>
						<?php echo $ch_address2_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>City:</label>
						<?php echo $ch_city_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>State:</label>
						<?php echo $ch_state_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Zip:</label>
						<?php echo $ch_zip_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Can people attend this challenge?:</label>
						<?php echo $ch_attend_cell; ?>
					</div>
					
					<h5>Why</h5>
					<div class="input_wrapper">						
						<label>Challenge Blurb:</label>
						<?php echo $ch_blurb_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Challenge Description:</label>
						<?php echo $ch_description_cell; ?>
					</div>
					
					<div class="input_wrapper">
						<label>Challenge Video:</label>
						<?php echo $ch_video_cell; ?>
					</div>
					<div class="input_buttons">
						<img src="<?php echo base_url(); ?>images/buttons/prev.gif" value="Prev Step" id="challenge_control_tab_prev_btn" class="prev_btn">					
					
						<input type="image" src="<?php echo base_url(); ?>images/buttons/finish.gif" style="width:auto;" />
					</div>
				</div> <!-- end challenge_control_tab div -->	
							    					
			</div> <!-- end cluster_data_area -->
<!-- end cluster_area -->

        </div>
    </div>
</div>



</div>

<div style="clear:both;"></div>