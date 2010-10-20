You've been invited to be apart of the team raising money by participating in the <?php echo anchor('challenge/view/'.$item['challenge']['id'],$item['challenge']['title']); ?> Challenge on BEEx.org.
<br><br>
Challenge link:<br>
<?php echo anchor("challenge/view/".$item['challenge']['id']); ?>
<br><br>
<?php if(isset($item['personal']['password'])) : ?>
You have automatically been generated an account on BEEx.org. To activate it, log in by clicking <?php echo anchor('user/login/', 'this link'); ?>. You can use this email address and the password below:
<br><br>
password: <?php echo $item['password']; ?>
<br><br>
If you cannot click the link above, copy and paste the following into your web browser to login:
<br><br>
http://www.beex.org/index.php/user/login
<?php endif; ?>
<br><br>
For more information about clusters, challenges and BEEx, check out our blog at <a href="http://learn.beex.org">learn.beex.org</a>.