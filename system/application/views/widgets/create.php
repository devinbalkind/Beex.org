<?php
	
	if(!@$inline) {
		$this->load->view('framework/header');
	}
?>

<link href="<?php echo base_url(); ?>colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo base_url(); ?>colorpicker/css/layout.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>colorpicker/js/colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>colorpicker/js/eye.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>colorpicker/js/utils.js"></script>

<script>

function updateWidgetDescription() {
	
	var widget_types = new Array();
	widget_types['cluster'] = "This widget displays your cluster's title and all of it's challenges in a searchable format.";
	widget_types['npo_supporting'] = "Test";
	widget_types['npo_declaration'] = 'Test';
	
	var widget_type = $("#widget_type").val();
	
	$("#widget_description").text(widget_types[widget_type]);
	
}

function updateWidgetDisplay() {
	
	var border_color = $("#border_color").val();
	var link_color = $("#link_color").val();
	var hover_color = $("#hover_color").val();
	var title_color = $("#title_color").val();
	<?php if($type == 'npo') : ?>
	var id = <?php echo $npo_id; ?>
	<?php elseif($type == 'cluster') : ?>
	var id = <?php echo $id; ?>
	<?php endif; ?>
	
	
	var widget_type = $("#widget_type").val();
		
	var widget_string = '<iframe width="362" height="500" frameborder=0 scrolling="no" src="'+base_url+'widgets/'+widget_type+'_widget/id/'+id+'/border_color/'+border_color+'/link_color/'+link_color+'/hover_color/'+hover_color+'/title_color/'+title_color+'" /></iframe>';
	
	$("#widget_code").val(widget_string);
	
	$("#widget_iframe").html(widget_string);

}

$(document).ready(function() {
	
	var picker_id;
	
	var border_color = $("#border_color").val();
	var link_color = $("#link_color").val();
	var hover_color = $("#hover_color").val();
	var title_color = $("#title_color").val();
	
	$('.colorSelector').ColorPicker({
		color: '#FFC400',
		onBeforeShow: function(colpkr) {
			picker_id = $(colpkr).attr('id');
		}, 
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#'+picker_id+' div').css('backgroundColor', '#' + hex);
			
			var color_field_id = picker_id.substr(3);
			$("#"+color_field_id).val(hex);
			
			updateWidgetDisplay();
			
		}
	});
	
	$('.colorSelector').click(function() {
		picker_id = $(this).attr('id');
	});
	
	$('#widget_type').change(function() {
		updateWidgetDescription();
		updateWidgetDisplay();
	});
	
	$('.colorSelector').each(function() {
		
		var id = $(this).attr('id').substr(3);
		var color = $("#"+id).val();
		$(this).ColorPickerSetColor("#"+color);
		
		$(this).children('div').css('backgroundColor', '#'+color);
		
	});
	
	updateWidgetDescription();
	updateWidgetDisplay();
});
</script>


<style>
#widget_form .left_col {width:300px; float:left; margin-right:20px;}
#widget_form .right_col {width:400px; float:left;}

#widget_form .form_element {margin-bottom:14px;}

#widget_form select {color:#5C6771;}

#widget_form .colors {margin-top:15px;}
#widget_form .color {width:49%; margin-right:1%; float:left; clear:none;}
#widget_form .color label {float:left; width:105px;}

#widget_form label {position:relative; display:block; clear:both;}
#widget_form .colorSelector {float:left;}

#widget_form textarea {width:100%; border:1px solid #BEC4C4; font:10px Verdana, sans-serif; color:#5C6771; -moz-border-radius:10px; border-radius:10px; height:100px; padding:5px;}

#widget_description {border-bottom:1px solid #BEC4C4; padding:5px 0; font-size:12px; color:#5C6771;}

</style>


	<div id="widget_form">
		
		<div class="left_col">
			<select id="widget_type" name="widget_type">
				<?php if($type == 'cluster') : ?>
				<option value="cluster">Searchable Cluster Sidebar</option>
				<?php elseif($type == 'npo') : ?>
				<option value="npo_supporting">Organization Full</option>
				<option value="npo_declaration">Organization Create</option>
				<?php endif; ?>
			</select>
			
			<div class="form_element" id="widget_description">
				
			</div>
		
			<input type="hidden" id="border_color" name="border_color" value="FFC400" />
			<input type="hidden" id="link_color" name="link_color" value="CC7322" />
			<input type="hidden" id="hover_color" name="hover_color" value="FFC400" />
			<input type="hidden" id="title_color" name="title_color" value="FFC400" />
			<?php if($type == 'npo') : ?>
			<input type="hidden" id="npo_id" name="npo_id" val="<?php echo $npo_id; ?>" />
			<?php endif; ?>
		
			<div class="colors">
				<div class="form_element color">
					<label>Border Color</label>
					<div class="colorSelector" id="cs_border_color"><div style="background-color: #FFF"></div></div>
				</div>
		
				<div class="form_element color">
					<label>Link Color</label>	
					<div class="colorSelector" id="cs_link_color"><div style="background-color: #FFF"></div></div>
				</div>
		
				<div class="form_element color">
					<label>Link Hover Color</label>
					<div class="colorSelector" id="cs_hover_color"><div style="background-color: #FFF"></div></div>
				</div>
		
				<div class="form_element color">
					<label>Title Color</label>
					<div class="colorSelector" id="cs_title_color"><div style="background-color: #FFF"></div></div>
				</div>
			</div>
			
			<label>Your Widget Code</label>
			<textarea id="widget_code"></textarea>
		</div>
		<div class="right_col">
			<div id="widget_iframe"></div>
		</div>
	</div>	
		
<?php

	if(!@$inline) {	
		$this->load->view('framework/footer');
	}
?>