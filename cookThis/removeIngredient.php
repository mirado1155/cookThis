<?php
    require_once('header.php');
    $user_id = $_SESSION['user_id'];
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Could not connect to db!');

    $ingredient_id = $_GET['ingredient_id'];
    if (isset($_GET['recipe_name']))
    {
        $recipe_name = $_GET['recipe_name'];
        $recipe_id = $_GET['recipe_id'];
    }

    //Determine wherrrrrrrrre userrrrrr came from      , then dettttttttterminne whiiich table corresponds
    if (isset($_GET['table']))
    {
        $table = 'temp_ingredients';
        if ($_GET['page'] == 'addVersion')
        {
            $redirect = "addVersion.php?recipe_name=$recipe_name&recipe_id=$recipe_id&removed=true";
        }
        else if ($_GET['page'] == 'addRecipe')
        {
            $redirect = "addRecipe.php";
        }
    }
    else
    {
        $table = 'ingredients';
        $redirect = 'ingredients.php';
    }
    
    $query = "DELETE FROM $table WHERE ingredient_id = '$ingredient_id'";

    $query_exec = mysqli_query($dbc, $query)
        or die('Could not remove ingredient');

    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $redirect;
    header('location: ' . $url);
?>