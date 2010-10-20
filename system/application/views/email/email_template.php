<html>
<head>
</head>

<body>
	
	<table border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td colspan="3">
					<img src="http://www.beex.org/images/email/header2.png" style="margin: 0px; padding: 0px;" />
				</td>
			</tr>
			<tr>
				<td bgcolor="#ffc400" width="19">&nbsp;</td>
				<td width="617">
					<div style="padding: 20px 45px 0px; color:#5C6771;">
						<h2 style="font: 20px 'Arial Rounded MT Bold','Arial Black',Arial,sans-serif; text-transform: uppercase; padding: 5px 0px; margin: 0px 0px 20px; color:#FFC400;"><?php echo $title; ?></h2>
						<p style="font: 14px Verdana;"><?php echo $message; ?></p>
						<p style="font: 14px Verdana;">live free,<br>folks@beex.org</p>
						<?php if(isset($ps)) : ?>
							<p style="font:12px Verdana; padding:10px;"><?php echo $ps; ?></p>
						<?php endif; ?>
					</div>
				</td>
				<td bgcolor="#ffc400" width="19">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3">
					<img src="http://www.beex.org/images/email/footer.png" style="margin: 0px; padding: 0px;" />
				</td>
			</tr>
		</tbody>
	</table>
	
</body>
</html>