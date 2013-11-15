<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php if($is_home){ echo($blog_title); } else { echo($post_title); } ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if($is_home){ echo "<meta name=\"description\" content=\"$meta_description\">"; } ?>
        <?php echo($page_meta); ?>
        
        <link rel="shortcut icon" href="<?php echo($template_dir_url); ?>favicon.ico">
        
        <!-- jQuery & Required Scripts -->
	    <script src="<?php echo BLOG_URL; ?>js/jquery.js"></script>
	    
        <link href='http://fonts.googleapis.com/css?family=Anaheim' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo($template_dir_url); ?>reset.css">
        
        <?php if( $_GET["admin"] == ADMIN_SLUG){ ?>
        	<link rel="stylesheet" href="<?php echo($template_dir_url); ?>dashboard.css">
        	<link rel="stylesheet" href="<?php echo BLOG_URL; ?>dropplets/style/style.css">
        <?php } else { ?>
        	<link rel="stylesheet" href="<?php echo($template_dir_url); ?>style.css">
        	<script src="<?php echo($template_dir_url); ?>js/form-validation.js"></script>
        	<script>
        	$(document).ready(function() {
	        	$("#intakeButton").click(function(){ var fields = new Array("fullname", "phone", "email"); validateForm(fields) });
	        });	
        	</script>
        <?php } ?>
        
        <!-- RSS Feed Links -->
	    <link rel="alternate" type="application/rss+xml" title="Subscribe using RSS" href="<?php echo BLOG_URL; ?>rss" />

		<?php 
		if(!$is_home){
			if($post_gallery){
	        	echo '
	        	<!-- r3+ autoDLC -->
				<link rel="stylesheet" href="plugins/autoDLC/css/autoDLC.css">
				<script src="plugins/autoDLC/js/autoDLC.js"></script>
				<script>$(document).ready(function(){autoDLC("'.$post_gallery.'");});</script>
				';
			}
		}
		?>
		
        <?php get_header(); ?>
       
    </head>

    <body>
    <?php
    if( $_GET["admin"] == ADMIN_SLUG){
    	if (isset($_SESSION['user']))	
    	{ include('dashboard.php'); }
    }
    if($is_home) { 	
    ?>
    
        <header>
            <h1><?php echo($blog_title); ?></h1>
            <h2><?php echo($intro_title); ?></h2>    
        </header>
        <div id="intro"><p><?php echo($intro_text); ?></p></div>
        <div id="feature">
        	<div id="avatar"><img src="<?php echo($template_dir_url); ?>img/avatar.jpg" alt="" /></div>
        	<h3><i></i><a href="https://twitter.com/<?php echo($blog_twitter);?>" target="_blank"><?php echo($blog_twitter);?></a></h3>
        </div>
        <div id="intake">
        	<div id="emailIcon">
        		<i></i>
	        	<div id="form_error"></div>
        	</div>
	        <div id="emailForm">
		        <div id="pad">
			        
			        <div id="fields">
			        	<input type="text" name="fullname" id="fullname" placeholder="Full Name*" />
				        <input type="email" name="email" id="email" placeholder="Email Address*" />
				        <input type="text" name="phone" id="phone" placeholder="Phone Number*" />
			        </div>
			        <div id="finish">
				        <textarea name="message" id="message" placeholder="Message"></textarea>
				        <button id="intakeButton">EMAIL ME</button>
			        </div>
			    </div>
			        
			    <div id="form-success"><p>Thank You for the Message!</p></div>
	        
	        </div>
        </div>
        <div id="most-recent">
	        <div id="holder"><?php include('cache/front.txt'); ?></div>
        </div>
        
        <div id="view-all"><a href="/blog">VIEW ALL POSTS</a></div>
    
    <?php
    } else { // eof if is home 
    
	    if( $_GET["admin"] == ADMIN_SLUG){  } else {
	    
	    echo "<nav  itemprop=\"breadcrumb\"><a href=\"/\">HOME</a> &gt; <a href=\"/blog/\">BLOG</a>  &gt; $page_title</nav>";
	    
	    }
	    

	    echo($content);
	    
	    
    }
    
    get_footer(); 
    
    ?>
        
    </body>
</html>
