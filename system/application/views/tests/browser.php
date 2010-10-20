<?php

$this->load->view('framework/header', $header);

?>

<script>

jQuery(document).ready(function(){
	
	$("#Menu .menu_item").click(function() {
		
		var color = $(this).attr('id').substring(6);
		
		$("#Frame").slideUp(1000, function () {
			$("#Frame").css('backgroundColor', color);
			$("#Frame").load(base_url + '/test/ajaxTest/'+color, function() {
				$("#Frame").slideDown(1000);
			});
		});
		
		
	});
	
});
</script>

<style>
#NewBrowser {width:800px; height:400px; position:relative;}
#NewBrowser #Menu {background-color:#03F; color:#fff; width:28%; height:100%; padding:1%; float:left;}
#NewBrowser #Frame {background-color:#CFF; width:68%; height:100%; float:left; padding:1%; position:relative; z-index:10;}

#NewBrowser #AjaxLoad {position:absolute; top:40%; left:65%;}
</style>

<div id="NewBrowser">

	<div id="Menu">
    	<div class="menu_item" id="color_red">Red</div>
        <div class="menu_item" id="color_blue">Blue</div>
        <div class="menu_item" id="color_orange">Orange</div>
    </div>
    
    <div id="Frame">
    
    </div>
    <img src="<?php echo base_url(); ?>images/ajax-loader.gif" id="AjaxLoad">

</div>



<?php


$this->load->view('framework/footer');

?>