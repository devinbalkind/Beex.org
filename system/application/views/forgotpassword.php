<?php

$this->load->view('framework/header', $header);

if($message) {
    echo "<p class='message'>".$message."<span class='val_errors'>";
    echo validation_errors();
    echo "</span></p>";
}

?>

<div class="form" style="width:600px; margin:0px auto;">
<h2>Forgot your password?</h2>

<?php echo form_open('user/forgot'); ?>

    <p>Please enter your email address. We will send you an email with a link to reset your password.</p>
	<div class="form_element">
		<label>Your Email</label>
		<div class="input_text"><input type="text" name="email" /></div>
    </div>
	<div class="form_element">
		<div style="text-align:center;">
			<input type="image" value="Submit" class="rollover" src="<?php echo base_url(); ?>images/buttons/reg-form-submit-off.png" />
		</div>
	</div>
 </form>
</div>
<?php

$this->load->view('framework/footer');

?>