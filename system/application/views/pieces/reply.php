<div class="reply" id="reply_<?php echo $reply->id; ?>">
	
	<p><span class='date'><?php echo date('m-d-Y H:i:s', strtotime($reply->created)); ?></span><br>
	<?php if(isset($reply->name)) : ?>
	<b><?php echo (isset($reply->email)) ? '<a href="mailto:'.$reply->email.'">'.$reply->name."</a>" : $reply->name; ?></b> 
	<?php else : ?>
	Anonymous
	<?php endif; ?>
	 says: </p>
	<p><?php echo $reply->reply; ?></p>
	
</div>