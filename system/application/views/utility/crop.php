<html>
<head>


</head>

<body>

<div class="crop utility" id="Crop">
<link href="<?php echo base_url(); ?>jcrop/css/jquery.Jcrop.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery142.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>jcrop/js/jquery.Jcrop.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/beex_base.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ajaxupload.3.5.js"></script>
<script>
$(document).ready(function() {
		
		
		
		function initJcrop(el) {
			el.Jcrop({
				onChange: showPreview,
				onSelect: showPreview,
				aspectRatio: 1
			});
		}

		function setCoords(c) {
		    jQuery('#x').val(c.x);
		    jQuery('#y').val(c.y);
		    jQuery('#x2').val(c.x2);
		    jQuery('#y2').val(c.y2);
		    jQuery('#w').val(c.w);
		    jQuery('#h').val(c.h);
		}

		function showPreview(coords)
		{
			var rx = 100 / coords.w;
			var ry = 100 / coords.h;

			var img = $(".jcrop");

			$('#preview').css({
				width: Math.round(rx * img.width()) + 'px',
				height: Math.round(ry * img.height()) + 'px',
				marginLeft: '-' + Math.round(rx * coords.x) + 'px',
				marginTop: '-' + Math.round(ry * coords.y) + 'px'
			});

			setCoords(coords);
		};

		$(".crop_button").click(function() {
			var path = $("#path").val();
			var image = $("#image").val();

			var w = $("#w").val();
			var h = $("#h").val();

			if(!w || !h) {
				$(".error").text('Please select an area of the picture to crop.');
			}
			else {
				$.ajax({
					url: base_url+"ajax/jcrop_image",
					type: 'post',
					data: "path="+$("#path").val()+"&image="+$("#image").val()+"&x="+$("#x").val()+"&y="+$("#y").val()+"&w="+$("#w").val()+"&h="+$("#h").val(),
					success: function(ret) {
						parent.window.location = parent.window.location;
					}
				});
			}
		});
		
		var btnUpload=$('#upload');
		var status = $("#status");
		new AjaxUpload(btnUpload, {
			action: base_url + 'ajax/new_ajax_upload/profile/false/<?php echo $id; ?>',
			//Name of the file input box
			name: 'uploadfile',
			responseType: "json",
			onSubmit: function(file, ext){
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
	                  // check for valid file extension
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');

				//Add uploaded file to list
				if(response['success']) {
					$('.jcrop_image').html('<img class="jcrop" src="'+response['file']+'" />');
					$("#preview").attr('src', response['file']);
					
					$("#image").val(response['short_name']);
					
					initJcrop($('.jcrop'));
					
					var button_text = $('.upload_button').text().substr(6);
					$('.upload_button').text('Change '+button_text);
				
				}
				else {
					if(response['error']) {
						status.text(response['error']);
					}
					else {
						status.text('There was a problem with your upload');
					}
				}
			}
		});
		
		initJcrop($('.jcrop'));
		
});
	
$(function(){
		
});

</script>

<style>
	.crop h2 {font:24px 'Arial Rounded MT Bold', 'Arial Black', arial, sans-serif; text-transform:uppercase; clear:both;}
	.crop p {font:12px arial;}
	.crop .jcrop_image {border:2px solid #000; float:left; margin-right:10px; margin-bottom:15px;}
	.crop_button {font:bold 12px 'Arial Rounded MT Bold', 'Arial Black', arial, sans-serif; text-transform:uppercase; border:4px solid #FFC400; background-color:#FFC400; padding:2px; color:#fff; display:block; width:100px; -moz-border-radius:10px; webkit-border-radius:10px; text-align:center; margin-top:15px; clear:left; cursor:pointer;}
	a:hover {background-color:#fff; color:#ffc400;}
	.error {color:red; clear:both; margin-top:10px;}
	
	.input_picture {cursor:pointer;}
	.input_picture .upload_button {  
	     margin:0px 0px; padding:0px 7px;  
	     font:14px 'Arial Rounded MT Bold', 'Arial Black', Arial, Helvetica, sans-serif;  
	     text-align:center;
		 text-transform:uppercase;
	     background:#FFC400;  
	     color:#FFF;  
	     border:4px solid #FFC400;  
	     width:120px;  
	     cursor:pointer !important;
	     -moz-border-radius:10px; -webkit-border-radius:10px;
		float:left;
	}
	.input_picture input {cursor:pointer;}
	.input_picture .hover {background:#fff; color:#FFC400;}
	.form_element label {float:left; font:12px solid Arial; margin-right:10px;}
	.form_element .small {font-size:9px;}
	
	.form_element {clear:both; margin:10px;}
	
	
	
	</style>

    <h2>Update your Photo</h2>
	
	<div class="form_element">
		<label>Profile Picture<br /><span class="small">(4 MB maximum size)</span></label>
		<div class="input_picture"><div id="upload" class="upload_button ajax_upload">Upload Image</div><span id="status" class="ajax_upload_status"></span></div>
		<div style="clear:both;"></div>
	</div>

	
	<h2>Crop your Photo</h2>
	<p>Select the area of your photo that you would like to use as your thumbnail image.</p>
	<form id="cropform" action="post">
		 <input type="hidden" name="path" id="path" value="/media/profiles/<?php echo $id; ?>/" />
		 <input type="hidden" name="image" id="image" value="sized_<?php echo $image; ?>" />
	     <input type="hidden" name="x" id="x" value="" />
	     <input type="hidden" name="y" id="y" value="" />
	     <input type="hidden" name="x2" id="x2" value="" />
	     <input type="hidden" name="y2" id="y2" value="" />
	     <input type="hidden" name="w" id="w" value="" />
	     <input type="hidden" name="h" id="h" value="" />
	     <!-- You will probably want to store the id or path to the image you are altering -->
	</form>
	<div class="jcrop_image">
		<?php echo '<img class="jcrop" src="'.base_url().'/media/profiles/'.$id.'/sized_'.$image.'" />'; ?>
	</div>
	<div class="jcrop_preview_holder">
		<p>This is what your thumb will look like</p>
		<div style="width: 100px; height: 100px; overflow: hidden; margin-left: 5px; float:left; clear:right;">
			<img id="preview" src="<?php echo base_url(); ?>/media/profiles/<?php echo $id; ?>/sized_<?php echo $image; ?>" />
		</div>
		
		<a class="crop_button">Crop It!</a>
		<p class="error"></p>
		
	</div>
</div>

</body>
</html>