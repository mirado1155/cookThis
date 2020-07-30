<?php
    require_once('header.php');
    if (isset($_SERVER['user_id']) && isset($_COOKIE['user_id']))
    {
        header('Location: recipes.php');
    }

    echo'<h2>Please log in to view recipes</h2>';

    echo'<form action="login.php" method="post">';

    echo'<div class="form-group">';

    echo'<label for="username">Username:</label>';
    echo'<input type="text" id="username" name="username"></br>';

    echo'<label for="password">Password:</label>';
    echo'<input type="password" id="password" name="password"></br>';

    echo'<button type="submit" class="btn btn-primary" name="submit">Log In</button>';

    echo'</div>';

    echo'</form>';

    echo'<p>Not a user yet? <a href="signup.php">Sign Up Here!</a></p>';

    require_once('footer.php');
?>
        

