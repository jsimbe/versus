<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>test glob</title>
  </head>
  <body>
<?php
include('database.php');
$dirname = 'photo/';
$images = glob($dirname . "*.png");
foreach ( $images as $image) {
  $query = "INSERT INTO girls (file_name, elo) VALUES ('$image', 1500)";
  $result = mysqli_query($dbc, $query) or die("Error inserting into database");
  echo 'success inserting ' . $image . '</br>';
}

mysqli_close($dbc);
?>
  </body>
</html>
