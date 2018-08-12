<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Versus</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">

<?php

include('database.php');
$query = "SELECT * FROM Persons ORDER BY RAND() LIMIT 2";
$result = mysqli_query($dbc, $query);
while ( $row = mysqli_fetch_array($result) ) {
  $rows[] = $row;
}

?>
<div class="row">
  <div class="text-center">
    <h1>SINO ANG MAS MAGANDA?</h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <form action="versus.php" method="post">
      <input type="hidden" name="winner" value="<?php echo $rows[0]['ID'] ?>" />
      <input type="hidden" name="loser" value="<?php echo $rows[1]['ID'] ?>" />
      <input type="image" class="center-block" src="<?php echo $rows[0]['FileName'] ?>" height="300" width="300" />
    </form>
  </div>
  <div class="col-sm-6">
    <form action="versus.php" method="post">
      <input type="hidden" name="winner" value="<?php echo $rows[1]['ID'] ?>" />
      <input type="hidden" name="loser" value="<?php echo $rows[0]['ID'] ?>" />
      <input type="image" class="center-block" src="<?php echo $rows[1]['FileName'] ?>" height="300" width="300" />
    </form>
  </div>
</div>
<?php

?>
<?php
if ( isset($_POST['winner']) && isset($_POST['loser']) ) {
  $winner = $_POST['winner'];
  $loser = $_POST['loser'];

  $query = "SELECT Elo FROM Persons WHERE ID=" . $winner .";";
  $result = mysqli_query($dbc, $query);
  $row = mysqli_fetch_array($result);
  $winner_elo = $row['Elo'];

  $query = "SELECT Elo FROM Persons WHERE ID=" . $loser .";";
  $result = mysqli_query($dbc, $query);
  $row = mysqli_fetch_array($result); 
  $loser_elo = $row['Elo'];

  $temp = ($loser_elo - $winner_elo) / 400;
  $qa = 1+pow(10, $temp);
  $ea = 1 / $qa;
  $new_elo_winner = $winner_elo + 32*(1 - $ea);
  $query = "UPDATE Persons SET Elo=" . $new_elo_winner . " WHERE ID=" . $winner . ";";
  $result = mysqli_query($dbc, $query);

  $temp = ($winner_elo  - $loser_elo) / 400;
  $qa = 1+pow(10, $temp);
  $ea = 1 / $qa;

  $new_elo_loser = $loser_elo + 32*(0 - $ea);
  $query = "UPDATE Persons SET Elo=" . $new_elo_loser . " WHERE ID=" . $loser . ";";
  $result = mysqli_query($dbc, $query) or die("error updating database");
  mysqli_close($dbc);
}
?>
    </div>
  </body>
</html>
