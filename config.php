<?php
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'crudkorisnik');
  define('DB_PASSWORD', 'vvgmasterzaporka');
  define('DB_NAME', 'crud');

  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>


