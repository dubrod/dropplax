<?php

$count = 0;

foreach($posts as $post) {
			
			//odd & even styling
			$oe_style = ++$count%2 ? "odd" : "even";

            // Get the post title.
            $post_title = str_replace(array("\n",'<h1>','</h1>'), '', $post['post_title']);

            // Get the post author.
            $post_author = $post['post_author'];

            // Get the post author twitter id.
            $post_author_twitter = $post['post_author_twitter'];

            // Get the published ISO date.
            $published_iso_date = $post['post_date'];

            // Generate the published date.
            $published_date = date_format(date_create($published_iso_date), $date_format);

            // Get the post category.
            $post_category = $post['post_category'];
            
            // Get the post category link.
            $post_category_link = $blog_url.'category/'.urlencode(trim(strtolower($post_category)));

            // Get the post status.
            $post_status = $post['post_status'];

            // Get the post intro.
            $post_intro = $post['post_intro'];

            // Get the post content
            $post_content = $post['post_content'];

            // Get the post link.
            $post_link = $blog_url.str_replace(FILE_EXT, '', $post['fname']);

            // Get the post image url.
            $image = str_replace(array(FILE_EXT), '', POSTS_DIR.$post['fname']).'.jpg';

            if (file_exists($image)) {
                $post_image = $blog_url.str_replace(array(FILE_EXT, './'), '', POSTS_DIR.$post['fname']).'.jpg';
            } else {
                //$post_image = get_twitter_profile_img($post_author_twitter);
                $post_image = "/cache/dropplets.jpg";
            }
            
            if ($post_status == 'draft') continue;
						
            // Get the milti-post template file.
            include $posts_file;
        }
?>        