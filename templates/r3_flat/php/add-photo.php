<?php

error_reporting(E_ALL);

class Photo_Section {
	
	function upload_file($post, $uploadphoto) {
		
		if(isset($uploadphoto)) {
		
		//VARIABLES
		$uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/galleries/" . $post['category'].'/photos/';
		$thumbPath = $_SERVER['DOCUMENT_ROOT'] . "/galleries/" . $post['category'].'/tns/' . $_FILES['uF']['name'];
		//return $uploadPath;
		chmod($uploadPath, 0755);
		$uF = $uploadPath . $_FILES['uF']['name']; 
		$tn = $_FILES['uF']['tmp_name'];
		
		//file extension
		$ext = substr($uF, -3);
		
		if($ext == "jpg"){
		
			if(filesize($_FILES['uF']['tmp_name']) > 1000000){
				
				return '<p class="defaultClassError">Your Filesize is too big.</p>';
				
			} else {
			
										
				if(is_dir($uploadPath)) {
					//echo "is a dir";
				} else {
					mkdir($uploadPath, 0777);
					//make the dir
				}
				
				if(file_exists($uploadPath) && is_writable($uploadPath)) {
					
		
					if(move_uploaded_file($tn, $uF)) {
					
						//make thumb
						$percent = 0.25;
						list($width, $height) = getimagesize($uF);
						$new_width = $width * $percent;
						$new_height = $height * $percent;
						
						// Resample
						$image_p = imagecreatetruecolor($new_width, $new_height);
						$image = imagecreatefromjpeg($uF);
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						imagejpeg($image_p, $thumbPath);
										
						return "File uploaded successfully.";
						
					} // eof if moved
					
				
				} else {
				
				    echo 'Upload directory is not writable, or does not exist.';
				    
				}
	
			} // eof filesize
			
		} else{
			
			return '<p class="defaultClassError">Your File is NOT a ".jpg" .</p>';
			
		} // eof extension check	
		
		} //eof if uploadphoto
		
	} //eof file_upload
	
} // eof class Photo_Section

?>	