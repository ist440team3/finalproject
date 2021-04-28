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


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IST 440W - Team 3 Project - View Brute OCR Jobs Index</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="../bin/css.css">
</head>
<body>
	<div class="logo-wrapper"><img src="../bin/logo.png"></img></div>
	<?php buildNav($_SESSION["id"], $_SESSION["username"]); ?>
	<div class="body-wrapper">
		<div class="page-header">
			<h1>Brute OCR History</h1>
		</div>
		<p>
		This is an index of all historical Brute OCR jobs run by our application.  To view the job summary of a previously ran job, please click the "View Job" button next to the corresponding entry.  This will poll our backend database and reveal all properties associated with that Brute OCR job.
		</p>

		<p>
		
		<?php
		// Set the SQL Query
		//$sql = "SELECT job_id, usr_id, job_time_started FROM job";
		//SELECT title, publisher, genre, console_name FROM games INNER JOIN consoles ON games.console = consoles.c_id;
		$sql = "SELECT job_id, job_time_started, username FROM job INNER JOIN psu440users ON job.usr_id = psu440users.id";
		
		$result = $link->query($sql);
		
		if ($result->num_rows > 0) {
			echo "<table class='users-table'><tr class='users-table-header'><th>Job ID</th><th>User Who Performed Job</th><th>When Job Was Started</th><th> </th></tr>";
				// output data of each row
					while($row = $result->fetch_assoc()) {
						echo "<tr class='users-table-entry'><td>".$row["job_id"]."</td><td>".$row["username"]."</td><td>".$row["job_time_started"]."</td><td>";
						echo "<form method='post' action='../job_summary/index.php'><input type='hidden' name='jobToDisplay' value='".$row["job_id"]."'>";
						echo "<input type='submit' value='View Job' class='job-summary-button' /></form></td></tr>";
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