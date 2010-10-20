<?php

if(ctype_digit($this->session->userdata("fb_user"))) {
	$fb_user = $this->session->userdata("fb_user");
}
else {
	$fb_user = false;
}



?>

<style>
body {padding:0px; margin:0px;}
#UpperMenu {text-align: right; font: 11px Verdana,Geneva,sans-serif; text-transform:uppercase;}
#UpperMenu a {color:#000; text-decoration:none;}
#UpperMenu a:hover {color:#666;}
</style>

<div id="UpperMenu">

  	 <?php
	
	 	if($user_id = $this->session->userdata('user_id')) :
	
	?>
			
			<?php if($this->session->userdata('super_user')) : ?>
				<?php echo anchor('admin/', 'Admin', array('target'=>'_parent')); ?> &bull;
			<?php endif; ?>
			<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

			<script type="text/javascript">
			       FB.init("a8656fd483cd0ba9c14474feb455bc98", "/xd_receiver.htm");
			</script>
			
			<?php if($fb_user) : ?>
			
				<a href="#" onclick="FB.Connect.logout(function() {top.location='<?=base_url()?>index.php/user/logout' }); return false;">Logout</a>
			
			<?php else : ?>
				<a href="<?=base_url()?>index.php/user/logout" target="_parent">Logout</a>
			
			<?php endif; ?>
			
			<?php
            // "a8656f..." should be replaced with $this->config->item('facebook_api_key');
            echo ' &bull; '.anchor('user/view/'.$user_id, 'My Profile', array('target'=>'_parent'));
        else :

			echo anchor('user/newuser', 'Register', array('target'=>'_parent')).' | '.anchor('user/login', 'Login', array('target'=>'_parent'));

		endif; 

     ?>

  </div>