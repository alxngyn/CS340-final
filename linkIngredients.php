<?php
	session_start();
    include('static/header.php');
    include 'dbConVars.php';

    if(!isset($_SESSION['valid_user'])){
		echo "<h2>Please login first before continuing</h2>";
	}else{
		$recipeID = $_POST['recipe_id'];

		echo "<div class='container'>";
		echo "<h2>Add Ingredients to Recipe:  ". $_POST['recipe_name'] ."</h2>";

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

	    //find all names of ingredients 
	    $sql = "SELECT id, name FROM food_ingredients";
	    $res = $conn->query($sql);

	    if($res->num_rows > 0){
	    	echo "<form action='linkIngredientsAction.php' method='POST'>";
	    	echo "<select name='ingredients_selected[]' multiple style='width: 400px; display: block' size='30'>";

	    	while($row = $res->fetch_assoc()){
	    		echo "<option value='". $row['id'] ."'>". $row['name'] ."</option>";
	    	}

	    	echo "</select>";
	    	echo "<input type='hidden' name='recipe_id' value='" . $recipeID ."'>";
	    	echo "<input type='submit' value='Update Ingredients'>";
	    	echo "</form>";
	    }

	    ?>
	    </div>

	   <?php include("static/footer.php");
	}
?>