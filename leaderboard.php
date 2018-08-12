<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Leaderboard</title>
  </head>
  <body>
<?php
include('database.php');
$query = "SELECT * FROM Persons ORDER BY Elo DESC;";
$result = mysqli_query($dbc, $query);
while ( $row = mysqli_fetch_array($result) ) {
  echo '<img src="' . $row['FileName'] . '" height="300" width="300" />';
  echo $row['Elo'] . '</br>';
}

mysqli_close($dbc);
?>
  </body>
</html>
