<?php
    require_once('header.php');
    $user_id = $_SESSION['user_id'];
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Could not connect to db!');

    $recipe_id = $_GET['recipe_id'];
    $recipe_name = $_GET['recipe_name'];
    $time_posted = $_GET['time_posted'];

    //get ingredients, units, and qty for this unique recipe
    $query = "SELECT i.ingredient_name, u.unit_name, ri.ingredient_quantity, r.time_posted "
            . "FROM ingredients as i "
            . "JOIN recipe_ingredients as ri ON i.ingredient_id = ri.ingredient_id "
            . "JOIN units as u ON u.unit_id = ri.unit_id "
            . "JOIN recipes as r ON r.recipe_id = ri.recipe_id "
            . "WHERE ri.ingredient_id = i.ingredient_id "
            . "AND ri.recipe_id = $recipe_id "
            . "AND r.user_id = $user_id";

    $result = mysqli_query($dbc, $query)
            or die('Could not query database');

    echo'<h2>"' . $recipe_name . '" Posted at: ' . $time_posted . '</h2>';
    echo'<table class="table table-hover"><tr><th>Ingredient</th><th>Unit</th><th>Quantity</th></tr>';

    //generate table of ingredients
    while($row = mysqli_fetch_array($result))
    {
        $ingredient_name = $row['ingredient_name'];
        $unit_name = $row['unit_name'];
        $ingredient_quantity = $row['ingredient_quantity'];
        echo "<tr><td>$ingredient_name</td><td>$unit_name</td><td>$ingredient_quantity</td></tr>";
    }
    echo'</table>';


    $get_recipe_query = "SELECT recipe_procedure, notes "
        . "FROM recipes "
        . "WHERE recipe_id = " . $recipe_id;

    $recipe_results = mysqli_query($dbc, $get_recipe_query)
            or die('Could not get recipe info');

    while($row = mysqli_fetch_array($recipe_results))
    {
        echo'<h3>Recipe Procedure:</h3>';
        echo'<blockquote class="blockquote">' . $row['recipe_procedure'] . '</blockquote>';
        echo'<h3>Additional Notes:</h3>';
        echo'<blockquote class="blockquote">' . $row['notes'] . '</blockquote>';
    }

    echo'<a href="viewVersions.php?recipe_name=' . $recipe_name . '">Versions</a></br>';
    echo'<a href="recipes.php">Back to Recipes</a>';

    require_once('footer.php');
    

?>