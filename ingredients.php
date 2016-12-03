<?php include("static/header.php"); ?>

<div class="container">
  <h2>Ingredients</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>USDA_link</th>
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

$sql = "SELECT name, USDA_link FROM food_ingredients";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row into a bootstrap table
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td><a href='" . $row["USDA_link"] . "' >" . $row["USDA_link"] . "</a>" .  "</td>";
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
