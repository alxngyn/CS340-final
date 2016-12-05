<?php
	session_start();
    include('static/header.php');
    include 'dbConVars.php';

    if(!isset($_SESSION['valid_user'])){
		echo "<h2>Please login first before continuing</h2>";
	}else{
		$failure = false;
		$recipeID = $_POST['recipe_id'];
		$ingredients = $_POST['ingredients_selected'];

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

	    //array to store existing ingredient ids
	    $existingID = array();

	    //check all ingredient ids for the the recipe that exists in table
	    $sql = 'SELECT i_id FROM food_recipe_ingredients WHERE r_id='. $recipeID;
	    $result = $conn->query($sql);

	    if($result->num_rows > 0){
	    	while($row = $result->fetch_assoc()){
	    		$existingID[] = $row['i_id'];
	    	}	
	    }

	    //for all old ingredients, check against newly submitted list
	    foreach($existingID as $eID){
	    	if(!in_array($eID, $ingredients)){ //if not in new list, then remove from table
	    		$sql = 'DELETE FROM food_recipe_ingredients WHERE r_id='. $recipeID .' AND i_id='. $eID;

	    		$removeResult = $conn->query($sql);
	    	}
	    }

	    //take all new ingredients and overwrite old ingredients for recipe
	    foreach($ingredients as $in){
	    	if(in_array($in, $existingID)){
	    		continue; //skip insertion of this ingredient
	    	}

	    	$sql = 'INSERT INTO food_recipe_ingredients (r_id, i_id) VALUES ('. $recipeID .', '. $in .')';

	    	$res = $conn->query($sql);

	    	if(!$res){
	    		$failure = true;
	    	}
	    }

	    if($failure){
	    	echo "Insert Failed!";
	    }else{
	    	echo "Successfully updated!  Redirecting back to recipes page";
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