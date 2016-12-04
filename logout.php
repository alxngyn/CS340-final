<?php
	session_start();
	$old_user = $_SESSION['valid_user'];
	unset($_SESSION['valid_user']);
	session_destroy();
?>

<?php include("static/header.php"); ?>
    <div class="col-md-2 col-md-offset-5">
    <h1> Log Out Page</h1>
<?php
	if (!empty($old_user)) {
		echo '<p>User: ' . $old_user . ' is logged out.</p>';
	} else {
		echo '<p>You were not logged in!</p>';
	}
?>
    </div>

<?php include("static/footer.php"); ?>