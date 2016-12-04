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
		// $result = mysqli_query($conn, $userQuery);
		
		// if (mysqli_num_rows($result) > 0) {
		// 	$row = mysqli_fetch_array($result);
		// 	$userID = $row['id'];
		// }else{
		// 	echo "ERROR!  Failed querying user id";
		// }

		// mysqli_free_result($result);


		//Now link recipe and user into food_user_recipes table
		$linkQuery = 'INSERT INTO food_user_recipes (u_id, r_id) VALUES (('. $userQuery .'), '.$recipeID.')';
		$linkResult = mysqli_query($conn, $linkQuery);

		if($linkResult){
			echo "Successfully added recipe!  Redirecting back to recipes page.";
		}else{
			echo "ERROR!  Adding recipe failed!  Redirecting back to recipes page.";
		}	

		sleep(3);
		?>
		<script type="text/javascript">
			window.location = "recipes.php";
		</script> 

		<?php

		mysqli_free_result($linkResult);
		mysqli_close($conn);
	}	
?>