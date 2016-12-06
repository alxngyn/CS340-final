<?php
	include 'dbConVars.php';
	// check post 
	if ( (isset($_POST['username'])) && (isset($_POST['password'])) ){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$dbc = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		if (!$dbc) {
			die('Could not connect: ');
		}

		// sha password
		// $password = sha1($password);

		// run query to check
		$query = "SELECT * FROM food_users WHERE username='$username' and password='$password'";
		$result = mysqli_query($dbc, $query);
		if (mysqli_num_rows($result) == 1) {
		      // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
              $row = mysqli_fetch_array($result);
              session_start();

			  $_SESSION['email'] = $row['email'];
			  $_SESSION['valid_user'] = $row['username'];
              echo "<h5>Successfully logged in</h5>";
			}
		else {
          // The username/password are incorrect so set an error message
			  echo '<p class="danger">Sorry, you entered an invalid username or password. Please try again.</p>';
		}
		mysqli_free_result($result);
		mysqli_close($dbc);
	}
?>
