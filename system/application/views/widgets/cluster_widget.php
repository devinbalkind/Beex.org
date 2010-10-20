<?php
	
	$this->load->view('widgets/header');
	
?>

<script language="javascript" type="text/javascript">
$(document).ready(function() {
	//alert('test');
})

</script>

<style>

a {text-decoration:none; color:#<?php echo $link_color; ?>;}
a:hover {color:#<?php echo $hover_color; ?>;}

.widget .rd_controls {border-top-width:2px; padding-top:5px; border-color:#<?php echo $title_color; ?>;}

.widget h1 { background-color:#<?php echo $border_color; ?>;}

.widget .feed a.activity  {color:#<?php echo $title_color; ?>;}

.widget_body {border:8px solid #<?php echo $border_color; ?>; padding:9px 11px; height:300px;}

.widget_footer {height:42px; background-color:#<?php echo $border_color; ?>; -moz-border-radius:0 0 30px 30px; border-radius:0 0 30px 30px;}

</style>

<div class="widget">
	<h1><?php echo $cluster_title; ?></h1>
	<div class="widget_body">
		<!-- Cluster Specific Search Code -->
		<div class="cluster_search_cntr row join start_something">
			<div class='form_input'>
				<div class="short_text_input">
					<input type="text" id="cluster_search_term" class="go_blank">
				</div>
			</div>
			<img src="<?php echo base_url(); ?>images/buttons/search-off.png" class="rollover cluster_search_button" id="cluster_search_button<?php echo $cluster_id;?>" />
			<img src="<?php echo base_url(); ?>images/graphics/beex-loading.gif" class="beex-loading"/>
			<a id="view_all_challenges">(View All Challenges)</a>
			<div style="float:left; clear:both;"></div>
		</div>
		<!-- End Cluster Search -->
		<div class="feed">
			<div id="FeedContent">
			<?php echo $this->beex->create_browser($challenges, 'challenges', 'profile', true); ?>
			</div>
		</div>
		
		<div class="rd_controls controls"><img class="scrollUp" src="<?php echo base_url(); ?>images/buttons/up.png"><img class="scrollDown" src="<?php echo base_url(); ?>images/buttons/down.png"></div>
		
		<p class="bottom_links"><a href="">What is BEEx?</a> | <a href="">How do I sign up my organization?</a> | <a href="">FAQ</a></p>
	</div>
	
<?php

	$this->load->view('widgets/footer');

?>