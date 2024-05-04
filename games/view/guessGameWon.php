<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Games: GuessGame</title>
	</head>
	<body>
		<header>
			<?php $activePage = 'guessGame'; ?>
			<?php include 'navbar.php'; ?>
		</header>
		<main>
			<section>
				<h1>Guess Game</h1>
				<?php echo(view_errors($errors)); ?>
				<?php 
					foreach($_SESSION['GuessGame']->history as $key=>$value){
						echo("<br/> $value");
					}
				?>
				<form method="post">
					<input type="submit" name="submit" value="start again" />
				</form>
			</section>
			<section class='stats'>
				<h1>Stats</h1>
				<?php
				displayStats($dbconn, $_SESSION['user'], 'Guess Game');
				?>
			</section>
		</main>
		<footer>
			A project by ME
		</footer>
	</body>

