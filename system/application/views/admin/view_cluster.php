<?php

$this->load->view('framework/header', $header);

$this->load->view('admin/menu');

?>

<h2><?php echo $table; ?> for <?php echo $cluster->cluster_title; ?></h2>

<p>Number of Challenges: <?php echo $nochallenges; ?></p>
<p>Creator: <?php echo $cluster->firstname.' '.$cluster->lastname; ?></p>
<p>Total Raised: $<?php echo number_format($cluster->raised); ?></p>
<?php 

echo $this->MAdmin->generateTable($table, $list, $sort, $id);

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