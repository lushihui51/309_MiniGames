<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	require_once "lib/lib.php";
	require_once "model/something.php";
	require_once "model/guessGame.php";
	require_once "model/logout.php";
	require_once "model/rockPaperScissors.php";
	require_once "model/frogsGame.php";
	require_once "model/checkRegister.php";
	require_once "model/storeRegister.php";
	require_once "model/retrieveProfile.php";
	require_once "model/updateProfile.php";

	session_save_path("sess");
	session_start(); 

	$dbconn = db_connect();
	require_once "model/statsLib.php";

	$errors=array();
	$highlight = array();
	$view="";

	/* controller code */

	/* local actions, these are state transforms */
	// $allowedNavStates = ["stats", "guessGamePlay", "rockPaperScissors", "frogsGamePlay", "profile", "logout"]; 
	$allowedNavStates = ["stats", "guessGamePlay", "rockPaperScissorsPlay", "frogsGamePlay", "profile", "logout"];
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
	} elseif (isset($_REQUEST["nav_directed_state"])) {
		if (in_array($_REQUEST["nav_directed_state"], $allowedNavStates)) {
			$_SESSION['state'] = $_REQUEST["nav_directed_state"];
		} else {
			$_SESSION['state'] = "unavailable";
		}
	}

	switch($_SESSION['state']){
		case "login":
			// the view we display by default
			$view="login.php";

			// check register
			if(isset($_GET['go_register']) && $_GET['go_register'] == 'true') {
				$_SESSION['state'] = 'register';
				$view = "register.php";
				break;
			}

			// check if submit or not
			if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
				break;
			}

			// validate and set errors
			if(empty($_REQUEST['user']))$errors[]='user is required';
			if(empty($_REQUEST['password']))$errors[]='password is required';
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			if(!$dbconn){
				$errors[]="Can't connect to db";
				break;
			}
			$query = "SELECT * FROM appuser WHERE userid=$1 and password=$2;";
            $result = pg_prepare($dbconn, "", $query);
            $result = pg_execute($dbconn, "", array($_REQUEST['user'], $_REQUEST['password']));
            if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				$_SESSION['user']=$_REQUEST['user'];
				$_SESSION['state']='stats';
				$view="stats.php";
			} else {
				$errors[]="invalid login";
			}
			break;
		
		case "register":
			$_REQUEST['user_name']= isset($_REQUEST['user_name']) ? $_REQUEST['user_name'] : '';
			$_REQUEST['set_password']= isset($_REQUEST['set_password']) ? $_REQUEST['set_password'] : '';
			$_REQUEST['email']= isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
			$_REQUEST['coffee']= isset($_REQUEST['coffee']) ? $_REQUEST['coffee'] : '';
			$_REQUEST['game']= isset($_REQUEST['game']) ? $_REQUEST['game'] : [];
			$_REQUEST['weekday']= isset($_REQUEST['weekday']) ? $_REQUEST['weekday'] : '';
			$_REQUEST['confirm_password']= isset($_REQUEST['confirm_password']) ? $_REQUEST['confirm_password'] : '';

			$view = "register.php";
			if (isset($_GET['back_to_login']) && $_GET['back_to_login'] == 'true') {
				$_SESSION['state'] = 'login';
				$view='login.php';
				break;
			}

			if (!isset($_REQUEST['submit_register']) || $_REQUEST['submit_register'] != 'submitted') {
				break;
			}

			// backend check errors of register form
			$err_and_hl = checkRegister($dbconn, $_REQUEST['user_name'], $_REQUEST['set_password'], $_REQUEST['confirm_password'], $_REQUEST['email']);
			$errors = array_merge($errors, $err_and_hl[0]);
			$highlight = $err_and_hl[1];
			if (!empty($errors)) {
				break;
			}

			// store inputs into database
			$errors = array_merge($errors, storeRegister($dbconn, $_REQUEST['user_name'], $_REQUEST['set_password'], $_REQUEST['email'], $_REQUEST['coffee'], $_REQUEST['game'], $_REQUEST['weekday']));
			if (!empty($errors)) {
				break;
			}

			// perform state change
			$_SESSION['state'] = 'login';
			$view = "login.php";
			break;
		
		case "profile":
			$_REQUEST['user_name']= isset($_REQUEST['user_name']) ? $_REQUEST['user_name'] : '';
			$_REQUEST['set_password']= isset($_REQUEST['set_password']) ? $_REQUEST['set_password'] : '';
			$_REQUEST['email']= isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
			$_REQUEST['coffee']= isset($_REQUEST['coffee']) ? $_REQUEST['coffee'] : '';
			$_REQUEST['game']= isset($_REQUEST['game']) ? $_REQUEST['game'] : [];
			$_REQUEST['weekday']= isset($_REQUEST['weekday']) ? $_REQUEST['weekday'] : '';
			$_REQUEST['confirm_password']= isset($_REQUEST['confirm_password']) ? $_REQUEST['confirm_password'] : '';

			$view="profile.php";
			if (!isset($_REQUEST['change_profile']) || $_REQUEST['change_profile'] != 'submitted') {
				break;
			}
			$err_and_hl = checkRegisterProfile($dbconn, $_REQUEST['user_name'], $_REQUEST['set_password'], $_REQUEST['confirm_password'], $_REQUEST['email']);
			$errors = array_merge($errors, $err_and_hl[0]);
			$highlight = $err_and_hl[1];
			if (!empty($errors)) {
				break;
			}

			// update database
			$errors = array_merge($errors, updateProfile($dbconn, $_SESSION['user'], $_REQUEST['set_password'], $_REQUEST['email'], $_REQUEST['coffee'], $_REQUEST['game'], $_REQUEST['weekday'], $_REQUEST['user_name']));
			if (!empty($errors)) {
				break;
			}
			// logout and change state
			logout();
			$_SESSION['state']="login";
			$view="login.php";
			break;
		
		case "frogsGamePlay":
			$view="frogsGamePlay.php";
			$_SESSION['FrogsGame'] = (isset($_SESSION['FrogsGame'])) ? $_SESSION['FrogsGame'] : new FrogsGame();
			// below only runs if page was redirected from navbar, and the game is finished
			if($_SESSION['FrogsGame']->getState() == 'You Won!' || $_SESSION['FrogsGame']->getState() == 'You Lost!'){
				$_SESSION['state']="frogsGameOver";
				$view="frogsGameOver.php";
			}
			
			if(isset($_REQUEST['replay_frogs']) && $_REQUEST['replay_frogs'] == "Restart!") {
				$_SESSION["FrogsGame"]=new FrogsGame();
				break;
			} 
			
			if(!isset($_REQUEST['frog_i'])){
				break;
			}
			$_SESSION['FrogsGame']->jump($_REQUEST['frog_i']);
			if($_SESSION['FrogsGame']->getState() == 'You Won!' || $_SESSION['FrogsGame']->getState() == 'You Lost!'){
				if($_SESSION['FrogsGame']->getState() == 'You Won!') {
					updateStats($dbconn, $_SESSION['user'], 'Frogs Game', $_SESSION['FrogsGame']->getJumps());
				} else {
					updateStats($dbconn, $_SESSION['user'], 'Frogs Game', -1);
				}
				$_SESSION['state']="frogsGameOver";
				$view="frogsGameOver.php";
			}
			break;
		
		case "frogsGameOver":
			$view="frogsGameOver.php";

			// check if submit or not
			if(empty($_REQUEST['play_frogs_again'])){
				$errors[]="Invalid request";
				$view="frogsGameOver.php";
			}

			// validate and set errors
			if(!empty($errors))break;
			
			// perform operation, switching state and view if necessary
			$_SESSION["FrogsGame"]=new FrogsGame();

			if($_REQUEST['play_frogs_again'] == "Play Again!") {
				$_SESSION['state']="frogsGamePlay";
				$view="frogsGamePlay.php";
			} 
			break;
		
		case "rockPaperScissorsPlay":
			$view="rockPaperScissorsPlay.php";
			$_SESSION['RockPaperScissors'] = (isset($_SESSION['RockPaperScissors'])) ? $_SESSION['RockPaperScissors'] : new RockPaperScissors();
			
			// below only runs if page was redirected from navbar, and the game is finished
			if($_SESSION['RockPaperScissors']->getState() == 'I won!' || $_SESSION['RockPaperScissors']->getState() == 'You won...'){
				$_SESSION['state']="rockPaperScissorsWon";
				$view="rockPaperScissorsWon.php";
			}

			if(empty($_REQUEST['choose'])){
				break;
			}

			// perform operation, switching state and view if necessary
			$_SESSION["RockPaperScissors"]->battle($_REQUEST['choose']);
			if($_SESSION['RockPaperScissors']->getState() == 'I won!' || $_SESSION['RockPaperScissors']->getState() == 'You won...'){
				if($_SESSION['RockPaperScissors']->getState() == 'You won...') {
					updateStats($dbconn, $_SESSION['user'], 'Rock Paper Scissors', $_SESSION['RockPaperScissors']->getPlays());
				} else {
					updateStats($dbconn, $_SESSION['user'], 'Rock Paper Scissors', -1);
				}
				$_SESSION['state']="rockPaperScissorsWon";
				$view="rockPaperScissorsWon.php";
			}
			break;
		
		case "rockPaperScissorsWon":
			// the view we display by default
			$view="rockPaperScissorsWon.php";

			// check if submit or not
			if(empty($_REQUEST['play_again'])){
				$errors[]="Invalid request";
				$view="rockPaperScissorsWon.php";
			}

			// validate and set errors
			if(!empty($errors))break;
			
			// perform operation, switching state and view if necessary
			$_SESSION["RockPaperScissors"]=new RockPaperScissors();

			if($_REQUEST['play_again'] == "Play Again!") {
				$_SESSION['state']="rockPaperScissorsPlay";
				$view="rockPaperScissorsPlay.php";
			} else {
				logout();
				$_SESSION['state']="login";
				$view="login.php";
			}
			break;
		
		case "stats":
			$view="stats.php";
			break;
		
		case "guessGamePlay":
			$view="guessGamePlay.php";
			$_SESSION['GuessGame'] = (isset($_SESSION['GuessGame'])) ? $_SESSION['GuessGame'] : new GuessGame();
			// below only runs if page was redirected from navbar, and the game is finished
			if($_SESSION["GuessGame"]->getState()=="correct"){
				$_SESSION['state']="guessGameWon";
				$view="guessGameWon.php";
			}

			// check submit
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="guess"){
				break;
			}
			// validate and set errors
			if(!is_numeric($_REQUEST["guess"]))$errors[]="Guess must be numeric.";
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			$_SESSION["GuessGame"]->makeGuess($_REQUEST['guess']);
			if($_SESSION["GuessGame"]->getState()=="correct"){
				updateStats($dbconn, $_SESSION['user'], 'Guess Game', $_SESSION['GuessGame']->getGuesses());
				$_SESSION['state']="guessGameWon";
				$view="guessGameWon.php";
			}
			$_REQUEST['guess']="";
			break;
		
		case "guessGameWon":
			// the view we display by default
			$view="guessGameWon.php";
			if(isset($_REQUEST['submit']) && $_REQUEST['submit'] == "start again"){
				$_SESSION["GuessGame"] = new GuessGame();
				$_SESSION['state'] = "guessGamePlay";
				$view = "guessGamePlay.php";
				break;
			} elseif(!isset($_REQUEST['submit'])) {
				break;
			} else {
				$errors[]="Invalid request";
				break;
			}
		
		case "logout":
			logout();
			$_SESSION['state']="login";
			$view="login.php";
			break;

		case "unavailable":
			$view="unavailable.php";
			break;
		
	}
	require_once "view/$view";
?>