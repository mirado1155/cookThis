<?php
    require_once('header.php');
    $user_id = $_SESSION['user_id'];
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Could not connect to db!');
    $recipe_name = $_GET['recipe_name'];

    $query = "SELECT * FROM recipes WHERE recipe_name = '$recipe_name' ORDER BY time_posted DESC";
    $result = mysqli_query($dbc, $query)
     or die('Could not get rows from database');

    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0)
    {
        //start list
        echo'<h2>Versions (Sorted most recent first)</h2>';
        echo'<ol class="list-group">';

        //generate list of versions with links to view and remove
        while ($row = mysqli_fetch_array($result))
        {
            $time_posted = $row['time_posted'];
            echo'<li  class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">' 
            . $row['recipe_name'] . ' <strong>created: ' . $row['time_posted'] 
            . '</strong><a href="viewRecipe.php?recipe_id=' . $row['recipe_id'] 
            . '&recipe_name='. $row['recipe_name'] . '&time_posted='
            . $row['time_posted'] . '">View Version</a> '
            . '<a href="removeRecipe.php?recipe_id=' . $row['recipe_id'] 
            . '&recipe_name=' . $row['recipe_name'] . '">Remove Version</a></li>';
        }
        echo'</ol>';
        echo'<a href="recipes.php">Back to Recipes</a>';
    }

    require_once('footer.php');


?>

 