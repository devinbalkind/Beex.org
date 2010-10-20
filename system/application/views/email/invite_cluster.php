You’ve been invited by <?php echo anchor('user/view/'.$item['admin']['id'],$item['admin']['name']); ?> to join the fundraising cluster entitled <?php echo anchor('cluster/view/'.$item['cluster']['id'],$item['cluster']['name']); ?> which is raising money for <?php echo anchor('npo/view/'.$item['npo']['id'],$item['npo']['name']); ?>.
<br><br>
<?php if(isset($item['cluster']['password'])) : ?>
This cluster is private and is protected with the following code. Enter it when you join the cluster.
<br><br>
cluster code: <?php echo $item['cluster']['password']; ?>
<br><br>
<?php endif; ?>
When you join the cluster, you’ll be asked to ‘fill in the blanks’ in your own fundraising challenge page.  Some fields have already been filled out by the cluster’s administrator.  Please fill out the rest.
<br><br>
<?php echo anchor('cluster/joina/'.$item['cluster']['id'], 'Click here to join the cluster'); ?>.
<br><br>
For more information about clusters, challenges and BEEx, check out our blog at <a href="http://learn.beex.org">learn.beex.org</a>.