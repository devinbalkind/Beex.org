<?php

$this->load->view('framework/header', $header);

if($message) {
    echo "<p class='message'>".$message."<span class='val_errors'>";
    echo validation_errors();
    echo "</span></p>";
}

?>

<h2>Reset Your Password?</h2>

<?php echo form_open('user/resetpassword/'.$reset_id.'/'.$code); ?>


<table border=0 cellpadding=0 cellspacing=0 style="width:400px;">
	<tr>
     <th colspan="2">You can reset your password from here. Just pick a new password and you'll be all set.</th>
    </tr>
    <tr>
     <td>Your New Password</td>
     <td><input type="password" name="password" /></td>
    </tr>
    <tr>
     <td>Confirm New Password</td>
     <td><input type="password" name="password_conf" /></td>
    </tr>
    <tr>
     <td colspan="2"><input type="submit" value="Reset" style="width:auto" /></td>
    </tr>
</table>
</form>

<?php

$this->load->view('framework/footer');

?>