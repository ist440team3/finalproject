<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../");
    exit;
}

// Include config file
require_once "../config.php";

// Check if user has admin privledge to view page
checkPrivledge($_SESSION["id"], $_SESSION["username"]);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IST 440W - Team 3 Project - Deactivate Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="../bin/css.css">
	<script src="../bin/jquery-3.5.1.min.js"></script>
	<script>
		function deactiveThisUser(id)
			{
			jQuery.ajax({
			type: "POST",
			url: "deactivate-user-ss-script.php",
			data: 'id='+id,
			cache: false,
			success: function(data){
				location.reload();
				}
			});
		}
	</script>
</head>
<body>
	<div class="logo-wrapper"><img src="../bin/logo.png"></img></div>
	<?php buildNav($_SESSION["id"], $_SESSION["username"]); ?>
	<div class="body-wrapper">
		<div class="page-header">
			<h1>Deactivate User Account</h1>
		</div>
		<p>
		Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
		</p>

		<p>
		
		<?php
		// Set the SQL Query
		$sql = "SELECT id, username, type, is_active FROM psu440users WHERE is_active='1'";
		$result = $link->query($sql);
		
		if ($result->num_rows > 0) {
			echo "<table class='users-table'><tr class='users-table-header'><th>ID</th><th>Username</th><th>Account Type</th><th>Account Status</th><th> </th></tr>";
				// output data of each row
					while($row = $result->fetch_assoc()) {
						echo "<tr class='users-table-entry'><td>".$row["id"]."</td><td>".$row["username"]."</td><td>";
						if ($row["type"]=="1"){echo "Administrative User";} else { echo "Standard User";}
						echo "</td><td>";
						if ($row["is_active"]=="1"){echo "Enabled";} else { echo "Deactivated";}
						echo "</td><td>";
						echo "<center><button type='submit' class='btn btn-danger btn-half-line-height' onclick='deactiveThisUser(".$row["id"].");' id='deactivateButton".$row["id"]."'>Deactivate User</button></center>";
						echo "</td></tr>";
						}
					echo "</table>";
					} else {
					echo "0 results";
						}
		$link->close();
		?>
		
		</p>
		<p>
			<a href="../" class="btn btn-warning">Return Home</a>
		</p>
	</div>
</body>
</html>