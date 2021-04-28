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
    <title>IST 440W - Team 3 Project - About Project Team</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="../bin/css.css">
</head>
<body>
	<div class="logo-wrapper"><img src="../bin/logo.png"></img></div>
	<?php buildNav($_SESSION["id"], $_SESSION["username"]); ?>
	<div class="body-wrapper" id="member-top">
		<div class="page-header">
			<h1>About Our Project Team</h1>
		</div>
		<p>
		Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
		</p>
		<p><center>
			<a href="#member-dl">David Logan</a><b> // </b><a href="#member-hg">Hussein Ghaleb</a><b> // </b><a href="#member-sc">Susan Chin</a><b> // </b><a href="#member-tk">Travis Kraft</a>
	</div>
	<div class="body-wrapper" id="member-dl">
		<section class="about-team">
			<nav class="about-team">
				<img src='../bin/photo-dl.jpg'></img>
			</nav>
			<article class="about-team">
				<h2>David Logan</h2>
				<p>
					I’m a Navy vet and have traveled the world extensively both in the military and on my own. I love to travel and take off whenever I get the chance even if it’s just a day trip. I love adventure! I also love music and football. I have worked in IT for 30+ years spending six years in the Navy, fourteen years working at an Internet Service Provider (ISP) and the last ten years at a medical company managing the infrastructure of three data centers supporting over 45,000 users. I have had very interesting jobs and experienced a tremendous amount in the field of IT. I love what I do.
				</p>
				<p><a href="#member-top" class="back-to-top">Back to Top</a></p>
			</article>
		</section>
	</div>
	<div class="body-wrapper" id="member-hg">
		<section class="about-team">
			<nav class="about-team">
				<img src='../bin/photo-hg.jpg'></img>
			</nav>
			<article class="about-team">
				<h2>Hussein Ghaleb</h2>
				<p>
					I am originally from the Washington DC Metro area and have worked in IT for over 15 years in Northern Virginia’s Data Center Alley.  I currently work for the NIH within the National Cancer Institute as a data center manager in Bethesda, MD.  I am a “jack-of-all-trades” and typically wear many hats in the past 5 years of my career including data center management, operations, deployment, and consolidations to Linux systems administration to network operations and project management. 
					I am happily married to a beautiful wife and have an awesome daughter, she loves to chime in with her opinion from upstairs!  I look forward to building an awesome Capstone project with my team!
				</p>
				<p><a href="#member-top" class="back-to-top">Back to Top</a></p>
			</article>
		</section>
	</div>
	<div class="body-wrapper" id="member-sc">
		<section class="about-team">
			<nav class="about-team">
				<img src='../bin/photo-sc.jpg'></img>
			</nav>
			<article class="about-team">
				<h2>Susan Chin</h2>
				<p>
					Hi! My name is Susan Chin.  I am excited to be in IST 440W because it signals that I am getting closer to graduating. In my previous life, I worked in the retail sector.  The IST major has allowed me to expand my tech skills. I reside on the eastern seaboard. I have traveled to Dominican Republic, China, Hong Kong, England, France, and Canada. My favorite destination is Santa Monica, California. My hobby is dressing up my Rottweiler (hat and shoes included). I look forward to working with my group members and see the results of our labor.
				</p>
				<p><a href="#member-top" class="back-to-top">Back to Top</a></p>
			</article>
		</section>
	</div>
	<div class="body-wrapper" id="member-tk">
		<section class="about-team">
			<nav class="about-team">
				<img src='../bin/photo-tk.jpg'></img>
			</nav>
			<article class="about-team">
				<h2>Travis Kraft</h2>
				<p>
					My name is Travis Kraft and I am from the Lehigh Valley, PA. I enjoy hiking, camping, and fishing, and I am a big Philadelphia sports fan, specifically Flyers and Eagles (in that order!). I have visited Scotland and Hawaii as my big travel experiences and both were unforgettable. I can't wait until we're allowed to go places again. I have been taking classes through World Campus since 2016, originally 3-4 classes per semester but i dialed it back to 2 to give myself the time necessary to actually focus and gain something from it. I have a few GC and SoO credits remaining after this course and plan on pushing forward with my internship later this year.
				</p>
				<p><a href="#member-top" class="back-to-top">Back to Top</a></p>
			</article>
		</section>
	</div>
	<div class="body-wrapper body-bottom-margin">
		<p>
			 
		</p>
		<p>
			<a href="../home" class="btn btn-warning">Return Home</a>
		</p>
	</div>
	<p></p>
</body>
</html>