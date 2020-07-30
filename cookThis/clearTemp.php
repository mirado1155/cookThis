<?php
	//Function clears temp_ingredients table when called
	function clearTemp($dbc, $user_id)
	{
		$clear_query = "DELETE FROM temp_ingredients WHERE user_id = $user_id";
		$clear_result = mysqli_query($dbc, $clear_query)
				or die('Could not clear temp table');
	}
?>