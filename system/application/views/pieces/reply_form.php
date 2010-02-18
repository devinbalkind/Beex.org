<?php

$attributes = array(
				'class' => 'form',
				'id' => 'reply_note_form'.$note_id,
				'style' => 'display:none'
				  );

echo form_open_multipart('challenge/add_reply/'.$item_id.'/'.$note_id, $attributes);
?>
<h3>Reply to "<?php echo $note_title; ?>"</h3>
<table>
	<tr>
    	<td>Name: </td>
        <td><input name="name" /></td>
    </tr>
	<tr>
    	<td>E-mail: </td>
        <td><input name="email" /></td>
    </tr>
    <tr>
    	<td>Reply:</td>
        <td><textarea class="videoembed" name="reply"></textarea></td>
    </tr>
    <tr>
    	<td colspan=2><input type="submit" value="Reply" class="submit" /> <input type="button" class="cancel_button" value="Cancel"></td>
    </tr>
</table>
</form>
<?php


?>