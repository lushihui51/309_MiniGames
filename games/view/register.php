<?php
$_REQUEST['user_name']= isset($_REQUEST['user_name']) ? $_REQUEST['user_name'] : '';
$_REQUEST['set_password']= isset($_REQUEST['set_password']) ? $_REQUEST['set_password'] : '';
$_REQUEST['email']= isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
$_REQUEST['coffee']= isset($_REQUEST['coffee']) ? $_REQUEST['coffee'] : '';
$_REQUEST['game']= isset($_REQUEST['game']) ? $_REQUEST['game'] : [];
$_REQUEST['weekday']= isset($_REQUEST['weekday']) ? $_REQUEST['weekday'] : '';
$_REQUEST['confirm_password']= isset($_REQUEST['confirm_password']) ? $_REQUEST['confirm_password'] : '';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Games: Register</title>
	</head>
	<body>
		<main>
			<section>
				<h1>Register to Play Games!</h1>
				<form id="registrationForm" method="post">
					<div class="form-row" id="r1">
						<label for="user_name">User Name:</label>
						<input type="text" id="user_name" name="user_name" 
						value="<?php echo htmlspecialchars($_REQUEST['user_name']); ?>" pattern="[A-Za-z0-9]+" title="User Name should only contain letters and numbers." required
						class="<?php echo in_array('user_name', $highlight) ? 'highlight' : ''; ?>">
					</div>
					<div class="form-row" id="r2">
						<label for="set_password">Set Password:</label>
						<input type="password" id="set_password" name="set_password" 
						value="<?php echo($_REQUEST['set_password']);?>" pattern="[A-Za-z0-9]+" title="Password should only contain letters and numbers." required
						class="<?php echo in_array('set_password', $highlight) ? 'highlight' : ''; ?>">
					</div>
					<div class="form-row" id="r3">
						<label for="confirm_password">Confirm Password:</label>
						<input type="password" id="confirm_password" name="confirm_password" 
						value="<?php echo($_REQUEST['confirm_password']);?>" pattern="[A-Za-z0-9]+" title="Password should only contain letters and numbers." required
						class="<?php echo in_array('confirm_password', $highlight) ? 'highlight' : ''; ?>">
					</div>
					<div class="form-row" id="r4">
						<label for="email">Email:</label>
						<input type="email" id="email" name="email" 
						value="<?php echo($_REQUEST['email']);?>"
						class="<?php echo in_array('email', $highlight) ? 'highlight' : ''; ?>">
					</div>
					<div class="form-row" id="r5">
						<p>Favorite type of coffee?</p>
						<input type="radio" id="espresso" name="coffee" value="espresso" <?php echo ($_REQUEST['coffee'] == 'espresso') ? 'checked' : ''; ?>>
						<label for="espresso">Espresso</label><br>
						
						<input type="radio" id="latte" name="coffee" value="latte" <?php echo ($_REQUEST['coffee'] == 'latte') ? 'checked' : ''; ?>>
						<label for="latte">Latte</label><br>
						
						<input type="radio" id="cappuccino" name="coffee" value="cappuccino" <?php echo ($_REQUEST['coffee'] == 'cappuccino') ? 'checked' : ''; ?>>
						<label for="cappuccino">Cappuccino</label><br>
						
						<input type="radio" id="americano" name="coffee" value="americano" <?php echo ($_REQUEST['coffee'] == 'americano') ? 'checked' : ''; ?>>
						<label for="americano">Americano</label><br>

						<input type="radio" id="macchiato" name="coffee" value="macchiato" <?php echo ($_REQUEST['coffee'] == 'macchiato') ? 'checked' : ''; ?>>
						<label for="macchiato">Macchiato</label><br>

						<input type="radio" id="mocha" name="coffee" value="mocha" <?php echo ($_REQUEST['coffee'] == 'mocha') ? 'checked' : ''; ?>>
						<label for="mocha">Mocha</label><br>
					</div>
					<div class="form-row" id="r6">
					<p>Favorite type of game? (Select all that apply:)</p>
						<input type="checkbox" id="action" name="game[]" value="action" <?php echo in_array('action', $_REQUEST['game']) ? 'checked' : ''; ?>>
						<label for="action">Action</label><br>
						
						<input type="checkbox" id="adventure" name="game[]" value="adventure" <?php echo in_array('adventure', $_REQUEST['game']) ? 'checked' : ''; ?>> 
						<label for="adventure">Adventure</label><br>
						
						<input type="checkbox" id="strategy" name="game[]" value="strategy" <?php echo in_array('strategy', $_REQUEST['game']) ? 'checked' : ''; ?>>
						<label for="strategy">Strategy</label><br>
						
						<input type="checkbox" id="sports" name="game[]" value="sports" <?php echo in_array('sports', $_REQUEST['game']) ? 'checked' : ''; ?>>
						<label for="sports">Sports</label><br>
						
						<input type="checkbox" id="puzzle" name="game[]" value="puzzle" <?php echo in_array('puzzle', $_REQUEST['game']) ? 'checked' : ''; ?>>
						<label for="puzzle">Puzzle</label><br>
						
						<input type="checkbox" id="multiplayer_online" name="game[]" value="multiplayer_online" <?php echo in_array('multiplayer_online', $_REQUEST['game']) ? 'checked' : ''; ?>>
						<label for="multiplayer_online">Multiplayer Online Battle Arena (MOBA)</label><br>
						
						<input type="checkbox" id="role_playing" name="game[]" value="role_playing" <?php echo in_array('role_playing', $_REQUEST['game']) ? 'checked' : ''; ?>>
						<label for="role_playing">Role-Playing Games (RPG)</label><br>
						
						<input type="checkbox" id="simulation" name="game[]" value="simulation" <?php echo in_array('simulation', $_REQUEST['game']) ? 'checked' : ''; ?>>
						<label for="simulation">Simulation</label><br>
					</div>
					<div class="form-row" id="r7">
						<p>Favourite day of the week?</p>
						<select id="weekday" name="weekday">
							<option value="">--Please select an option!--</option>
							<option value="Monday" <?php echo ($_REQUEST['weekday'] == 'Monday') ? 'selected' : ''; ?>>Monday</option>
							<option value="Tuesday" <?php echo ($_REQUEST['weekday'] == 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
							<option value="Wednesday" <?php echo ($_REQUEST['weekday'] == 'Wednesday') ? 'selected' : ''; ?>>Wednesday</option>
							<option value="Thursday" <?php echo ($_REQUEST['weekday'] == 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
							<option value="Friday" <?php echo ($_REQUEST['weekday'] == 'Friday') ? 'selected' : ''; ?>>Friday</option>
							<option value="Saturday" <?php echo ($_REQUEST['weekday'] == 'Saturday') ? 'selected' : ''; ?>>Saturday</option>
							<option value="Sunday" <?php echo ($_REQUEST['weekday'] == 'Sunday') ? 'selected' : ''; ?>>Sunday</option>
						</select>
					</div>
					<div class="form-row" id="r8">
						<button type="submit" name="submit_register" value="submitted">Register</button>
					</div>
				</form>
				<a href="index.php?back_to_login=true">Back to login</a>

				<?php 
				if (!empty($errors)) {
					echo("<br><h3>Errors on submission form:</h3>");
					echo(view_errors($errors)); 
				}
				?>
			</section>
		</main>
		<footer>
			A project by ME
		</footer>
	</body>
</html>

