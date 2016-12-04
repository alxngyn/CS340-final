<?php
    session_start();
    include 'dbConVars.php';
    include('static/header.php');

    if(!isset($_SESSION['valid_user'])){
		echo "<h2>Please login first before continuing</h2>";
	}else{
	//	echo "Queries here";	
	?>	

	<h3>Add Recipe</h3>
	<div>
		<form id="recipe_form" action="addRecipe.php" method="POST">
			<input type="text" name="recipe_name" placeholder="Recipe Name">
			<input type="text" name="recipe_des" placeholder="Description">
			<input type="text" name="recipe_link" placeholder="Link to Recipe">
			<input type="submit" value="Add Recipe">
		</form>
	</div>
	</br>

	<?php
		$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		if(!$conn){
			die("Database connection failure");
		}

		$query = "SELECT * FROM food_recipes";
		$result = mysqli_query($conn, $query);
		
		echo "<table>
					<thead>
						<tr>
							<th>Name</th>
							<th>Description</th>
							<th>Link to Recipe</th>
							<th>Add to List</th>
						</tr>
					</thead>
					<tbody>";

		while($row = mysqli_fetch_array($result)){
			$exists = false;
			$recipeID = $row['id'];

			//check if recipe is already added to users profile
			$checkQuery = 'SELECT * FROM food_user_recipes WHERE r_id="'. $recipeID .'" AND u_id=(SELECT fu.id FROM food_users fu WHERE username="'. $_SESSION['valid_user'] . '")';
			$checkResult = mysqli_query($conn, $checkQuery);
		
			//if more than one, then already exists in users saved list
			if(mysqli_num_rows($checkResult) > 0){ 
				$exists = true;
			}


			

			echo "<tr>
					<td>" . $row['name'] . "</td>
					<td>" . $row['description'] . "</td>
					<td><a href='" . $row['recipes_link'] . "'>Link</a></td>
					<td>
						<form action='userLinkRecipe.php' method='POST'>
							<input type='hidden' name='recipe_id' value='" . $recipeID . "'>";

			if($exists){
				echo "<input type='submit' value='Add' disabled>";
			}else{
				echo "<input type='submit' value='Add'>";
			}
		
			echo	"</form></td>";
			echo "</tr>";

		  	mysqli_free_result($checkResult);
		}

		echo "</tbody></table";


		
	}

	mysqli_free_result($result);
	mysqli_close($conn);
?>
