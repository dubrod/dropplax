<?php

session_start();

/*-----------------------------------------------------------------------------------*/
/* If There's a Config Exists, Continue
/*-----------------------------------------------------------------------------------*/

if (file_exists('./config.php')) {

/*-----------------------------------------------------------------------------------*/
/* Get Settings & Functions
/*-----------------------------------------------------------------------------------*/

include('./dropplets/settings.php');
include('./dropplets/functions.php');

/*-----------------------------------------------------------------------------------*/
/* Reading File Names
/*-----------------------------------------------------------------------------------*/

$category = NULL;
if (empty($_GET['filename'])) {
    $filename = NULL;
}  else {
    
    //Filename can be /some/blog/post-filename.md We should get the last part only
    $filename = explode('/',$_GET['filename']);

    // File name could be the name of a category
    if($filename[count($filename) - 2] == "category") {
        $category = $filename[count($filename) - 1];
        $filename = null;
    } else {
      
        // Individual Post
        $filename = POSTS_DIR . $filename[count($filename) - 1] . FILE_EXT;
    }
}

/*-----------------------------------------------------------------------------------*/
/* The Home Page 
/*-----------------------------------------------------------------------------------*/

if ($filename==NULL) {

        ob_start();

        // Get the index file.
		
		include_once $index_file;
		
		//Now that we have the whole index page generated, put it in cache folder
        if ($index_cache != 'off') {
            $fp = fopen($cachefile, 'w');
            fwrite($fp, ob_get_contents());
            fclose($fp);
        }
        
}

/*-----------------------------------------------------------------------------------*/
/* Single Post Pages
/*-----------------------------------------------------------------------------------*/

else {
    ob_start();

    // Define the post file.
    $fcontents = file($filename);
    $slug_array = explode("/", $filename);
    $slug_len = count($slug_array);

    // This was hardcoded array index, it should always return the last index.
    $slug = str_replace(array(FILE_EXT), '', $slug_array[$slug_len - 1]);

    // Define the cached file.
    $cachefile = CACHE_DIR.$slug.'.html';

    // If there's no file for the selected permalink, grab the 404 page template.
    if (!file_exists($filename)) {

        //Change the cache file to 404 page.
        $cachefile = CACHE_DIR.'404.html';

        // Define the site title.
        $page_title = $error_title;

        // Get the 404 page template.
        include $not_found_file;

        // Get the contents.
        $content = ob_get_contents();

        // Flush the buffer so that we dont get the page 2x times.
        ob_end_clean();

        // Start new buffer.
        ob_start();

	      // Get the index template file.
        include_once $index_file;

        // Cache the post on if caching is turned on.
        if ($post_cache != 'off')
        {
            $fp = fopen($cachefile, 'w');
            fwrite($fp, ob_get_contents());
            fclose($fp);
        }

    // If there is a cached file for the selected permalink, display the cached post.
    } else if (file_exists($cachefile)) {

        // Define site title
        $page_title = str_replace('# ', '', $fcontents[0]);

        // Get the cached post.
        include $cachefile;

        exit;

    // If there is a file for the selected permalink, display and cache the post.
    } else {

        // Get the post title.
        $post_title = Markdown($fcontents[0]);
        $post_title = str_replace(array("\n",'<h1>','</h1>'), '', $post_title);

        // Get the post author.
        $post_author = str_replace(array("\n", '-'), '', $fcontents[1]);

        // Get the post author Twitter ID.
        //$post_author_twitter = str_replace(array("\n", '- '), '', $fcontents[2]);
        $post_author_twitter = $blog_twitter;

        // Get the published date.
        $published_iso_date = str_replace('-', '', $fcontents[3]);

        // Generate the published date.
        $published_date = date_format(date_create($published_iso_date), $date_format);

        // Get the post category.
        $post_category = str_replace(array("\n", '-'), '', $fcontents[4]);
        
        // Get the post status.
        $post_status = str_replace(array("\n", '- '), '', $fcontents[5]);
        
        // r3+ Get the post gallery.
        $post_gallery = str_replace(array("\n", '- '), '', $fcontents[6]);
        
        // r3+ Get the post intro.
        $post_intro = str_replace(array("\n", '- '), '', $fcontents[7]);
        
        // Get the post category link.
        $post_category_link = $blog_url.'category/'.urlencode(trim(strtolower($post_category)));

        // Get the post link.
        $post_link = $blog_url.str_replace(array(FILE_EXT, POSTS_DIR), '', $filename);

        // Get the post image url.
        $image = str_replace(array(FILE_EXT), '', $filename).'.jpg';

        if (file_exists($image)) {
            $post_image = $blog_url.str_replace(array(FILE_EXT, './'), '', $filename).'.jpg';
        } else {
            //$post_image = get_twitter_profile_img($post_author_twitter);
            $post_image = "/cache/dropplets.jpg";
        }
        
        // Get the post content
        $file_array = file($filename);
        
        unset($file_array[0]);
        unset($file_array[1]);
        unset($file_array[2]);
        unset($file_array[3]);
        unset($file_array[4]);
        unset($file_array[5]);
        unset($file_array[6]);
        
        $post_content = Markdown(implode("", $file_array));
                
        // Get the site title.
        $page_title = str_replace('# ', '', $fcontents[0]);

        // Generate the page description and author meta.
        $get_page_meta[] = '<meta name="description" content="' . $post_intro . '">';
        $get_page_meta[] = '<meta name="author" content="' . $post_author . '">';

        // Generate the Twitter card.
        $get_page_meta[] = '<meta name="twitter:card" content="summary">';
        $get_page_meta[] = '<meta name="twitter:site" content="' . $blog_title . '">';
        $get_page_meta[] = '<meta name="twitter:title" content="' . $page_title . '">';
        $get_page_meta[] = '<meta name="twitter:description" content="' . $post_intro  . '">';
        $get_page_meta[] = '<meta name="twitter:creator" content="' . $post_author_twitter . '">';
        $get_page_meta[] = '<meta name="twitter:image:src" content="' . $post_image . '">';
        $get_page_meta[] = '<meta name="twitter:domain" content="' . $post_link . '">';

        // Get the Open Graph tags.
        $get_page_meta[] = '<meta property="og:type" content="article">';
        $get_page_meta[] = '<meta property="og:title" content="' . $page_title . '">';
        $get_page_meta[] = '<meta property="og:site_name" content="' . $blog_title . '">';
        $get_page_meta[] = '<meta property="og:url" content="' . $post_link . '">';
        $get_page_meta[] = '<meta property="og:description" content="' . $post_intro . '">';
        $get_page_meta[] = '<meta property="og:image" content="' . $post_image . '">';

        // Generate all page meta.
        $page_meta = implode("\n", $get_page_meta);

        // Generate the post.
        $post = Markdown(join('', $fcontents));

        // Get the post template file.
        include $post_file;

        $content = ob_get_contents();
        ob_end_clean();
        ob_start();

        // Get the index template file.
        include_once $index_file;

        // Cache the post on if caching is turned on.
        if ($post_cache != 'off')
        {
            $fp = fopen($cachefile, 'w');
            fwrite($fp, ob_get_contents());
            fclose($fp);
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* Run Setup if No Config
/*-----------------------------------------------------------------------------------*/

} else {
    // Get the components of the current url.
    $protocol = @( $_SERVER["HTTPS"] != 'on') ? 'http://' : 'https://';
    $domain = $_SERVER["SERVER_NAME"];
    $port = $_SERVER["SERVER_PORT"];
    $path = $_SERVER["REQUEST_URI"];

    // Check if running on alternate port.
    /*
    if ($protocol === "https://") {
        if ($port === 443)
            $url = $protocol . $domain;
        else
            $url = $protocol . $domain . ":" . $port;
    } elseif ($protocol === "http://") {
        if ($port === 80)
            $url = $protocol . $domain;
        else
            $url = $protocol . $domain . ":" . $port;
    }
	*/
    $url = $protocol . $domain . $path;
    
    // Check if the install directory is writable.
    $is_writable = (TRUE == is_writable(dirname(__FILE__) . '/'));
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title>Let's Get Started</title>
            <link rel="stylesheet" href="./dropplets/style/style.css" />
            <link href='http://fonts.googleapis.com/css?family=Lato:100,300' rel='stylesheet' type='text/css'>
            <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400' rel='stylesheet' type='text/css'>
            <link rel="shortcut icon" href="./dropplets/style/images/favicon.png">
        </head>

        <body class="dp-install">
            <form method="POST" action="./dropplets/save.php">
                <a class="dp-icon-dropplets" href="http://dropplets.com" target="_blank"></a>
                
                <h2>Install Dropplets</h2>
                <p>Welcome to an easier way to blog.</p>
                
                <input type="text" name="admin-slug" id="admin-slug" required placeholder="Admin Slug"> <!- r3+ -->
                <input type="password" name="password" id="password" required placeholder="Choose Your Password">
                <input type="password" name="password-confirmation" id="password-confirmation" required placeholder="Confirm Your Password" onblur="confirmPass()">

                <input hidden type="text" name="blog_email" id="blog_email" value="wayne@revitalagency.com">
                <input hidden type="text" name="blog_twitter" id="blog_twitter" value="dubrod">
                <input hidden type="text" name="blog_url" id="blog_url" value="<?php echo($url) ?><?php if ($url == $domain) { ?>/<?php } ?>">
                <input hidden type="text" name="template" id="template" value="r3_flat">
                <input hidden type="text" name="blog_title" id="blog_title" value="Welcome to Dropplax">
                <textarea hidden name="meta_description" id="meta_description"></textarea>
                <input hidden type="text" name="intro_title" id="intro_title" value="Dropplets + Parallax">
                <textarea hidden name="intro_text" id="intro_text">In a flooded selection of overly complex solutions, Dropplets has been created in order to deliver a much needed alternative. There is something to be said about true simplicity in the design, development and management of a blog. By eliminating all of the unnecessary elements found in typical solutions, Dropplets can focus on pure design, typography and usability. Welcome to an easier way to blog.</textarea>

    		    <button type="submit" name="submit" value="submit">k</button>
    		</form>
                
            <?php if (!$is_writable) { ?>
                <p style="color:red;">It seems that your config folder is not writable, please add the necessary permissions.</p>
            <?php } ?>

            <script>
            	function confirmPass() {
            		var pass = document.getElementById("password").value
            		var confPass = document.getElementById("password-confirmation").value
            		if(pass != confPass) {
            			alert('Your passwords do not match!');
            		}
            	}
            </script>
        </body>
    </html>
<?php 

/*-----------------------------------------------------------------------------------*/
/* That's All There is to It
/*-----------------------------------------------------------------------------------*/

}
