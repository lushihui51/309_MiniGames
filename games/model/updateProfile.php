<?php 
function updateProfile($dbconn, $user_name, $password, $email, $coffee, $game, $weekday, $new_user_name) {
    $errors = [];

    $result = pg_prepare($dbconn, 'check_user_exists', 'SELECT userid FROM appuser WHERE userid=$1');
    $result = pg_execute($dbconn, 'check_user_exists', [$new_user_name]);
    if (pg_num_rows($result) > 0) {
        $errors[] = "A user with that username already exists.";
    } else {
        $result = pg_prepare($dbconn, 'user_name_update', 'UPDATE appuser SET userid=$2 WHERE userid=$1');
        $result = pg_execute($dbconn, 'user_name_update', [$user_name, $new_user_name]);
    }
    
    $email = ($email == '') ? NULL : $email;
    $coffee = ($coffee == '') ? NULL : $coffee;
    $weekday = ($weekday == '') ? NULL : $weekday;
    $result = pg_prepare($dbconn, 'app_user_update', 'UPDATE appuser SET password=$2, email=$3, coffee=$4, weekday=$5 WHERE userid=$1');
    if ($result === FALSE) {
        $errors[] = pg_last_error($dbconn);
    }
    $result = pg_execute($dbconn, 'app_user_update', [$new_user_name, $password, $email, $coffee, $weekday]);
    if ($result === FALSE) {
        $errors[] = pg_last_error($dbconn);
    }

    $result = pg_prepare($dbconn, 'game_delete', 'DELETE FROM game_liked WHERE userid=$1');
    if ($result === FALSE) {
        $errors[] = pg_last_error($dbconn);
    } else {
        $result = pg_execute($dbconn, 'game_delete', [$new_user_name]);
        if ($result === FALSE) {
            $errors[] = pg_last_error($dbconn);
        }
    }

    $result = pg_prepare($dbconn, 'game_insert', 'INSERT INTO game_liked (userid, game) VALUES($1, $2)');
    if ($result === FALSE) {
        $errors[] = pg_last_error($dbconn);
    } else {
        foreach ($game as $value) {
            $result = pg_execute($dbconn, 'game_insert', [$new_user_name, $value]);
            if ($result === FALSE) {
                $errors[] = pg_last_error($dbconn);
            }
        }
    }
    return $errors;
}
?>