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
$query = "SELECT * FROM girls ORDER BY RAND() LIMIT 2";
$result = mysqli_query($dbc, $query);
while ( $row = mysqli_fetch_array($result) ) {
  $rows[] = $row;
}

?>
<div class="row">
  <div class="text-center">
    <h1>CLICK WHO'S HOTTER!</h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <form action="versus.php" method="post">
      <input type="hidden" name="winner" value="<?php echo $rows[0]['id'] ?>" />
      <input type="hidden" name="loser" value="<?php echo $rows[1]['id'] ?>" />
      <input type="image" class="center-block" src="<?php echo $rows[0]['file_name'] ?>" height="300" width="300" />
    </form>
  </div>
  <div class="col-sm-6">
    <form action="versus.php" method="post">
      <input type="hidden" name="winner" value="<?php echo $rows[1]['id'] ?>" />
      <input type="hidden" name="loser" value="<?php echo $rows[0]['id'] ?>" />
      <input type="image" class="center-block" src="<?php echo $rows[1]['file_name'] ?>" height="300" width="300" />
    </form>
  </div>
</div>
<?php

?>
<?php

function get_new_elo_change($player_elo, $opponent_elo)
{
  $temp = ($opponent_elo - $player_elo) / 400;
  $q = 1+pow(10, $temp);
  $e = 1 / $q;
  return $e;
}
if ( isset($_POST['winner']) && isset($_POST['loser']) ) {
  $winner = $_POST['winner'];
  $loser = $_POST['loser'];

  $query = "SELECT elo FROM girls WHERE id=" . $winner .";";
  $result = mysqli_query($dbc, $query);
  $row = mysqli_fetch_array($result);
  $winner_elo = $row['elo'];

  $query = "SELECT elo FROM girls WHERE id=" . $loser .";";
  $result = mysqli_query($dbc, $query);
  $row = mysqli_fetch_array($result); 
  $loser_elo = $row['elo'];

  $new_elo_winner = $winner_elo + 32 * (1 - get_new_elo_change($winner_elo, $loser_elo));
  $query = "UPDATE girls SET elo=" . $new_elo_winner . " WHERE id=" . $winner;
  $result = mysqli_query($dbc, $query);


  $new_elo_loser = $loser_elo + 32*(0 - get_new_elo_change($loser_elo, $winner_elo));
  $query = "UPDATE girls SET elo=" . $new_elo_loser . " WHERE id=" . $loser;
  $result = mysqli_query($dbc, $query) or die("error updating database");
  mysqli_close($dbc);
}
?>
    </div>
  </body>
</html>
