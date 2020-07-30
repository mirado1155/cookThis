<?php
	require_once('header.php');
	$user_id = $_SESSION['user_id'];
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Could not connect to db!');

?>

		<!--INSERT INGREDIENT FORM-->
        </br>
		<h3>Add Ingredient</h3>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="form-group">

        <label for="name">Name of Ingredient:</label>
        <input type="text" class="form-control" name="name" id="name" autofocus>

        <input type="submit" class="btn btn-success" name="submit" value="Add Ingredient">

<?php

    //Add ingredient
    if (isset($_POST['submit']))
    {
        $name = mysqli_real_escape_string($dbc, $_POST['name']);
        $add_ing_query = "INSERT INTO ingredients (ingredient_name, user_id) VALUES('$name', $user_id)";
	    $add_ing_result = mysqli_query($dbc, $add_ing_query)
			    or die('could not add ingredients to ingredients table');
    }

    //get all existing ingredients
    $get_ing_query = "SELECT ingredient_name, ingredient_id FROM ingredients WHERE user_id = $user_id ORDER BY ingredient_name asc";
    $get_ing_result = mysqli_query($dbc, $get_ing_query)
            or die('Could not get list of ingredients');


?>

        <!--List OF EXISTING INGREDIENTS-->
        <h3>Your Ingredients</h3>
        <ul class="list-group">

<?php 

    while($row = mysqli_fetch_array($get_ing_result))
    {
        $ing_name = $row['ingredient_name'];
        $id = $row['ingredient_id'];
        echo '<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">' . $ing_name 
                . ' <a href="removeIngredient.php?ingredient_id=' . $id . '"><span class="badge badge-primary badge-pill">X</a></li>';
    }
    echo'</ul>';
require_once('footer.php');
?>
