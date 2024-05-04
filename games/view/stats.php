<?php
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Games: stats</title>
	</head>
	<body>
        <header>
			<?php $activePage = 'stats'; ?>
			<?php include 'navbar.php'; ?>
		</header>
		<main>
			<section>
				<h1>Stats By Game</h1>
				<?php 
				displayStats($dbconn, $_SESSION['user'], 'Guess Game');
				displayStats($dbconn, $_SESSION['user'], 'Rock Paper Scissors');
				displayStats($dbconn, $_SESSION['user'], 'Frogs Game');
				?> 
				
			</section>
			<section class='stats'>
				<h1>Summary Stats</h1>
				<?php
				displayStatsSum($dbconn, $_SESSION['user']);
				?>
			</section>
		</main>
		<footer>
			A project by ME
		</footer>
	</body>
</html>