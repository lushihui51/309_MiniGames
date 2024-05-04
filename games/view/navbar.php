<?php $activePage = (isset($activePage)) ? $activePage : ''; ?>

<nav>
    <form method="post">
        <ul>
            
            <li> <button type="submit" name="nav_directed_state" value="stats" class="<?php echo $activePage == 'stats' ? 'active' : ''; ?>">All Stats</button></li>
            
            <li> <button type="submit" name="nav_directed_state" value="guessGamePlay" class="<?php echo $activePage == 'guessGame' ? 'active' : ''; ?>">Guess Game</button></li>

            <li> <button type="submit" name="nav_directed_state" value="rockPaperScissorsPlay" class="<?php echo $activePage == 'rockPaperScissors' ? 'active' : ''; ?>">Rock Paper Scissors</button></li>

            <li> <button type="submit" name="nav_directed_state" value="frogsGamePlay" class="<?php echo $activePage == 'frogs' ? 'active' : ''; ?>">Frogs</button></li>
           
            <li> <button type="submit" name="nav_directed_state" value="profile" class="<?php echo $activePage == 'profile' ? 'active' : ''; ?>">Profile</button></li>

            <li> <button type="submit" name="nav_directed_state" value="logout">Logout</button></li>

        </ul>
    </form>
</nav>

<?php $activePage = ''; ?>