<?php include("static/header.php"); ?>

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

$sql = "SELECT id, username, email FROM food_users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . " "  . $row["username"]. " " . $row["email"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<?php include("static/footer.php"); ?>
