<?php

	//create dir
	include_once('php/create-dir.php');
	$Dir_Section = new Dir_Section;
	$dir_success = $Dir_Section->create_dir($_POST, $_POST['createBtn']);
	
	//photo upload
	include_once('php/add-photo.php');
	$Photo_Section = new Photo_Section;
	$filesuccess = $Photo_Section->upload_file($_POST, $_POST['uploadphoto']);
	
	//GET FOLDERS
	$dir    = 'galleries/';
	$folders = scandir($dir);

?>
<div id="dash">
<h1>Dashboard</h1>

	<div class="dash-row">
		<h2>Galleries</h2>
		
		<div id="quickDir">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=<?php echo ADMIN_SLUG; ?>">
			<input name="dir" type="text" size="20" />
			<button id="createBtn" name="createBtn">Create Directory</button>
			<?php echo $dir_success; ?>
			</form>
		</div>		
	
		<div id="quickUpload">
			<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=<?php echo ADMIN_SLUG; ?>">
			<input name="uF" type="file" id="uF" size="20" />
			<select name="category">
			<?php
			//ECHO FOLDERS
			foreach($folders as $f){
				if(!($f == "readme.md" || $f == ".htaccess" || $f == "." || $f == "..")){
					echo "<option value=\"$f\">$f</option>";
				}
			}
			?>
			</select>
			<button id="uploadphoto" name="uploadphoto">UPLOAD PHOTO</button>
			<?php echo $filesuccess; ?>
			</form>
		</div> 
		
		
		
		<script>
        $(document).ready(function(){
        	site_url = "<?php echo BLOG_URL; ?>";
        	
			$("#fileList dt").click(function(){ $("#thumbs").html(""); childPhotos(this.id); });	
        	
        	        
        }); //eof .ready
        
      		
		// GET CHILDREN
		function childPhotos(parentFold){
			//console.log(parentFold);

			childFolder = site_url+"galleries/"+parentFold+"/photos/";
			$("#thumbs").append("<h3>"+parentFold+"</h3>");
			
			$.ajax({
	            url: childFolder,
	            success: function (files) {
	            //console.log(files);
	            
	                $(files).find("a:contains(.jpg)").each(function () {
	                	var filename = this.href.split('/').pop();
	                    $("#thumbs").append("<div class=\"tn\"><img src=\""+site_url+"galleries/"+parentFold+"/tns/"+filename+"\"><br><button class=\"deleteBtn\" data-info='{\"folder\":\"" + parentFold + "\",\"name\":\"" + filename + "\"}' ></button></div>");
	                });
	                
	                //MUST INITIALIZE THE CALL HERE
	                $(".deleteBtn").click(function(){
	                	foldername = $(this).data('info').folder;
						photoname = $(this).data('info').name;
						console.log(photoname);
						
						deletePhoto(foldername, photoname);
	                	 
	                });
	            }
	        });
			
		} // EOF GET CHILDREN
		
		
		function deletePhoto(foldername, photoname){
			
			//console.log(pid + " made it to function"); // make sure our id makes it this far
			$.ajax({
			type: "POST",
			url: site_url+"templates/r3_flat/php/delete-photo.php",
			data: { folder: foldername, name: photoname }
			})
			.done(function( msg ) {
				alert(msg);
				//no message bc we did a fadeOut
				//var msg would show any errors from our php file
			});
			 
		 };
		
			
		</script>
		
		<div id="fileList">
			<?php
			
			//ECHO FOLDERS
			foreach($folders as $f){
				if(!($f == "readme.md" || $f == ".htaccess" || $f == "." || $f == "..")){
					echo "<dt id=\"$f\"><span class=\"dp-icon dp-icon-large dp-icon-grid\"></span> $f</dt>";
				}
			}
			?>
			
		</div>
		
		<div id="thumbs"></div>	
		
	</div><!-- eof dash-row -->


</div> <!-- eof dash -->