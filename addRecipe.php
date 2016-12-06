<?php
	// check session, show site if they are logged in.
    session_start();
    include 'dbConVars.php';
    include('static/header.php');

    if(!isset($_SESSION['valid_user'])){
		echo "<h2>Please login first before continuing</h2>";
	}else{
		echo "<div class='container'>";

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
		// sanitize incoming data
		$recipeName = mysqli_real_escape_string($conn, $_POST['recipe_name']);
		$description = mysqli_real_escape_string($conn, $_POST['recipe_des']);
		$link = mysqli_real_escape_string($conn, $_POST['recipe_link']);

		// insert into the database the relationship
	    $sql = 'INSERT INTO food_recipes (name, description, recipes_link) VALUES ("' . $recipeName .'", "'. $description .'", "'. $link .'")';
	    $res = $conn->query($sql);

	    if($res){
	    	echo "Successfully added recipe!  Redirecting.";
	    }else{
	    	echo "Failed adding recipe.  Redirecting.";
	    }

	    sleep(3);
?>
	</div>
	<script type="text/javascript">
			window.location = "recipes.php";
		</script> 
	<?php include("static/footer.php");
	}	
?>


	
	
