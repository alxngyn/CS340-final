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

    $sql = "SELECT id, name, USDA_link FROM food_ingredients";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row into a bootstrap table
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td><a href='" . $row["USDA_link"] . "' >" . "link" . "</a>" .  "</td>";
            echo $result["id"];

            $sql2 = "SELECT DISTINCT food_recipes.name from food_ingredients "
                . "INNER JOIN food_recipe_ingredients "
                . "ON food_ingredients.id=food_recipe_ingredients.i_id "
                . "INNER JOIN food_recipes "
                . "on food_recipe_ingredients.r_id=food_recipes.id "
                . "where food_ingredients.id=" . $row["id"] ;
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0){
                while($row = $results2->fetch_assoc()){
                    echo "<td>" . $row["food_recipes.name"] . "</td>";
                }
            }

            echo "</tr>";
        }

    } else {
        echo "<h2>0 results</h2>";
    }

    $conn->close();
?>
</tbody>
</table>
</div>

<?php include("static/footer.php"); ?>
