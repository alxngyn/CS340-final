<?php
	session_start();
	include 'dbConVars.php';

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
			  $_SESSION['email'] = $row['email'];
			  $_SESSION['valid_user'] = $row['username'];
			}
		else {
          // The username/password are incorrect so set an error message
			echo "Sorry, you must enter a valid username and password to log in.";
		}
		mysqli_free_result($result);
		mysqli_close($dbc);
	}
?>

<?php include("static/header.php"); ?>
<?php
	if (isset($_SESSION['valid_user'])) {
        echo ' <div class=" col-md-2 col-md-offset-5 " >';
		echo " <h3> You are logged in as: " . $_SESSION['valid_user'] . "</h3>";
		echo " <p> <a href='logout.php'>Log out </a><br />";
        echo ' </div> ';
	}
	else {
		if (isset($username)) {
			// user tried but can't log in
			echo "<h2> Could not log you in </h2>";
		} else {
			// user has not tried
			// echo " <h2> You need to log in </h2> ";
		}
	    // Log in form
        echo '
            <div class="container">
                <div class="col-lg-4 col-lg-offset-4 form-group">
                        <h2 class="form-signin-heading">Please sign in</h2>
						<div id="ajaxResponse"></div>
                        <label for="inputUsername" class="sr-only">Username</label>
                        <input type="text" id="userName" name="userName" class="form-control" placeholder="Username" required autofocus>
                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                        <button class="btn btn-lg btn-primary btn-block" onclick="checkLogin()">Sign in</button>
                </div>
            </div>
            ';
    }
?>
<?php include("static/footer.php"); ?>
