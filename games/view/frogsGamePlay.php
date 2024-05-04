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
				<?php if($_SESSION["FrogsGame"]->getState()!="You Won!" && $_SESSION["FrogsGame"]->getState()!="You Lost!"){?>
					
					<ul class='images_box'>
						<?php
						$frog_positions = $_SESSION["FrogsGame"]->getPositions();
						for($i=0; $i<count($frog_positions); $i++) {
							if ($frog_positions[$i] == -1) {
								$image_src = 'media/greenFrog.gif';
							}elseif ($frog_positions[$i] == 1) {
								$image_src = 'media/yellowFrog.gif';
							}else {
								$image_src = 'media/empty.gif';
							}
							echo ("<li>");
							echo ("<form method='post'>");
							echo ("<input type='hidden' name='frog_i' value='$i'>");
							echo ("<input type='image' src='$image_src' alt='Submit'>");
							echo ("</form>");
							echo ("</li>");
						}
						?>
					</ul>

					<form method="post">
							<input type="submit" name="replay_frogs" value="Restart!" />
					</form>
					
				<?php } ?>
		
				<?php echo(view_errors($errors)); ?> 

				<?php 
					if($_SESSION["FrogsGame"]->getState()=="You Won!" || $_SESSION["FrogsGame"]->getState()=="You Lost!"){?>
						<form method="post">
							<input type="submit" name="play_frogs_again" value="Play Again!" />
						</form>
				<?php } ?>
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