By joining a cluster, you will be creating your own fund raising page on BEEx.org. 
<br><br>
In order to join, <?php echo anchor('cluster/joina/'.$item['cluster']['id'], 'click here'); ?> or paste the following link into your browser.
<br><br>
Cluster link:<br>
<?php echo anchor("cluster/joina/".$item['cluster']['id']); ?>
<br><br>
<?php if(isset($item['personal']['message'])) : ?>
A personal message from the originator of the cluster:<br><br>
<i>"<?php echo $item['personal']['message']; ?>"</i>
<br><br>
<?php endif; ?>

For more information about clusters, challenges and BEEx, check out our blog at <a href="http://learn.beex.org">learn.beex.org</a>.