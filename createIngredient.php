<?php include("static/header.php"); ?>

<?php
  require_once('dbConVars.php');
  // Connect to the database
  $dbc = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

  if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
    $usda_link = mysqli_real_escape_string($dbc, trim($_POST['usda_link']));

    if (!empty($name) && !empty($usda_link)) {
      $query = "SELECT * FROM food_ingredients WHERE name = '$name'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        $query = "INSERT INTO food_ingredients (name, USDA_link) VALUES ('$name', '$usda_link')";
        if( mysqli_query($dbc, $query) ){
            // Confirm success with the user
            echo '<p>Your new ingredient has been successfully created.</p>';
            echo "<h4><a href='ingredients.php' > Return </a></h4>";
        } else {
            echo '<p>Error, could not insert to database. Error:' . mysqli_error() .' </p>';
        }

        mysqli_close($dbc);
        exit();
      }
      else {
        echo '<p class="error">An ingredient already exists. Please use a different name.</p>';
        $userName = "";
      }
    }
    else {
      echo '<p class="error">You must enter all information required.</p>';
    }
  }

  mysqli_close($dbc);
?>

    <div class="container">
        <div class="col-lg-4 col-lg-offset-4 form-group">
            <form method="post" class="form-signin" name="form" onsubmit="return validate(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h2 class="form-signup-heading">Add a new ingredient</h2>

                <label for="name" class="sr-only">Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Ingredient name" required autofocus>

                <label for="usda_link" class="sr-only">Nutritional info link</label>
                <input type="text" id="usda_link" name="usda_link" class="form-control" placeholder="Nutritional info link" required>

                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Create</button>

            </form>
            <script type="text/javascript" src="js/signup.js"></script>
        </div>
    </div>

<?php include("static/footer.php"); ?>
