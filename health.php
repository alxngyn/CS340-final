<?php include("static/header.php"); ?>

<div class="container">
  <h2>Health Benefits</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Related Recipes</th>
      </tr>
    </thead>
    <tbody>
<?php
    require_once('dbConVars.php');

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
	$sql = 'SELECT food_health.id, 
			food_health.name AS health_name, 
			food_recipes.name AS recipe_name, 
			food_health.description AS description
			FROM food_health
			LEFT JOIN food_recipe_healths ON food_health.id = food_recipe_healths.h_id
			LEFT JOIN food_recipes ON food_recipe_healths.r_id = food_recipes.id
			';
	
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row into a bootstrap table
        while($row = $result->fetch_assoc()) {
            echo "<tr>" ;
            echo "<td>" . $row["health_name"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
			echo "<td>" . $row["recipe_name"] . "</td>";
            echo "</tr>";
        }

    } else {
        echo "<h2>0 results</h2>";
    }

    $conn->close();
?>
</tbody>
</table>
<a href="createHealth.php">
    <h4>Add to our list</h4>
</a>
<a href="create_recipe_health.php">
    <h4>Add a health benefit to a recipe</h4>
</a>

</div>

<?php include("static/footer.php"); ?>

