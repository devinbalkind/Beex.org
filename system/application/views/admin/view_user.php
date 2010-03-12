<?php

$this->load->view('framework/header', $header);
?>
	
<?php $this->load->view('admin/menu'); ?>

<h2 style="text-transform:capitalize;">Challenges for <?php //echo $user->firstname.' '.$user->lastname; ?></h2>

<?php 

echo $this->MAdmin->generateTable('challenges', $challenges, $sort, @$id);

?>

<h2 style="text-transform:capitalize;">Clusters for <?php //echo $user->firstname.' '.$user->lastname; ?></h2>

<?php 

echo $this->MAdmin->generateTable('clusters', $clusters, $sort, @$id);

?>

<script>

jQuery(document).ready(function(){
	
	jQuery(".featuredcheck").click(function() {
			
			var id = jQuery(this).attr('id').substr(14);
			var feat = jQuery(this).attr('id').substr(13, 1);
			
			var oppfeat = (feat == 1) ? 0 : 1;
			
			jQuery.ajax({
				
				url: base_url + "adminajax/makefeatured/" + id + "/" + feat + "/<?php echo $table; ?>",
				success: function(html) {
					
					jQuery('#featuredcheck'+feat+id).html(html);
					jQuery('#featuredcheck'+feat+id).attr('id', "featuredcheck" + oppfeat + id);
				}
				
			});
			
	
	});
	
	jQuery(".approvebutton").click(function() {
			
			var id = jQuery(this).attr('id').substr(9);
			var feat = jQuery(this).attr('id').substr(8, 1);
			
			var oppfeat = (feat == 1) ? 0 : 1;
			
			jQuery.ajax({
				
				url: base_url + "adminajax/makeapproved/" + id + "/" + feat,
				success: function(html) {
					
					jQuery('#approved'+feat+id).html(html);
					jQuery('#approved'+feat+id).attr('id', "approved" + oppfeat + id);
				}
				
			});
			
	
	});
	
	jQuery(".deletebutton").click(function() {
		
		var id = jQuery(this).attr('id').substr(6);
		
		var table = '<?php echo $table; ?>';
		
		if( confirm('Are you sure you want to delete this?'))
		{
			jQuery.ajax({
			
				url: base_url + "adminajax/delete/" + table + '/' + id,
				success: function(html) {
					$(".row-"+id).fadeOut('slow', function(id) {
						jQuery(".row-"+id).remove();
						
					});			
				}
			
			});
		}
		
	});
	
	

});
</script>

<?php

$this->load->view('framework/footer');
?>