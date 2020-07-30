<?php
    require_once('header.php');
    require_once('connectvars.php');

    if (isset($_SESSION['user_id']) && isset($_COOKIE['user_id']))
    {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Could not connect to db!');

        $query = "SELECT recipe_id, recipe_name FROM recipes WHERE user_id = '" . $_SESSION['user_id'] . "' ORDER BY time_posted DESC";
        $data = mysqli_query($dbc, $query)
                or die('Could not query database');

        $num_rows = mysqli_num_rows($data);

        if ($num_rows == 0)
        {
            echo'<p>You don\'t seem to have any recipes yet. <a href="addRecipe.php">Add a new recipe.</a></p>';
        }

        else
        {
            echo'<h3>Your Recipes</h3>';
            echo'<table class="table table-hover">';
            echo'<thead><tr><th>Name</th><th>View</th><th>Add</th><th>Remove</th></tr></thead>';
            echo'<tbody>';

            //initialize array of names
            //unique recipe names must be filtered to avoid duplicates
            $names = array();
            
            while($row = mysqli_fetch_array($data))
            {
                $name = $row['recipe_name'];
                if (!in_array("$name", $names))
                {
                    echo'<tr><td>' . $row['recipe_name'] . '</td>'
                        . '<td><a href="viewVersions.php?recipe_name='. $row['recipe_name'] . '">View Versions'
                        . ' of ' . $row['recipe_name'] . '</a></td>'
                        . '<td><a href="addVersion.php?recipe_name=' . $name . '&recipe_id=' . $row['recipe_id'] 
                        . '&clearTemp=true' . '">Add New Version</a></td>'
                        . '<td> <a href="removeRecipe.php?recipe_name=' . $name . '">Remove Recipe and All Its Versions</a></td>'
                        . '</tr>';

                    array_push($names, $name);
                }  
            }
            
        }
        echo'</tbody>';
        echo'</table>';
    }
    else
    {
        echo'<p>You must be logged in to access this page!</p>';
    }

    require_once('footer.php');

?>