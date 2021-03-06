// JavaScript Document

var base_url = "http://localhost:8888/beex/index.php/";
//var base_url = "http://www.beex.org/index.php/";

jQuery(document).ready(function(){
	
	$(".datepicker").datepicker({minDate:0});
	
	jQuery("#new_note").click(function() {	
		jQuery("#edit_note_form").show();
	});
	
	// Featured browser buttons 
	/*
	jQuery(".featured_buttons .button").click(function() {	
		jQuery(".featured_buttons div").removeClass('on');
		var id = jQuery(this).attr('id').substr(6);
		jQuery(".featured_buttons #button" + id).addClass('on');
	});
	*/
	
	jQuery(".featured_buttons .button").click(function() {
		
		var id = jQuery(this).attr('id').substr(6);

		jQuery(".featured_buttons div").removeClass('on');
		jQuery(".featured_buttons #button" + id).addClass('on');
		

		jQuery(".featuredbox .InfoDisplay").fadeTo('normal', 0, function() {
			jQuery(".featuredbox .InfoDisplay").css('display', 'none');
			jQuery("#Featured" + id).css('display', 'block');
			jQuery("#Featured" + id).fadeTo('normal', 1);
		});
		
	});
	
	/* Proof and Note Javascript */
	
	jQuery(".edit_proof_button").click(function() {
	
		var id = jQuery(this).attr('id').substr(10);
		jQuery("#edit_proof_form"+id).show();
	
	});
	
	jQuery(".edit_note_button").click(function() {
	
		var id = jQuery(this).attr('id').substr(9);
		jQuery("#edit_note_form"+id).show();
		
	});
	
	jQuery(".reply_note_button").click(function() {
	
		var id = jQuery(this).attr('id').substr(10);
		jQuery("#reply_note_form"+id).show();
		
	});
	
	jQuery(".delete_note_button").click(function() {
		
		var answer = confirm("Are you sure you want to delete this note?");
		if (answer) {
			var id = jQuery(this).attr('id').substr(11);
			jQuery.ajax({
				
				url: base_url + "ajax/delete_note/" + id,
				success: function() {
					jQuery('#note_'+id).remove();
				}
				
			});
		}
		
	});
	
	jQuery(".delete_reply_button").click(function() {
		
		var answer = confirm("Are you sure you want to delete this reply?");
		if (answer) {
			var id = jQuery(this).attr('id').substr(11);
			jQuery.ajax({
				
				url: base_url + "ajax/delete_reply/" + id,
				success: function() {
					jQuery('#reply'+id).remove();
				}
				
			});
		}
		
	});
	
	jQuery(".cancel_button").click(function() {
	
		jQuery(this).closest('form').hide();
		
	});
	
	
	jQuery("#blogprooftoggle").click(function() {
		
		var toggle = 0;
		
		if($("#Notes").css('display') == 'none') {
			toggle = 1;
		}
		
		if(toggle == 1) {
			$("#blogprooftitle").html('The Blog');
			$("#Notes").show();
			$("#Proof").hide();
		}
		else {
			$("#blogprooftitle").html("The Proof");
			$("#Proof").show();
			$("#Notes").hide();
		}	
		 
		
	});
	 

	
	// Footer business link buttons and learn more buttons
	/*
	jQuery(".javapopuplink a").click(function() {
											  
											 
		var url = 'http://www.beex.org/pieces/auxpage.php?id='+jQuery(this).attr('id').substring(6);
		
		jQuery(this).popupWindow({
			windowURL : url,
			width: 500,
			heigth:800
		});
		
	});
	*/
	jQuery(".javapopuplink a").popupWindow({
			width: 600,
			height:800,
			left:100,
			top:100,
			scrollbars:1,
			windowName:'auxpage'

		
	});
	
		
});
