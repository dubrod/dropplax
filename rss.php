<?php

/*-----------------------------------------------------------------------------------*/
/* If There's a Config Exists, Continue
/*-----------------------------------------------------------------------------------*/

if (file_exists('./config.php')) {

/*-----------------------------------------------------------------------------------*/
/* Get Settings & Functions
/*-----------------------------------------------------------------------------------*/

include('./dropplets/settings.php');
include('./dropplets/functions.php');


    $feed = new FeedWriter(RSS2);

    $feed->setTitle($blog_title);
    $feed->setLink($blog_url);

    $feed->setDescription($meta_description);
    $feed->setChannelElement('language', $language);
    $feed->setChannelElement('pubDate', date(DATE_RSS, time()));
    
    $posts = get_all_posts();

    if($posts) {
        $c=0;
        foreach($posts as $post) {
            if($c<$feed_max_items) {
                $item = $feed->createNewItem();

                // Remove HTML from the RSS feed.
                $item->setTitle(substr($post['post_title'], 4, -6));
                $item->setLink(rtrim($blog_url, '/').'/'.str_replace(FILE_EXT, '', $post['fname']));
                $item->setDate($post['post_date']);

                // Remove Meta from the RSS feed.
				$remove_metadata_from = file(rtrim(POSTS_DIR, '/').'/'.$post['fname']);
				$item->addElement('author', $blog_email.' ('.str_replace('-', '', $remove_metadata_from[1]).')');
                $item->addElement('guid', rtrim($blog_url, '/').'/'.str_replace(FILE_EXT, '', $post['fname']));
                
				// Remove the metadata from the RSS feed.
				unset($remove_metadata_from[0], $remove_metadata_from[1], $remove_metadata_from[2], $remove_metadata_from[3], $remove_metadata_from[4], $remove_metadata_from[5]);
				$remove_metadata_from = array_values($remove_metadata_from);

                $item->setDescription(Markdown(implode($remove_metadata_from)));

                $feed->addItem($item);
                $c++;
            }
        }
    }
    $feed->genarateFeed();
}
?>