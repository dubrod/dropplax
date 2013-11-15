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

$filename = explode('/',$_SERVER[PHP_SELF]);
$category = $filename[count($filename) - 1];
$filename = null;
   

/*-----------------------------------------------------------------------------------*/
/* (All Posts)
/*-----------------------------------------------------------------------------------*/


    $page = (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 1) ? $_GET['page'] : 1;
    $offset = ($page == 1) ? 0 : ($page - 1) * $posts_per_page;

    //Index page cache file name, will be used if index_cache = "on"

    //$cachefile = CACHE_DIR . ($category ? $category : "index") .$page. '.html';

    //If index cache file exists, serve it directly wihout getting all posts
    if (file_exists($cachefile) && $index_cache != 'off') {

        // Get the cached post.
        include $cachefile;
        exit;

    }

    $all_posts = get_posts_for_category($category);

    $pagination = ($pagination_on_off != "off") ? get_pagination($page,round(count($all_posts)/ $posts_per_page)) : "";
    define('PAGINATION', $pagination);
    $posts = ($pagination_on_off != "off") ? array_slice($all_posts,$offset,($posts_per_page > 0) ? $posts_per_page : null) : $all_posts;

    if($posts) {
        ob_start();
        $content = '';
        
        include('./dropplets/for_each_post.php');
        
        echo $content;
        $content = ob_get_contents();
		
		include('./dropplets/page_meta.php');
		
        ob_end_clean();
        
    } 
    
        ob_start();

        // Get the index template file.
        include_once $blog_file;

		
        //Now that we have the whole index page generated, put it in cache folder
        if ($index_cache != 'off') {
            $fp = fopen($cachefile, 'w');
            fwrite($fp, ob_get_contents());
            fclose($fp);
        }
    

}