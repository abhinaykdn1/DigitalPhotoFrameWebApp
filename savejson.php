<?php
$filename = $_GET['filename'];
$file_content = $_GET['json'];
$filepath = "/var/www/example.com/dpf/".$filename;
echo $filepath;
$fh = fopen($filename,'w') or die("can't open file");
fwrite($fh,$file_content);
fclose($fh);
?>
