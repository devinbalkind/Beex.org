<?php
$this->load->view('framework/header', $header);
?>

<div id="SearchResults">

<div id="LeftColumn">
	
	<h2 class="title">Are you sure you wish to delete this challenge?</h2>
	
	<div class="buttons" style="padding:0px 0 32px;">
		<?php echo anchor('challenge/challenge_delete/'.$id, 'Yes', 'class="small_button float_left" style="margin-right:15px;"'); ?>
		<?php echo anchor('challenge/view/'.$id, 'No', 'class="small_button float_left"'); ?>
	</div>
	
    <p>Once you delete this challenge you will not be able to recover it.</p>
	
	

</div>

<div style="clear:both;"></div>

</div>


<?php
$this->load->view('framework/footer');
?>