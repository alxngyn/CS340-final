<?php include("static/header.php"); ?>


<div class="container">
<?php
	session_start();
	include 'dbConVars.php';

	// if POST exist, then procces it
	if ( (isset($_POST['recipe'])) && (isset($_POST['health'])) ){

		// variables
		$recipe = $_POST['recipe'];
		$health = $_POST['health'];

		// database connector
		$dbc = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		if (!$dbc) {
			die('Could not connect: ');
		}
		// sequel statement with query
		$sql = "SELECT * FROM food_recipe_healths WHERE r_id=".$recipe." AND h_id=".$health;
		$data = mysqli_query($dbc, $sql);
		
		// if data does not exist, then add to the database, otherwise don't
		if(mysqli_num_rows($data) == 0){
			// insert into DN
			$query = "INSERT INTO food_recipe_healths (r_id, h_id) VALUES(" . $recipe . "," . $health . ")";
			// if insert is successful, prompt so.
			if ( mysqli_query($dbc,$query) ) {
				echo "<p> Your new health benefit has been recorded. </p>";
			}
			// otherwise print error
			else {
				echo '<p>Error, could not insert to database. Error:' . mysqli_error() .' </p>';	
			}	
		// if data exists print attempt error
		}else{
			echo '<p> Error, Your health benefit has already been related to a recipe. Please try another again. </p> ';
		}
		mysqli_close($dbc);
	}
?>
</div>

<?php
	// Connect to the database
	require_once('dbConVars.php');
    $dbc = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

	// if user is logged in then show them the form	
	if (isset($_SESSION['valid_user'])) {
				
		// show the form
		echo '
			<div class="container">
				<div class="col-md-4 col-md-offset-4 form-group">
					<form method="post" class="form-signin" name="form" action="'.  $_SERVER['PHP_SELF'] .'">
						<h2 class="form-signin-heading">Relate a health benefit to a recipe</h2>

						Health benefit:
						<label for="health" class="sr-only">Health benefit</label>
						<select id="health" name="health" class="form-control">';
		
		// select form the DB the possible options and iterate through them
		$sql = "SELECT id, name FROM food_health ";
		$data = mysqli_query($dbc, $sql);
		if(mysqli_num_rows($data) > 0){
			while($row = mysqli_fetch_assoc($data)){
				echo "<option value=" . $row["id"] .">". $row["name"]  ."</option>";
			}
		}				
						
		echo'
						</select>
						Recipe:
						<label for="recipe" class="sr-only">Achievement</label>
						<select id="recipe" class="form-control" name="recipe" > ';

		// select form the DB the possible recipess and iterate through them for options
		$sql = "SELECT id, name FROM food_recipes ";
		$data = mysqli_query($dbc, $sql);
		if(mysqli_num_rows($data) > 0){
			while($row = mysqli_fetch_assoc($data)){
				echo "<option value=" . $row["id"] .">". $row["name"]  ."</option>";
			}
		}
								
		// compelte and close the form
		echo'
						</select>						
				
						<button class="btn btn-lg btn-primary btn-block" onclick="">Record</button>
					</form>
				</div>
			</div>
           ';
		}else {
			// user has not tried to login yet
			echo " <h2> You need to log in </h2> ";
    	}
?>
<?php include("static/footer.php"); ?>
