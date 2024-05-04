<?php
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Games: Frogs Game</title>
	</head>
	<body>
        <header>
			<?php $activePage = 'frogs'; ?>
			<?php include 'navbar.php'; ?>
		</header>
		<main>
			<section>
				<h1>Frogs Game</h1>
				<?php echo(view_errors($errors)); ?>
				<?php 
					echo ("<br/><h3>".$_SESSION['FrogsGame']->getState()."</h3>");
				?> 
                
				<form method="post">
					<input type="submit" name="play_frogs_again" value="Play Again!" />
				</form>
            
			</section>
			<section class='stats'>
				<h1>Stats</h1>
				<?php
				displayStats($dbconn, $_SESSION['user'], 'Frogs Game');
				?>
			</section>
		</main>
		<footer>
			A project by ME
		</footer>
	</body>
</html>