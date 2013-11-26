<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
		if(!$category){ ?>
		<title><?php echo($blog_title); ?> | Blog</title>
		<?php } else { ?>
		<title><?php echo($blog_title); ?> | Category | <? echo($category); ?></title>
		<?php } ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo($page_meta); ?>
        
        <link rel="shortcut icon" href="<?php echo($template_dir_url); ?>favicon.ico">
        
        <!-- jQuery & Required Scripts -->
	    <script src="<?php echo BLOG_URL; ?>js/jquery.js"></script>
	    
        <link href='http://fonts.googleapis.com/css?family=Anaheim' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo($template_dir_url); ?>reset.css">
        
        <link rel="stylesheet" href="<?php echo($template_dir_url); ?>style.css">
		
        <?php get_header(); ?>
          
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-45766253-1', 'dropplax.com');
		  ga('send', 'pageview');
		
		</script>          
</head>
<body>
<?php
if(!$category){ ?>
<nav><a href="/">HOME</a> &gt; BLOG</nav>
<?php } else { ?>
<nav><a href="/">HOME</a> &gt; <a href="/blog/">BLOG</a> &gt; CATEGORY &gt; <? echo($category); ?></nav>
<?php } ?>
       
    <?php echo($content); ?>
        
    <?php get_footer(); ?>
        
    </body>
</html>
