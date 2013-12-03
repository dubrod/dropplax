<?php

session_start();
if(isset($_SESSION['user'])){

// File locations.
$settings_file = "../config.php";
$phpass_file   = '../dropplets/includes/phpass.php';

// Get existing settings.
if (file_exists($settings_file)) {
    include($settings_file);
}
if (file_exists($phpass_file))
{
    include($phpass_file);
    $hasher  = new PasswordHash(8,FALSE);
}
function settings_format($name, $value) {
    return sprintf("\$%s = \"%s\";", $name, $value);
}

/*-----------------------------------------------------------------------------------*/
/* Save Submitted Settings
/*-----------------------------------------------------------------------------------*/

// Should allow this only on first install or after the user is authenticated
// but this doesn't quite work. So back to default.
//if ($_POST["submit"] == "submit" && (!file_exists($settings_file) || isset($_SESSION['user'])))
if ($_POST["submit"] == "submit")
{
    // Get submitted setup values.
    if (isset($_POST["introbg_toggle"])) {
        $introbg_toggle = $_POST["introbg_toggle"];
    }
    if (isset($_POST["menu_toggle"])) {
        $menu_toggle = $_POST["menu_toggle"];
    }
    
   
    if (isset($_POST["blog_email"])) {
        $blog_email = $_POST["blog_email"];
    }
    if (isset($_POST["blog_twitter"])) {
        $blog_twitter = $_POST["blog_twitter"];
    }
    if (isset($_POST["blog_url"])) {
        $blog_url = $_POST["blog_url"];
    }
    if (isset($_POST["blog_title"])) {
        $blog_title = $_POST["blog_title"];
    }
    if (isset($_POST["meta_description"])) {
        $meta_description = $_POST["meta_description"];
    }
    if (isset($_POST["intro_title"])) {
        $intro_title = $_POST["intro_title"];
    }
    if (isset($_POST["intro_text"])) {
        $intro_text = $_POST["intro_text"];
    }
    if (isset($_POST["template"])) {
        $template = $_POST["template"];
    }

    // There must always be a $password, but it can be changed optionally in the
    // settings, so you might not always get it in $_POST.
    if (!isset($password) || !empty($_POST["password"])) {
        $password = $hasher->HashPassword($_POST["password"]);
    }
    
    // r3+
    if (isset($_POST["admin-slug"])) {
        $admin_slug = $_POST["admin-slug"];
    }
    // eof r3+

    if(!isset($header_inject)) {
        $header_inject = "";        
    }

    if(isset($_POST["header_inject"])) {
        $header_inject = addslashes($_POST["header_inject"]);
    }

    if(!isset($footer_inject)) {
        $footer_inject = "";
    }
    
    if(isset($_POST["footer_inject"])) {
        $footer_inject = addslashes($_POST["footer_inject"]);
    }

    // Get subdirectory
    $dir .= str_replace('dropplets/save.php', '', $_SERVER["REQUEST_URI"]);

    // Output submitted setup values.
    $config[] = "<?php";
    //r3+
    $config[] = settings_format("menu_toggle", $menu_toggle);
    $config[] = settings_format("introbg_toggle", $introbg_toggle);
    $config[] = settings_format("admin_slug", $admin_slug);
    //r3+
    
    $config[] = settings_format("blog_email", $blog_email);
    $config[] = settings_format("blog_twitter", $blog_twitter);
    $config[] = settings_format("blog_url", $blog_url);
    $config[] = settings_format("blog_title", $blog_title);
    $config[] = settings_format("meta_description", $meta_description);
    $config[] = settings_format("intro_title", $intro_title);
    $config[] = settings_format("intro_text", $intro_text);
    $config[] = "\$password = '".$password."';";
     
    $config[] = settings_format("header_inject", $header_inject);
    $config[] = settings_format("footer_inject", $footer_inject);
    $config[] = settings_format("template", $template);
    
    // Create the settings file.
    file_put_contents($settings_file, implode("\n", $config));
  	chmod($settings_file, 0600);  
    //writing a .htaccess file is very bad idea
    
    // Redirect
    header("Location: " . $blog_url."?admin=".$admin_slug);
} 

} // eof if session 
?>
