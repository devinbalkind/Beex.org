<?php
	
	$this->load->view('widgets/header');
	
?>

<script language="javascript" type="text/javascript">

$(document).ready(function() {
	
	$('.dynamic_text').focus(function() {
		if($(this).val() == 'Type your challenge here...') {
			$(this).val('');
		}
		
		$(this).removeClass('light_gray');
		$(this).addClass('dark_gray');
		
	});
	
});

</script>

<style>

a {text-decoration:none; color:#<?php echo $link_color; ?>;}
a:hover {color:#<?php echo $hover_color; ?>;}

.widget h1 { background-color:#<?php echo $border_color; ?>;}

.widget_body {border:8px solid #<?php echo $border_color; ?>; height:66px; padding-top:15px;}

.widget_footer {background-color:#<?php echo $border_color; ?>;}

</style>

<div class="widget npo_supporting_widget npo_declaration_widget">
	<h1>What will you do to support us?</h1>
	<div class="widget_body">
		<div class="support_organization">
			
			<form class="support_form" target="_blank" method="post" action="<?php echo base_url().'index.php/challenge/start_a_challenge/from_widget/1/organization/'.$npo_id; ?>">
				<label>I will</label>
				<textarea class="text dynamic_text light_gray textarea" name="challenge_declaration" />Type your challenge here...</textarea>
 				<input type="image" class="submit" src="<?php echo base_url(); ?>images/buttons/widget-submit-off.png" />
				<p class="bottom_links"><a href="">What is BEEx?</a> | <a href="">How do I sign up my organization?</a> | <a href="">FAQ</a></p>
			</form>
		</div>
	</div>		
<?php

	$this->load->view('widgets/footer');

?>