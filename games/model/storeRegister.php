<?php
function storeRegister($dbconn, $user_name, $password, $email, $coffee, $game, $weekday) {
    $errors = [];
    $email = ($email == '') ? NULL : $email;
    $coffee = ($coffee == '') ? NULL : $coffee;
    $weekday = ($weekday == '') ? NULL : $weekday;
    $result = pg_prepare($dbconn, 'app_user_store', 'INSERT INTO appuser VALUES($1, $2, $3, $4, $5)');
    if ($result === FALSE) {
        $errors[] = pg_last_error($dbconn);
    }

    $result = pg_execute($dbconn, 'app_user_store', [$user_name, $password, $email, $coffee, $weekday]);
    if ($result === FALSE) {
        $errors[] = pg_last_error($dbconn);
    }

    $result = pg_prepare($dbconn, 'game_store', 'INSERT INTO game_liked VALUES($1, $2)');
    if ($result === FALSE) {
        $errors[] = pg_last_error($dbconn);
    }

    foreach ($game as $key => $value) {
        $result = pg_execute($dbconn, 'game_store', [$user_name, $value]);
        if ($result === FALSE) {
            $errors[] = pg_last_error($dbconn);
        }
    }

    $result = pg_prepare($dbconn, 'set_guess', "INSERT INTO stats (userid, webgame, best_game, total_played, total_won, loosable_game) VALUES($1, 'Guess Game', NULL, 0, 0, FALSE)");
    $result = pg_prepare($dbconn, 'set_rps', "INSERT INTO stats (userid, webgame, best_game, total_played, total_won, loosable_game) VALUES($1, 'Rock Paper Scissors', NULL, 0, 0, TRUE)");
    $result = pg_prepare($dbconn, 'set_frogs', "INSERT INTO stats (userid, webgame, best_game, total_played, total_won, loosable_game) VALUES($1, 'Frogs Game', NULL, 0, 0, TRUE)");

    $result = pg_execute($dbconn, 'set_guess', [$user_name]);
    $result = pg_execute($dbconn, 'set_rps', [$user_name]);
    $result = pg_execute($dbconn, 'set_frogs', [$user_name]);

    return $errors;
    
}

?>