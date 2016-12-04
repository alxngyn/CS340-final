<?php include("static/header.php"); ?>

    <div class="container">

<?php
  require_once('dbConVars.php');
  // Connect to the database
  $dbc = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

  if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
    $description = mysqli_real_escape_string($dbc, trim($_POST['description']));

    if (!empty($name) && !empty($description)) {
      $query = "SELECT * FROM food_achievements WHERE name = '$name'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        $query = "INSERT INTO food_achievements (name, description) VALUES ('$name', '$description')";
        if( mysqli_query($dbc, $query) ){
            // Confirm success with the user
            echo '<p>Your new achievement has been successfully created.</p>';
            echo "<h4><a href='achievements.php' > Return </a></h4>";
        } else {
            echo '<p>Error, could not insert to database. Error:' . mysqli_error() .' </p>';
        }

        mysqli_close($dbc);
        exit();
      }
      else {
        echo '<p class="error">An achievement with that name already exists. Please use a different name.</p>';
        $userName = "";
      }
    }
    else {
      echo '<p class="error">You must enter all information required.</p>';
    }
  }

  mysqli_close($dbc);
?>
        <div class="col-lg-4 col-lg-offset-4 form-group">
            <form method="post" class="form-signin" name="form" onsubmit="return validate(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h2 class="form-signup-heading">Add a new achievement</h2>

                <label for="name" class="sr-only">Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Achievement name" required autofocus>

                <label for="description" class="sr-only">Description</label>
                <input type="text" id="description" name="description" class="form-control" placeholder="Description" required>

                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Create</button>

            </form>
        </div>
    </div>

<?php include("static/footer.php"); ?>

