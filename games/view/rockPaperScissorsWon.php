<?php
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Games: Rock Paper Scissors</title>
	</head>
	<body>
        <header>
			<?php $activePage = 'rockPaperScissors'; ?>
			<?php include 'navbar.php'; ?>
		</header>
		<main>
			<section>
				<h1>Rock Paper Scissors</h1>
				<?php echo(view_errors($errors)); ?>
				<?php 
					foreach($_SESSION['RockPaperScissors']->history as $key=>$value){
						echo("<br/> $value");
					}
					echo ("<br/><br/>your score: ".$_SESSION['RockPaperScissors']->getScore()[1].", my score: ".$_SESSION['RockPaperScissors']->getScore()[0]);

					echo ("<br/><h3>".$_SESSION['RockPaperScissors']->getState()."</h3>");
				?> 
				<form method="post">
					<input type="submit" name="play_again" value="Play Again!" />
					<input type="submit" name="play_again" value="Quit" />
				</form>
			</section>
			<section class='stats'>
				<h1>Stats</h1>
				<?php
				displayStats($dbconn, $_SESSION['user'], 'Rock Paper Scissors');
				?>
			</section>
		</main>
		<footer>
			A project by ME
		</footer>
	</body>
</html>

