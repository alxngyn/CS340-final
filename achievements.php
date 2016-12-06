<?php include("static/header.php"); ?>

<div class="container">
  <h2>Achievements</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Users Completed</th>
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
	// select achievement, and username from the relationship table with proper names.
	$sql = '
			SELECT food_achievements.id, food_achievements.name AS achievement_name, food_users.username AS user_name, food_achievements.description AS description
			FROM food_achievements
			LEFT JOIN food_user_achievements ON food_achievements.id = food_user_achievements.a_id
			LEFT JOIN food_users ON food_user_achievements.u_id = food_users.id
			';
	
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row into a bootstrap table
        while($row = $result->fetch_assoc()) {
            echo "<tr>" ;
            echo "<td>" . $row["achievement_name"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
			echo "<td>" . $row["user_name"] . "</td>";
            echo "</tr>";
        }

    } else {
        echo "<h2>0 results</h2>";
    }

    $conn->close();
?>
</tbody>
</table>
<a href="createAchievements.php">
    <h4>Add a new achievement</h4>
</a>
<a href="create_user_achievements.php">
	<h4>Track your own achievements</h4>
</a>

</div>

<?php include("static/footer.php"); ?>
