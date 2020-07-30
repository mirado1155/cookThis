<?php
    if(isset($_POST['submit']))
    {
        require_once('connectvars.php');

        // Start the session
        session_start();

        // Clear the error message
        $error_msg = "";

        // If the user isn't logged in, try to log them in
        if (!isset($_SESSION['user_id'])) 
        {
            if (isset($_POST['submit'])) 
            {
                // Connect to the database
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                        or die('could not connect to databse');

                // Grab the user-entered log-in data
                $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
                $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

                if (!empty($username) && !empty($password)) 
                {
                    // Look up the username and password in the database
                    $query = "SELECT user_id, username FROM users WHERE username = '$username' AND password = SHA1('$password')";
                    $data = mysqli_query($dbc, $query)
                            or die('Could not get user info from database');

                    $num_rows = mysqli_num_rows($data);
                    if ($num_rows == 1) 
                    {
                        // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
                        $row = mysqli_fetch_array($data);
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['username'] = $row['username'];
                        setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));
                        setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));
                        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/recipes.php';
                        header('Location: ' . $home_url);
                    }
                    else 
                    {
                        // The username/password are incorrect so set an error message
                        echo'<p>Sorry, you must enter a valid username and password to log in.</p>';
                        echo'<a href="index.php">Back to login</a>';
                    }
                }
                else 
                {
                    // The username/password weren't entered so set an error message
                    echo'<p>Sorry, you must enter a valid username and password to log in.</p>';
                    echo'<a href="index.php">Back to login</a>';
                }
            }
        }
    }

    else
    {
        echo'<p>You must enter a username and password to log in!</p>';
    }
?>