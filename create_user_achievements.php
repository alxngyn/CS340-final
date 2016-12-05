<?php include("static/header.php"); ?>


<div class="container">
<?php
	session_start();
	include 'dbConVars.php';

	// if POST exist, then procces it
	if ( (isset($_POST['userName'])) && (isset($_POST['achievement'])) ){

		// variables
		$user = $_POST['userName'];
		$achievement = $_POST['achievement'];

		// database connector
		$dbc = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		if (!$dbc) {
			die('Could not connect: ');
		}
		// sequel statement with query
		$sql = "SELECT * FROM food_user_achievements WHERE u_id=".$user." AND a_id=".$achievement;
		$data = mysqli_query($dbc, $sql);
		
		// if data does not exist, then add to the database, otherwise don't
		if(mysqli_num_rows($data) == 0){
			// insert into DN
			$query = "INSERT INTO food_user_achievements (u_id, a_id) VALUES(" . $user . "," . $achievement . ")";
			// if insert is successful, prompt so.
			if ( mysqli_query($dbc,$query) ) {
				echo "<p> Your new achievement has been tracked. </p>";
			}
			// otherwise print error
			else {
				echo '<p>Error, could not insert to database. Error:' . mysqli_error() .' </p>';	
			}	
		// if data exists print attempt error
		}else{
			echo '<p> Error, Your achievement has already been tracked. Please try another achievement. </p> ';
		}
		
		mysqli_close($dbc);
		
	}

?>
</div>

<?php
	// Connect to the database
    $dbc = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

	// if user is logged in then show them the form	
	if (isset($_SESSION['valid_user'])) {
		$username = $_SESSION['valid_user'];
		// since ID is not recorded in sessions, we will have to SELECT it from the DB
		$sql = "SELECT id FROM food_users WHERE username='$username'";
		$data = mysqli_query($dbc, $sql);
		// if found then set user_id to it
		if(mysqli_num_rows($data) ==  1){
			$row = mysqli_fetch_array($data);
			$user_id = $row["id"];	
		
			// show the form
			echo '
				<div class="container">
					<div class="col-md-4 col-md-offset-4 form-group">
						<form method="post" class="form-signin" name="form" action="'.  $_SERVER['PHP_SELF'] .'">
							<h2 class="form-signin-heading">Track an achievement</h2>

							Username:
							<label for="username" class="sr-only">Username</label>
							<select id="userName" name="userName" class="form-control">
								<option value="'. $user_id  .'">'. $username . '</option>
							</select>
							Achievement:
							<label for="achievement" class="sr-only">Achievement</label>
							<select id="achievement" class="form-control" name="achievement" > ';

			// select form the DB the possible achievements and iterate through them for options
			require_once('dbConVars.php');
			$sql = "SELECT id, name FROM food_achievements ";
			$data = mysqli_query($dbc, $sql);
			if(mysqli_num_rows($data) > 0){
				while($row = mysqli_fetch_assoc($data)){
					echo "<option value=" . $row["id"] .">". $row["name"]  ."</option>";
				}
			}
								
			// compelte and close the form
			echo'
							</select>						
				
							<button class="btn btn-lg btn-primary btn-block" onclick="">Track</button>
						</form>
					</div>
				</div>
            ';
		}else{
			echo "Error, user not found.";
		}
	}
	else {
		// user has not tried to login yet
		echo " <h2> You need to log in </h2> ";
    }
?>
<?php include("static/footer.php"); ?>
