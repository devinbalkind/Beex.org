	
		<div class='row'>
		
			<img class='watermark' src='<?php echo base_url(); ?>images/glyphs/join-small.png'>
			<?php echo $this->beex->displayProfileImage($link_id, $image_name, $folder); ?>
			<div class="float_left copy">
				<?php echo anchor('challenge/view/'.$item->id, $item->challenge_title, "class='activity orange bold' style='display:inline-block;'"); ?>
				<?php if($this->session->userdata('user_id') == $item->user_id) echo anchor('challenge/editor/'.$item->id.'/edit', "&lt;edit&gt;", 'style="font-size:10px;"')?>
				<p class="activity"><?php echo anchor('user/view/'.$profile->user_id, $profile->first_name.' '.$profile->last_name); ?> will <?php echo anchor('challenge/view/'.$item->id, $item->challenge_declaration); ?> if $<?php echo $item->challenge_goal; ?> is raised for <?php echo anchor('npo/view/'.$item->challenge_npo, $item->name); ?></p>
				<p class='activity raised_goal'>Raised: $<?php echo number_format($this->MItems->amountRaised($item->item_id), 2); ?> | Goal: $<?php echo number_format($item->challenge_goal); ?></p>	
				<p class="date"><?php echo date('m.d.Y', strtotime($item->created)); ?> at <?php echo date('H:i', strtotime($item->created)) ; ?></p>					
				<div style='clear:both;'></div>
			</div>
			<div style='clear:both;'></div>
		</div>
	