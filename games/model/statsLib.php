<?php 

$result = pg_prepare($dbconn, 'get total_played', 'SELECT total_played FROM stats WHERE userid = $1 AND webgame = $2');
$result = pg_prepare($dbconn, 'increment total_played', 'UPDATE stats SET total_played = total_played + 1 WHERE userid = $1 AND webgame = $2');
$result = pg_prepare($dbconn, 'get best_game', 'SELECT best_game FROM stats WHERE userid = $1 AND webgame = $2');
$result = pg_prepare($dbconn, 'update best_game', 'UPDATE stats SET best_game = $1 WHERE userid = $2 AND webgame = $3');
$result = pg_prepare($dbconn, 'get total_won', 'SELECT total_won FROM stats WHERE userid = $1 AND webgame = $2');
$result = pg_prepare($dbconn, 'increment total_won', 'UPDATE stats SET total_won = total_won + 1 WHERE userid = $1 AND webgame = $2');
$result = pg_prepare($dbconn, 'get stats row', 'SELECT * FROM stats where userid = $1 AND webgame = $2');
$result = pg_prepare($dbconn, 'get sum_total_won', 'SELECT SUM(total_won) AS sum_total_won FROM stats WHERE userid = $1');
$result = pg_prepare($dbconn, 'get sum_total_played', 'SELECT SUM(total_played) AS sum_total_played FROM stats WHERE userid = $1');

function updateStats($dbconn, $user_name, $webgame, $this_game) {
    // $this_game is -1 if the player lost, a number >= 0 if the player won/completed the game
        // guessgame: $this_game is # guesses
        // rockpaperscissors: $this_game is # my_score
        // frogsgame: $this_game is # moves
    $errors = array();
    $result = pg_execute($dbconn, 'increment total_played', [$user_name, $webgame]);

    if ($this_game >= 0) {
        // best_game = min(webgame, best_game)
        $result = pg_execute($dbconn, 'get best_game', [$user_name, $webgame]);
        $best_game = pg_fetch_assoc($result)['best_game'];
        if ($best_game === NULL || ($best_game != NULL && $best_game > $this_game)) {
            $result = pg_execute($dbconn, 'update best_game', [$this_game, $user_name, $webgame]);
        } 

        // total_won + 1
        $result = pg_execute($dbconn, 'increment total_won', [$user_name, $webgame]);
    }
}

function displayStatValue($key, $value) {
    if ($value === NULL) return 'N/A';
    if ($key === 'loosable_game') return ($value === 't') ? 'Game is loosable' : 'Game is not loosable';
    return htmlspecialchars($value);
}

function displayStats($dbconn, $user_name, $webgame) {
    echo ("<h5>".htmlspecialchars($webgame)."</h5>");
    $result = pg_execute($dbconn, 'get stats row', [$user_name, $webgame]);
    if ($row = pg_fetch_assoc($result)) {
        foreach ($row as $key => $value) {
            $displayKey = ($key == 'best_game') ? 'Least moves to win' : htmlspecialchars($key);
            $displayValue = displayStatValue($key, $value);
            echo ("<br>".$displayKey.": ".$displayValue);
        }
    } else {
        echo "<br>Could not retrieve stats.";
    }
}

function displayStatsSum($dbconn, $user_name) {
    $result = pg_execute($dbconn, 'get sum_total_won', [$user_name]);
    $sum_total_won = pg_fetch_assoc($result)['sum_total_won'];
    $result = pg_execute($dbconn, 'get sum_total_played', [$user_name]);
    $sum_total_played = pg_fetch_assoc($result)['sum_total_played'];
    if ($sum_total_played > 0) {
        $win_rate = round(($sum_total_won / $sum_total_played) * 100, 2);
    } else {
        $win_rate = 0;
    }
    echo ("<br>Total wins from all games: ".htmlspecialchars($sum_total_won));
    echo ("<br>Total number of games played: ".htmlspecialchars($sum_total_played));
    echo ("<br>Total win-rate: ".htmlspecialchars($win_rate).'%');
}
?>