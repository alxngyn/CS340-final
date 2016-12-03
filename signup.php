<?php include("static/header.php"); ?>

<?php
  require_once('dbConVars.php');
  // Connect to the database
  $dbc = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $userName = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password']));
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));

    if (!empty($userName) && !empty($password1)) {
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM food_users WHERE userName = '$userName'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // sha1 the password
        $password1 = sha1($password1);
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO food_users (userName, password, email) VALUES ('$userName', '$password1', '$email')";
        if( mysqli_query($dbc, $query) ){
            // Confirm success with the user
            echo '<p>Your new account has been successfully created. You\'re now ready to log in.</p>';
        } else {
            echo '<p>Error, could not insert to database. Error:' . mysqli_error() .' </p>';
        }

        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
        echo '<p class="error">An account already exists for this username. Please use a different username.</p>';
        $userName = "";
      }
    }
    else {
      echo '<p class="error">You must enter all of the sign-up data.</p>';
    }
  }

  mysqli_close($dbc);
?>

    <div class="container">
        <div class="col-lg-4 col-lg-offset-4 form-group">
            <form method="post" class="form-signin" name="form" onsubmit="return validate(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h2 class="form-signup-heading">Sign up</h2>

                <label for="username" class="sr-only">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>

                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>

                <label for="email" class="sr-only">Email</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Email" required>

                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign up</button>

            </form>
            <script type="text/javascript" src="js/signup.js"></script>
        </div>
    </div>

<?php include("static/footer.php"); ?>
