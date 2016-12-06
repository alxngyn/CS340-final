<?php include("static/header.php"); ?>

<div class="container">
  <h2>Ingredients</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>USDA_link</th>
        <th>Recipes</th>
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
	// select all ingredients and relating recipes
	$sql = "SELECT food_ingredients.name as ingredient, food_ingredients.USDA_link as link, food_recipes.name from food_ingredients "
                . "LEFT JOIN food_recipe_ingredients "
                . "ON food_ingredients.id=food_recipe_ingredients.i_id "
                . "LEFT JOIN food_recipes "
                . "on food_recipe_ingredients.r_id=food_recipes.id ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row into a bootstrap table
        while($row = $result->fetch_assoc()) {
            echo "<tr>" ;
            echo "<td>" . $row["ingredient"] . "</td>";
            echo "<td><a href='" . $row["link"] . "' >" . "link" . "</a>" .  "</td>";
			echo "<td>" . $row["name"] . "</td>";
            echo "</tr>";
        }

    } else {
        echo "<h2>0 results</h2>";
    }

    $conn->close();
?>
</tbody>
</table>
<a href="createIngredient.php">
    <h4>Add to our list</h4>
</a>
</div>

<?php include("static/footer.php"); ?>
