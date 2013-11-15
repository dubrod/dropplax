<?php
error_reporting(E_ALL);

class Dir_Section {
	
	function create_dir($post, $createBtn) {
		
		if(isset($createBtn)) {
		
		$dPath = $_SERVER['DOCUMENT_ROOT'] . "/galleries/" . $post['dir']."/";	
		$pPath = $_SERVER['DOCUMENT_ROOT'] . "/galleries/" . $post['dir']."/photos/";
		$tPath = $_SERVER['DOCUMENT_ROOT'] . "/galleries/" . $post['dir']."/tns/";
				
		mkdir($dPath, 0777);
		mkdir($pPath, 0777);
		mkdir($tPath, 0777);
		
		return "Folder created successfully.";
		
		}
	}
}

?>