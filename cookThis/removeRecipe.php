<?php
require_once('header.php');
    $user_id = $_SESSION['user_id'];
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Could not connect to db!');

    if (isset($_GET['recipe_id']))
    {
        $id = $_GET['recipe_id'];
        $name = $_GET['recipe_name'];
        $query = "DELETE FROM recipes WHERE recipe_id = '$id'";
        $redirect = 'viewVersions.php?recipe_name=' . $name;
    }
    else
    {
        $name = $_GET['recipe_name'];
        $query = "DELETE FROM recipes WHERE recipe_name = '$name'";
        $redirect = 'recipes.php';
    }
    

    $delete = mysqli_query($dbc, $query)
        or die('Could not remove recipe and its versions');

    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $redirect;
    header('location: ' . $url);