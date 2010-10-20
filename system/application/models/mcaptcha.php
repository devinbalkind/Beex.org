<?php
class MCaptcha extends Model
{
  private $vals = array();

  public function __construct($configVal = array())
  {
    parent::Model();

	$baseUrl  = base_url();
	$basePath = './';
	
	$captchaImagePath = 'tmp/captcha/';
	$captchaImageUrl  = 'tmp/captcha/';
	$captchaFontPath  = base_url().'system/fonts/textb.ttf';

    $this->load->plugin('captcha');

    $this->vals = array(
                 'word'          => '',
                 'word_length'   => 6,
                 'img_path'      => $basePath
                                 .  $captchaImagePath,
                 'img_url'       => $baseUrl
                                 .  $captchaImageUrl,
                 'font_path'     => $captchaFontPath,
				 'font_size'	 => '20',
                 'img_width'     => '120',
                 'img_height'    => '30',
                 'expiration'    => 3600
               );
  }

  /**
   * initializes the variables
   *
   * @author    Mohammad Jahedur Rahman
   * @access    public
   * @param     array     config
   */
  public function initialize ($configVal = array())
  {
    $this->vals = $configVal;
  } //end function initialize

  //---------------------------------------------------------------

  /**
   * generate the captcha
   *
   * @author     Mohammad Jahedur Rahman
   * @access     public
   * @return     array
   */
  public function generateCaptcha ()
  {
    $cap = create_captcha($this->vals);
    return $cap;
  } //end function generateCaptcha
}
?>