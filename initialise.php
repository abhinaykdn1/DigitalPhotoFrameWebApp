<?php
$filename = 'frame_id.json';
$is_initialised = false;
$frame_id = 1;
if (file_exists($filename)){
  $is_initialised = true;
  $json = file_get_contents($filename);
  $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
  var_dump($obj["id"]);
  $frame_id = $obj["id"];
}
?>
