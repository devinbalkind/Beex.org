<?php
	
	$this->load->view('widgets/header');
	
?>

<script language="javascript" type="text/javascript">

$(document).ready(function() {
	
	$('.dynamic_text').focus(function() {
		if($(this).val() == 'Type your challenge here') {
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

.widget .feed a.activity  {color:#<?php echo $title_color; ?>;}

.widget_body {border:8px solid #<?php echo $border_color; ?>; height:310px;}

.widget_footer {background-color:#<?php echo $border_color; ?>;}

.title_color {color:#<?php echo $title_color; ?>; border-color:#<?php echo $title_color; ?>;}

.npo_supporting_widget .feed {height:210px;}

.support_organization .statement {font:bold 9px 'Verdana', arial, sans-serif; color:#5C6771; padding:10px 0px 6px;}
.support_form input.text {-moz-border-radius:8px; border-radius:8px; height:12px; width:269px; padding:3px 5px; border:1px solid #BEC4C4; float:left; font:9px Verdana; margin-bottom:6px;}
.support_form input.submit {float:right;}

.support_form input.light_gray {color:#BEC4C4; font-style:italic;}
.support_form input.dark_gray {color:#5C6771; font-style:normal;}

.npo_supporting_widget .bottom_links {text-align:left;}



</style>

<div class="widget npo_supporting_widget">
	<h1>How People are Supporting Us</h1>
	<div class="widget_body">
		
		<div class="feed">
			<div id="FeedContent">
			<?php echo $this->beex->create_browser($challenges, 'challenges', 'profile', true); ?>
			</div>
		</div>
		
		<div class="rd_controls controls title_color"><img class="scrollUp" src="<?php echo base_url(); ?>images/buttons/up.png"><img class="scrollDown" src="<?php echo base_url(); ?>images/buttons/down.png"></div>
		
		<div class="support_organization">
			<p class="statement">What would you do to support <?php echo $npo_name; ?>?</p>
			<form class="support_form" target="_blank" method="post" action="<?php echo base_url().'index.php/challenge/start_a_challenge/from_widget/1/organization/'.$npo_id; ?>">
				<label class="title_color">I will</label>
				<input type="text" class="text dynamic_text light_gray" name="challenge_declaration" value="Type your challenge here" />
 				<input type="image" class="submit" src="<?php echo base_url(); ?>images/buttons/widget-submit-off.png" />
				<p class="bottom_links"><a href="">What is BEEx?</a> | <a href="">How do I sign up my organization?</a> | <a href="">FAQ</a></p>
			</form>
		</div>
	</div>		
<?php

	$this->load->view('widgets/footer');

?>