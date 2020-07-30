<?php
require_once('header.php');
require_once('clearTemp.php');
    $user_id = $_SESSION['user_id'];
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
				or die('Could not connect to db!');
	//Clear temp table
	if (isset($_GET['clearTemp']))
	{
		clearTemp($dbc, $user_id);
	}
	
	//set variables and populate temp_ingredients if here via link
	if (isset($_GET['recipe_name']) && isset($_GET['recipe_id']) && !isset($_GET['removed']))
	{
		$recipe_name = $_GET['recipe_name'];
		$recipe_id = $_GET['recipe_id'];

		//POPULATE temp_ingredients
		//get recipe's ingredients from recipe_ingredients
		$query = "SELECT i.ingredient_id, i.ingredient_name, u.unit_name, u.unit_id, ri.ingredient_quantity "
				. "FROM ingredients as i "
				. "JOIN recipe_ingredients as ri ON i.ingredient_id = ri.ingredient_id "
				. "JOIN units as u ON u.unit_id = ri.unit_id "
				. "JOIN recipes as r ON r.recipe_id = ri.recipe_id "
				. "WHERE ri.ingredient_id = i.ingredient_id "
				. "AND ri.recipe_id = $recipe_id "
				. "AND r.user_id = $user_id";

		$result = mysqli_query($dbc, $query)
				or die('could not get ingredients');
			
		while ($row = mysqli_fetch_array($result))
		{
			$ingredient_id = $row['ingredient_id'];
			$unit_id = $row['unit_id'];
			$ingredient_quantity = $row['ingredient_quantity'];
			$query = "INSERT INTO temp_ingredients (user_id, ingredient_id, unit_id, ingredient_quantity) "
					. "VALUES($user_id, $ingredient_id, $unit_id, $ingredient_quantity)";
			$insert_temp = mysqli_query($dbc, $query)
					or die('Could not insert into temp!');
		}
	}
	if (isset($_POST['recipe_name']))
	//set variables if form submitted
	{
		$recipe_name = $_POST['recipe_name'];
		$recipe_id = $_POST['recipe_id'];
	}
	else if (isset($_GET['recipe_name']))
	{
		$recipe_name = $_GET['recipe_name'];
		$recipe_id = $_GET['recipe_id'];
	}


	//If user chose to clear ingredients, call function to clear them
	if (isset($_POST['clear_table']))
	{
		clearTemp($dbc);
	}
    
    echo '<h2>New Version of ' . $recipe_name . '</h2>';
?>
		<!--INSERT INGREDIENT FORM-->
		<h3>Add Ingredient To Recipe</h3>
		<form action="<?php echo $_SERVER['PHP_SELF'] . '?recipe_id=' . $recipe_id;?>" method="post">
		<div class="form-group row">
<?php

//get list of existing ingredients
	echo'<label for="ingredients">Ingredients</label>';
	echo'<select class="form-control" name="ingId" id="ingredients">';

	$get_ings_query = "SELECT ingredient_id, ingredient_name FROM ingredients "
			. "WHERE user_id = $user_id";
	$ing_result = mysqli_query($dbc, $get_ings_query)
			or die('could not get ingredients from ingredients table');

	//loop through ingredients belonging to user and generate drop-down options
	while ($ing_rows = mysqli_fetch_array($ing_result))
	{
		echo'<option value="' . $ing_rows['ingredient_id'] . '">' . $ing_rows['ingredient_name'] . '</option>';
	}
	echo'</select>';

	
	//get list of existing units
	echo'<label for="units">Units</label>';
	echo'<select class="form-control" name="unitId" id="units">';

	$get_units_query = "SELECT unit_id, unit_name FROM units";
	$units_result = mysqli_query($dbc, $get_units_query)
			or die('could not get units from table');

	//loop through ingredients belonging to user and generate drop-down options
	while ($units_rows = mysqli_fetch_array($units_result))
	{
		echo'<option value="' . $units_rows['unit_id'] . '">' . $units_rows['unit_name'] . '</option>';
	}
	echo'</select>';

?>
		<label for="quantity">Quantity:</label>
		<input type="number"  class="form-control" step=".01" id="quantity" name="ingQty">

		<input type="hidden" name="recipe_name" value="<?php if(isset($_GET['recipe_name'])){echo $_GET['recipe_name'];}else{echo $_POST['recipe_name'];}?>">
		<input type="hidden" name="recipe_id" value="<?php if(isset($_GET['recipe_id'])){echo $_GET['recipe_id'];}else{echo $_POST['recipe_id'];}?>">

		<input type="submit" class="btn btn-success" name="ingredient_submit" value="Add Ingredient">
		</form>

        <!--START TABLE-->
        <table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">Ingredient Name</th>
				<th scope="col">Quantity</th>
				<th scope="col">Unit of Measurement</th>
				<th scope="col">REMOVE</th>
			</tr>
		</thead>
		<tbody>


<?php
	//CHECKS FOR SUBMISSION OF NEW INGREDIENTS
    if (isset($_POST['ingredient_submit']))
    {
		$ingredient_id = $_POST['ingId'];
		$unit_id = $_POST['unitId'];
		$ingredient_qty = $_POST['ingQty'];

        $insert_ing_query = "INSERT INTO temp_ingredients (user_id, ingredient_id, unit_id, ingredient_quantity) "
                . "VALUES ($user_id, $ingredient_id, $unit_id, $ingredient_qty)";

        $insert = mysqli_query($dbc, $insert_ing_query)
                or die("Could not add ingredient to database");
	}
	$get_query = "SELECT ingredient_name as ingredient, i.ingredient_id, unit_name as unit, ingredient_quantity as quantity "
                . "FROM ingredients as i "
                . "JOIN temp_ingredients as t ON t.ingredient_id = i.ingredient_id "
                . "JOIN units as u ON u.unit_id = t.unit_id "
				. "WHERE t.ingredient_id = i.ingredient_id "
				. "AND t.user_id = $user_id";

	$get_rows = mysqli_query($dbc, $get_query)
			or die('Could not get ingredients from database');

	while ($row = mysqli_fetch_array($get_rows))
	{
		echo'<tr class="table-primary"><td>' . $row['ingredient'] . '</td><td>' . $row['quantity'] . '</td><td>' 
				. $row['unit'] . '</td><td><a href="removeIngredient.php?ingredient_id=' . $row['ingredient_id']
				. '&table=temp_ingredients&recipe_name=' . $recipe_name . '&recipe_id=' . $recipe_id 
				. '&page=addVersion' . '">X</a></td></tr>';
	}
?>
</tbody>
</table>

		<!--FORM BUTTON TO CLEAR ENTIRE TEMP INGREDIENT TABLE-->

		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

			<input type="hidden" name="recipe_name" value="<?php echo $recipe_name;?>">
			<input type="hidden" name="recipe_id" value="<?php echo $recipe_id?>">

			<input type="submit" class="btn btn-danger" name="clear_table" value="CLEAR ALL">
		</form>
		</br>
<?php
	//GET RECIPE PROCEDURE AND NOTES TO PRE-POPULATEEEEEEE

	if (isset($_GET['recipe_id']))
	{
		$get_procedure_query = "SELECT recipe_procedure, notes FROM recipes WHERE recipe_id = $recipe_id";
		$get_procedure = mysqli_query($dbc, $get_procedure_query)
				or die('Could not get procudure and notes');
		$result = mysqli_fetch_array($get_procedure);
		$procedure = $result['recipe_procedure'];
		$notes = $result['notes'];
	}
	else 
	{
		$procedure = '';
		$notes = '';
	}

?>

		<!--RECIPE DIRECTIONS-->
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

			<div class="form-group row">

			<label for="recipe_name">Recipe Name:</label>
			<input type="text" class="form-control" id="recipe_name" name="recipe_name" value="<?php echo $recipe_name;?>" disabled>
			</br>
			<label for="directions">Recipe Directions</label>
			</br>
			<textarea id="directions" class="form-control" rows="10" name="directions"><?php echo $procedure;?></textarea>
			</br>
			<label for="notes">Notes and Annotations</label>
			</br>
			<textarea id="notes" class="form-control" name="notes"><?php echo $notes;?></textarea>
			</br>

			<input type="hidden" name="recipe_name" value="<?php if(isset($_GET['recipe_name'])){echo $_GET['recipe_name'];}else{echo $_POST['recipe_name'];}?>">
			<input type="hidden" name="recipe_id" value="<?php if(isset($_GET['recipe_id'])){echo $_GET['recipe_id'];}else{echo $_POST['recipe_id'];}?>">

			<input type="submit" name="recipe_submit" value="SUBMIT RECIPE">
		</div>
		</form>

<?php

	if (isset($_POST['recipe_submit']))
	{
		$recipe_name = mysqli_real_escape_string($dbc, $_POST['recipe_name']);
		$recipe_procedure = mysqli_real_escape_string($dbc, $_POST['directions']);
		$recipe_notes = mysqli_real_escape_string($dbc, $_POST['notes']);

		//Add new recipe to Recipes table

		$insert_rec_query = "INSERT INTO recipes(user_id, time_posted, recipe_name, recipe_procedure, notes) "
				. "VALUES($user_id, NOW(), '$recipe_name', '$recipe_procedure', '$recipe_notes')";
		$insert_rec_results = mysqli_query($dbc, $insert_rec_query)
			or die('Could not add new recipe');

		//Transfer ingredients from temp_ingredients to recipe_ingredients
		$get_temp = "SELECT * FROM temp_ingredients WHERE user_id = $user_id";
		$get_temp_query = mysqli_query($dbc, $get_temp)
				or die('Could not get ingredients from temp table in transfer process');
		while($row = mysqli_fetch_array($get_temp_query))
		{
			$ingredient_id = $row['ingredient_id'];
			$unit_id = $row['unit_id'];
			$quantity = $row['ingredient_quantity'];

			//get new recipe id
			$get_recipe_query = "SELECT recipe_id, recipe_name, time_posted FROM recipes WHERE user_id = $user_id ORDER BY time_posted DESC LIMIT 1";
			$get_recipe_result = mysqli_query($dbc, $get_recipe_query)
					or die('Could not get recipe ID from recipes table');
			$recipe_row = mysqli_fetch_array($get_recipe_result);

			$recipe_id = $recipe_row['recipe_id'];
			$time_posted = $recipe_row['time_posted'];

			//insert all into recipe_ingredients
			$insert_rec_ing_query = "INSERT INTO recipe_ingredients(ingredient_id, recipe_id, unit_id, ingredient_quantity) "
					. "VALUES ($ingredient_id, $recipe_id, $unit_id, $quantity)";
			$insert_rec_ing_result = mysqli_query($dbc, $insert_rec_ing_query)
					or die('Could not add ingredients to recipe_ingredients table');
		}
		//Finally, delete everything from temp_ingredients
		clearTemp($dbc, $user_id);

		//Confirm Recipe Submission
		echo'<div class="alert alert-dismissible alert-success">';
		echo'<button type="button" class="close" data-dismiss="alert">&times;</button>';
		echo'<strong>Recipe Added!</strong>';
		echo'</br>';
		echo'<a class="alert-link" href="recipes.php">Back to Recipes</a>';
		echo'</br>';
		echo'<a class="alert-link" href="viewRecipe.php?recipe_id=' . $recipe_id . '&recipe_name=' . $recipe_name 
				. '&time_posted=' . $time_posted . '">View Recipe</a>';
		echo'</div>';
	}

require_once('footer.php');

?>
