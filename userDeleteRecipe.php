<?php
    session_start();
    include 'dbConVars.php';
    include('static/header.php');

    if(!isset($_SESSION['valid_user'])){
		echo "<h2>Please login first before continuing</h2>";
	}else{
		$username = $_SESSION['valid_user'];
		$email = $_SESSION['email'];
		$recipeID = $_POST['recipe_id'];


		$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		if(!conn){
			die("Database connection failure");
		}

		//first find user id
		$userQuery = 'SELECT id FROM food_users WHERE username="'.$username.'" AND email="'.$email.'"';

		//Now link recipe and user into food_user_recipes table
		$linkQuery = 'DELETE FROM food_user_recipes WHERE u_id=('. $userQuery .') AND r_id='. $recipeID; 

		$linkResult = mysqli_query($conn, $linkQuery);

		if($linkResult){
			echo "Successfully Deleted recipe!  Redirecting back to your account page.";
		}else{
			echo "ERROR!  Deleting recipe failed!  Redirecting back to your account page.";
		}	

		sleep(3);
		?>
		<script type="text/javascript">
			window.location = "account.php";
		</script> 

		<?php

		mysqli_free_result($linkResult);
		mysqli_close($conn);
	}	
?>