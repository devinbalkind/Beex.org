<?php echo nl2br($item['message']); ?>
<br><br>
This note was posted to the cluster "<?php echo anchor('cluster/view/'.$item['cluster']['theid'], $item['cluster']['cluster_title']); ?>"
<br><br>
For more information about clusters, challenges and BEEx, check out our blog at <a href="http://learn.beex.org">learn.beex.org</a>.