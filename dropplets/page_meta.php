<?php


        // Get the site title
        $page_title = $blog_title;

        $blog_image = 'https://api.twitter.com/1/users/profile_image?screen_name='.$blog_twitter.'&size=bigger';

        // Get the page description and author meta.
        $get_page_meta[] = '<meta name="description" content="' . $meta_description . '">';
        $get_page_meta[] = '<meta name="author" content="' . $blog_title . '">';

        // Get the Twitter card.
        $get_page_meta[] = '<meta name="twitter:card" content="summary">';
        $get_page_meta[] = '<meta name="twitter:site" content="' . $blog_twitter . '">';
        $get_page_meta[] = '<meta name="twitter:title" content="' . $blog_title . '">';
        $get_page_meta[] = '<meta name="twitter:description" content="' . $meta_description . '">';
        $get_page_meta[] = '<meta name="twitter:creator" content="' . $blog_twitter . '">';
        $get_page_meta[] = '<meta name="twitter:image:src" content="' . $blog_image . '">';
        $get_page_meta[] = '<meta name="twitter:domain" content="' . $blog_url . '">';

        // Get the Open Graph tags.
        $get_page_meta[] = '<meta property="og:type" content="website">';
        $get_page_meta[] = '<meta property="og:title" content="' . $blog_title . '">';
        $get_page_meta[] = '<meta property="og:site_name" content="' . $blog_title . '">';
        $get_page_meta[] = '<meta property="og:url" content="' .$blog_url . '">';
        $get_page_meta[] = '<meta property="og:description" content="' . $meta_description . '">';
        $get_page_meta[] = '<meta property="og:image" content="' . $blog_image . '">';

        // Get all page meta.
        $page_meta = implode("\n", $get_page_meta);
        

?>        