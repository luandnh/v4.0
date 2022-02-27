<?php 
  function go_logger($data, $path="go_debug.log"){
    $fh = fopen( $path, 'a') or die("Can't open file.");
    $results = print_r($data, true);
    fwrite($fh, $results);
    fwrite($fh, "\n");
    fclose($fh);
  }
  $body = file_get_contents('php://input');
  $input = json_decode($inputJSON, TRUE);
  go_logger($body);
  go_logger($GLOBALS);
  echo($inputJSON);
?>