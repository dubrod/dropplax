<?php
error_reporting(E_ALL);

session_start();

if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
	exit_status('Error! Wrong HTTP method!');
}

if (!isset($_SESSION['user'])) {
    exit(json_encode(array('status' => "Unauthorized access")));
}

if (isset($_POST['liteUploader_id']) && $_POST['liteUploader_id'] == 'postfiles')
{
	foreach ($_FILES['postfiles']['error'] as $key => $error)
	{
	    if ($error == UPLOAD_ERR_OK)
		{
	        move_uploaded_file( $_FILES['postfiles']['tmp_name'][$key], '../../posts/' . $_FILES['postfiles']['name'][$key]);
	    }
	}

	echo 'File Saved.';
	
	
	//run new front cache
	
	/*-----------------------------------------------------------------------------------*/
	/* Get All Posts Function
	/*-----------------------------------------------------------------------------------*/
	
	
	include('markdown.php');
	
	function get_all_posts($options = array()) {
	    global $dropplets;
	
	    if($handle = opendir($_SERVER['DOCUMENT_ROOT'] . "/posts/")) {
	
	        $files = array();
	        $filetimes = array();
	
	        while (false !== ($entry = readdir($handle))) {
	            if(substr(strrchr($entry,'.'),1)==ltrim(".md", '.')) {
	
	                // Define the post file.
	                $fcontents = file($_SERVER['DOCUMENT_ROOT'] . "/posts/".$entry);
	
	                // Define the post title.
	                $post_title = Markdown($fcontents[0]);
	
	                // Define the post author.
	                $post_author = str_replace(array("\n", '-'), '', $fcontents[1]);
	
	                // Define the post author Twitter account.
	                $post_author_twitter = str_replace(array("\n", '- '), '', $fcontents[2]);
	
	                // Define the published date.
	                $post_date = str_replace('-', '', $fcontents[3]);
	
	                // Define the post category.
	                $post_category = str_replace(array("\n", '-'), '', $fcontents[4]);
	
	                // Early return if we only want posts from a certain category
	                if($options["category"] && $options["category"] != trim(strtolower($post_category))) {
	                    continue;
	                }
	
	                // Define the post status.
	                $post_status = str_replace(array("\n", '- '), '', $fcontents[5]);
	
	                // Define the post intro.
	                $post_intro = Markdown($fcontents[7]);
	
	                // Define the post content
	                $post_content = Markdown(join('', array_slice($fcontents, 6, $fcontents.length -1)));
	
	                // Pull everything together for the loop.
	                $files[] = array('fname' => $entry, 'post_title' => $post_title, 'post_author' => $post_author, 'post_author_twitter' => $post_author_twitter, 'post_date' => $post_date, 'post_category' => $post_category, 'post_status' => $post_status, 'post_intro' => $post_intro, 'post_content' => $post_content);
	                $post_dates[] = $post_date;
	                $post_titles[] = $post_title;
	                $post_authors[] = $post_author;
	                $post_authors_twitter[] = $post_author_twitter;
	                $post_categories[] = $post_category;
	                $post_statuses[] = $post_status;
	                $post_intros[] = $post_intro;
	                $post_contents[] = $post_content;
	            }
	        }
	        array_multisort($post_dates, SORT_DESC, $files);
	        return $files;
	
	    } else {
	        return false;
	    }
	}
	
	/*-----------------------------------------------------------------------------------*/
	
	$cache_posts = fopen($_SERVER['DOCUMENT_ROOT'] . "/cache/front.txt", "w");
	
	$all_posts = get_all_posts();
	    //echo "<pre>";
	    //print_r($all_posts);
        $i=0;
        
        foreach($all_posts as $post){ 
          if($i<3){
        	if($post["post_status"] == "published"){
				$post_link = $post["fname"];
				$post_link = str_replace(".md", "", $post_link);
				
				$intro_p = $post["post_intro"];
				$intro_p = str_replace("<ul>", "", $intro_p);
				$intro_p = str_replace("</ul>", "", $intro_p);
				$intro_p = str_replace("<li>", "", $intro_p);
				$intro_p = str_replace("</li>", "", $intro_p);
				
		    		$intro_t = str_replace("<h1>", "", $post["post_title"]);
				$intro_t = str_replace("</h1>", "", $intro_t);
				
		    $cell = "<div class=\"post-cell\"><h4><a href=\"$post_link\">$intro_t</a></h4><div class=\"post-date\">".$post["post_date"]."</div><p>$intro_p</p></div>";

		    fwrite($cache_posts, $cell);
		       
	        $i++;
	        } // end if published
	      } else { break; } 
        } // end foreach
        
    fclose($cache_posts); 
	
}

?>
