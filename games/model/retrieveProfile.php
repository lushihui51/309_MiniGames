<?php

function retrieve_password($dbconn, $user_name) { // not null, so has to return 
	$result = pg_prepare($dbconn, 'get password', "SELECT password FROM appuser WHERE userid=$1");
	$result = pg_execute($dbconn, 'get password', [$user_name]);
	return pg_fetch_assoc($result)['password'];
}

function retrieve_email($dbconn, $user_name) { // empty string if null
	$result = pg_prepare($dbconn, 'get email', "SELECT email FROM appuser WHERE userid=$1");
	$result = pg_execute($dbconn, 'get email', [$user_name]);
	$email = pg_fetch_assoc($result)['email'];
	return ($email === NULL) ? '' : $email;
}

function retrieve_coffee($dbconn, $user_name) { // empty string if null
	$result = pg_prepare($dbconn, 'get coffee', "SELECT coffee FROM appuser WHERE userid=$1");
	$result = pg_execute($dbconn, 'get coffee', [$user_name]);
	$coffee = pg_fetch_assoc($result)['coffee'];
	return ($coffee === NULL) ? '' : $coffee;
}

function retrieve_game($dbconn, $user_name) { // empty array if not found
	$result = pg_prepare($dbconn, 'get game', "SELECT game FROM game_liked WHERE userid=$1");
	$result = pg_execute($dbconn, 'get game', [$user_name]);
	$games = [];
	while ($row = pg_fetch_assoc($result)) {
		$games[] = $row['game'];
	}
	return $games;
}

function retrieve_weekday($dbconn, $user_name) { // emtoy string if null
	$result = pg_prepare($dbconn, 'get weekday', "SELECT weekday FROM appuser WHERE userid=$1");
	$result = pg_execute($dbconn, 'get weekday', [$user_name]);
	$weekday = pg_fetch_assoc($result)['weekday'];
	return ($weekday === NULL) ? '' : $weekday;
}
?>

