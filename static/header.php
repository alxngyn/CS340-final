<?php
    session_start();
    if( isset($_SESSION['valid_user']) ){
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
    }
?>

<!DOCTYPE html>

<!--
    Alex Nguyen
    Desmond Lau
    CS340 FALL 2015
    FINAL
-->
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <!-- Personal CSS-->
    <link rel="stylesheet" type="text/css" href="css/final.css">
    <title>
        CS340 Final Project
    </title>
</head>
<body>
    <div class="wrapper">
        <nav class="navbar">
            <div class="container">
                <ul class="nav nav-pills pull-left">
                    <li>
                        <a href="index.php">Food.DB</a>
                    </li>
                </ul>
                <ul class="nav nav-pills pull-right">
                    <?php
                        session_start();
                        if(isset($_SESSION['valid_user'])){
                            $userName = $_SESSION['valid_user'];
                            echo '
                                <li>
                                    <a id="username" href="account.php">' . $userName . '</a>
                                </li>
								<li>
									<a href="achievements.php">Achievements</a>
								</li>
								<li>
									<a href="health.php">Health</a>
								</li>
								<li>
									<a href="ingredients.php">Ingredients</a>
								</li>
								<li>
									<a href="recipes.php">Recipes</a>
								</li>
                                <li>
                                    <a href="logout.php">Logout</a>
                                </li>


                                ';
                        } else{
                            echo'
                                <li>
                                    <a href="login.php">Login</a>
                                </li>
                                <li>
                                    <a href="signup.php">Signup</a>
                                </li>
                                ';
                        }
                    ?>
                </ul>
            </div>
        </nav>
