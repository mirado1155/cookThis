<?php
    require_once('connectvars.php');
    require_once('header.php');

    //connect to db
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Could not connect to db!');

    //check if form is submitted
    if (isset($_POST['submit']))
    {
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
        $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

        //verify if form fields are filled out. If so, check whether or not username already exists.
        //If it does, return an error. If not, add user.
        if ((!empty($username) && !empty($password1) && !empty($password2))
                && ($password1 == $password2))
        {
            $query = "SELECT * FROM users WHERE username = '$username'";

            $data = mysqli_query($dbc, $query)
                    or die("Error checking database for unique username");

            if (mysqli_num_rows($data) == 0)
            {
                $query = "INSERT INTO users (username, password)"
                        . " VALUES('$username', SHA1('$password1'))";

                mysqli_query($dbc, $query)
                        or die("Error adding new user");

                echo '<p class="text-success">Your new account has been created! <a href="index.php">Log into your account!</a></p>';
            }
            else
            {
                echo '<p class="text-danger">An account with that username exists. Please try a different one</p>';
                $username = "";
            }
        }
        else
        {
            echo '<p class="text-danger">You must enter all signup data</p>';
        }

    }


    mysqli_close($dbc);
?>


<h2>Sign up to log your recipes!</h2>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

    <div class="form-group">
    <label for="username">Username: </label>
    <input type="text" id="username" name="username"
            value="<?php if (!empty($username)){echo($username);}?>"><br>
    
    <label for="password1">Password:</label>
    <input type="password" id="password1" name="password1"><br>

    <label for="password2">Please enter password again: </label>
    <input type="password" id="password2" name="password2"><br>

    <button type="submit" class="btn btn-primary" name="submit">Sign Up!</button>
    </div>
</form>
<p>Already registered?<a href="index.php">Log In Here!</a></p>

<?php
require_once('footer.php');
?>
