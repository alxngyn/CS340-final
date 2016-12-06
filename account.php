<?php include("static/header.php"); ?>

<?php
	require_once('dbConVars.php');
	// if SESSION is not set let the user know
	if(!isset($_SESSION['valid_user'])){
		echo "<h2>Please login first before continuing</h2>";
	}
	// otherwise show them the account page
	else{
		echo "<div class='container'>";
		echo "<h3>Saved Recipes</h3>";

		echo "<table class='table table-striped'>
						<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>Link to Recipe</th>
								<th>Remove from List</th>
							</tr>
						</thead>
						<tbody>";

		$name = $_SESSION['valid_user'];
		$mail = $_SESSION['email'];

		$servername = $DB_HOST;
		$username = $DB_USER;
		$password = $DB_PASSWORD;
		$dbname = $DB_NAME;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$sql = 'SELECT fr.id, fr.name, fr.description, fr.recipes_link FROM food_user_recipes fur JOIN food_recipes fr ON fur.r_id=fr.id WHERE fur.u_id=(SELECT id FROM food_users WHERE username="'. $name .'" AND email="'. $mail .'")';

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
			// for each row show the name, description, and a recipe link with a button to delete the recipe from the user.
		    while($row = $result->fetch_assoc()) {
		    	echo "<tr>
						<td>" . $row['name'] . "</td>
						<td>" . $row['description'] . "</td>
						<td><a href='" . $row['recipes_link'] . "'>Link</a></td>
						<td>
							<form action='userDeleteRecipe.php' method='POST'>
								<input type='hidden' name='recipe_id' value='" . $row['id'] . "'>";

				echo "<input type='submit' value='Remove'>";			
				echo	"</form></td>";
				echo "</tr>";
		    }
		}


		$conn->close();
		?>

		</tbody>
		</table>
		</div>

		<?php
	}
	
?>

<?php include("static/footer.php"); ?>
