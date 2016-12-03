<?php include("static/header.php"); ?>

<?php
require_once('dbConVars.php');

$servername = $DB_HOST;
$username = $DB_USER;
$password = $DB_PASSWORD;
$dbname = $DB_HOST;

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
    <div class="container">
      <h2>Striped Rows</h2>
      <p>The .table-striped class adds zebra-stripes to a table:</p>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>USDA_link</th>
          </tr>
        </thead>
        <tbody>
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["USDA_link"] . "</td>";
        echo "</tr>";
    }
        </tbody>
      </table>
    </div>
} else {
    echo "0 results";
}
$conn->close();
?>

<?php include("static/footer.php"); ?>
