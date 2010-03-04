<?php

$this->load->view('framework/header', $header);

?>

<h2><?php echo $table; ?></h2>

<?php echo $this->MAdmin->generateTable($table, $list, $sort); ?>

<script>

jQuery(document).ready(function(){
	
	jQuery(".featuredcheck").click(function() {
			
			var id = jQuery(this).attr('id').substr(14);
			var feat = jQuery(this).attr('id').substr(13, 1);
			
			var oppfeat = (feat == 1) ? 0 : 1;
			
			jQuery.ajax({
				
				url: base_url + "adminajax/makefeatured/" + id + "/" + feat,
				success: function(html) {
					
					jQuery('#featuredcheck'+feat+id).html(html);
					jQuery('#featuredcheck'+feat+id).attr('id', "featuredcheck" + oppfeat + id);
				}
				
			});
			
	
	});
	
	jQuery(".deletebutton").click(function() {
		
		var id = jQuery(this).attr('id').substr(6);
		
		var table = '<?php echo $table; ?>';
		
		jQuery.ajax({
			
			url: base_url + "adminajax/delete/" + table + '/' + id,
			success: function(html) {
				
				jQuery(this).parents('table').remove();
					
				
			}
			
		});
		
	});

});
</script>

<?php

$this->load->view('framework/footer');
?>