<?php

$tn_file = "../../../galleries/".$_POST["folder"]."/tns/".$_POST["name"]."";
$photo_file = "../../../galleries/".$_POST["folder"]."/photos/".$_POST["name"]."";

chmod($tn_file, 0755);
unlink($tn_file);

chmod($photo_file, 0755);
unlink($photo_file);

echo "File Deleted";

?>
