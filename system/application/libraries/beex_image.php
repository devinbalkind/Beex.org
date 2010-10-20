<?php

class Beex_image extends Controller { 
	
	
	public $data;
	
	function Beex_image() {
		$CI =& get_instance();
		
		$this->data['th_width'] = 120;
		$this->data['th_height'] = 120;
		
		$CI->load->library('image_lib');
	}
	
	function jcrop_square($path, $image, $length, $x, $y, $target_length = 120) {

		$CI =& get_instance();
		
		$curr_image  = $path.$image;
		$info = getimagesize($curr_image);
		$curr_width = $info[0];
		$curr_height = $info[1]; 
		
		if($curr_width > $curr_height) {
			$ratio = $curr_height/$curr_width;
			$len = $curr_height;
			$y = 0;
			$x = .5*($curr_width - $curr_height);
		}
		elseif($curr_height > $curr_width) {
			$ratio = $curr_width/$curr_height;
			$len = $curr_width;
			$x = 0;
			$y = .5*($curr_height - $curr_width);
		}
		else {
			$len = $curr_height;
			$x = $y = 0;
		}
		
		if(!$newpath) {
			$newpath = $path.'tmp/';
		}
		
		if(!file_exists($newpath)) {
			mkdir($newpath);
		}
		
		$config['image_library'] = 'gd2';
		$config['source_image'] = $path.$image;
		$config['new_image'] = 'media/tmp/cropped_'.$image;
		$config['width'] = $len;
		$config['height'] = $len;
		$config['x_axis'] = $x;
		$config['y_axis'] = $y;
		$config['maintain_ratio'] = false;
	
		$CI->image_lib->initialize($config);
			
		if (!$CI->image_lib->crop())
		{
		    //echo $CI->image_lib->display_errors();
			echo 'you fucked up';
		}
		
		
		$config['image_library'] = 'gd2';
		$config['source_image'] = 'media/tmp/cropped_'.$image;
		$config['new_image'] = $newpath.'cropped'.$length.'_'.$image;
		$config['width'] = $length;
		$config['height'] = $length;
		$config['maintain_ratio'] = true;
		
		$CI->image_lib->initialize($config);
			
		if (!$CI->image_lib->resize())
		{
		    //echo $CI->image_lib->display_errors();
			echo 'YOU FUCKED UP';
		}
		else {
			return true;
		}
		
	}
	
	function crop_square($path, $image, $newpath = '', $length = 120) {

		$CI =& get_instance();
		
		$curr_image  = $path.$image;
		$info = getimagesize($path.$image);
		$curr_width = $info[0];
		$curr_height = $info[1]; 
		
		if($curr_width > $curr_height) {
			$ratio = $curr_height/$curr_width;
			$len = $curr_height;
			$y = 0;
			$x = .5*($curr_width - $curr_height);
		}
		elseif($curr_height > $curr_width) {
			$ratio = $curr_width/$curr_height;
			$len = $curr_width;
			$x = 0;
			$y = .5*($curr_height - $curr_width);
		}
		else {
			$len = $curr_height;
			$x = $y = 0;
		}
		
		if(!$newpath) {
			$newpath = $path.'tmp/';
		}
		
		if(!file_exists($newpath)) {
			//echo '<p>Making directory</p>';
			mkdir($newpath);
		}
		
		//echo "len = $len, x = $x, y = $y";
		
		$config['image_library'] = 'gd2';
		$config['source_image'] = $path.$image;
		$config['new_image'] = 'media/tmp/cropped_'.$image;
		$config['width'] = $len;
		$config['height'] = $len;
		$config['x_axis'] = $x;
		$config['y_axis'] = $y;
		$config['maintain_ratio'] = false;
	
		$CI->image_lib->initialize($config);
			
		if (!$CI->image_lib->crop())
		{
		    //echo $CI->image_lib->display_errors();
			echo 'you fucked up';
		}
		
		
		$config['image_library'] = 'gd2';
		$config['source_image'] = 'media/tmp/cropped_'.$image;
		$config['new_image'] = $newpath.'cropped'.$length.'_'.$image;
		$config['width'] = $length;
		$config['height'] = $length;
		$config['maintain_ratio'] = true;
		
		$CI->image_lib->initialize($config);
			
		if (!$CI->image_lib->resize())
		{
		    //echo $CI->image_lib->display_errors();
			echo 'YOU FUCKED UP';
		}
		else {
			return true;
		}
		
	}
	
	function process_media($path, $image, $newpath, $max_width = 310, $max_height = 222, $no_crop = false) {
		
		
		if(!file_exists($newpath)) {
			//echo '<p>Making directory - '.$newpath.'</p>';
			mkdir($newpath);
		}
		
		if(!$no_crop) {
			$this->crop_square($path, $image, $newpath);
			$this->crop_square($path, $image, $newpath, 148);
		}
		
		
		$curr_image  = $path.$image;
		$info = getimagesize($path.$image);
		$curr_width = $info[0];
		$curr_height = $info[1];
		
		$content_ratio = $max_width/$max_height;
		
		if($content_ratio >= $curr_width/$curr_height) {
			$width = round(($max_height * $curr_width)/$curr_height);
			$height = $max_height;
		}
		else {
			$height = round(($max_width * $curr_height)/$curr_width) ;
			$width = $max_width;
		}
				
		$CI =& get_instance();
		
		$config['image_library'] = 'GD2';
		$config['source_image'] = $path.$image;
		$config['new_image'] = $newpath.'sized_'.$image;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;
		//print_r($config);
		$CI->image_lib->initialize($config);
		
			
		if (@!$CI->image_lib->resize())
		{
		    echo $CI->image_lib->display_errors();
		}
		else {
			return true;
		}
	}
	
	function process_html_image($link, $newfilename) {
		$contents = file_get_contents($link);
		$newfile = fopen($newfilename, 'w');
		fwrite($newfile, $contents);
		fclose($newfile);
		
		
	}
	
	function process_already_there($type) {
		
		$CI =& get_instance();
		
		$items = $CI->MItems->get($type);
		
		foreach($items->result() as $item) {
			if($type == 'clusters') {
				$image = $item->cluster_image;
				$id = $item->id;
			}
			elseif($type == 'challenges') {
				$image = $item->challenge_image;
				$id = $item->id;
			}
			elseif($type == 'profiles') {
				$image = $item->profile_pic;
				$id = $item->user_id;
			}
			elseif($type == 'npos') {
				$image = $item->logo;
				$id = $item->id;
			}
			if($image) {
				echo $id.' - '.$image."<br>";
				if($this->process_media('media/'.$type.'/',$image, 'media/'.$type.'/'.$id.'/')) {
					copy('media/'.$type.'/'.$image, 'media/'.$type.'/'.$id.'/'.$image);
					echo "Media Processed<br>";
					echo "<img src='".base_url()."media/".$type.'/'.$id.'/'.$image."' />"; 
					echo "<img src='".base_url()."media/".$type.'/'.$id.'/cropped_'.$image."' />"; 
					echo "<img src='".base_url()."media/".$type.'/'.$id.'/sized_'.$image."' />";
					echo "<br>";
				}
			}
		}
		
	}
	
	function do_upload($files, $filename, $uploadpath = './media/', &$error = '')
	{
		//$uploadpath = './media/6';
		if(!file_exists($uploadpath)) {
			//echo $uploadpath;
			if(!mkdir($uploadpath)) {
 
			}
		}

		$config['upload_path'] = $uploadpath; 
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= 4000; 


		$CI =& get_instance();
		$CI->load->library('upload', $config);

		if ( ! $CI->upload->do_upload($filename))
		{
			$error = array('error' => $CI->upload->display_errors());
			//print_r($error);
			return '';
		}
		else
		{
			$data = $CI->upload->data('file_name');
			$this->process_thumb($uploadpath, $data['file_name']);
			return $data['file_name'];
		}
	}
}
?>