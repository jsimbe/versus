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
$images = glob($dirname . "*.jpg");
foreach ( $images as $image) {
  $query = "INSERT INTO Persons (FileName, Elo) VALUES ('$image', 1500)";
  $result = mysqli_query($dbc, $query) or die("Error inserting into database");
}

mysqli_close($dbc);
?>
  </body>
</html>
