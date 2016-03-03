<?php include_once "import.php"; ?><html>
<head>
	<title>Student Corner - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<div class="sidebar-left">
			<div class="sidebar-left">
				<center><h4>Navigation</h4></center><hr/>
				<div class="msgs" style="overflow:inherit;height:auto">
					<li><a href="students.php">Students</a></li>
					<li><a href="circular.php">Circulars</a></li>
					<li><a href="downloads.php">Downloads</a></li>
					<li><a href="noticeboard.php">Notice Board</a></li>
					<li><a href="timetable.php">Time Table</a></li>
					<li><a href="attendance.php">Attendance</a></li>
				</div>
			</div>
			<div class="sidebar-right"><CENTER>
				<img src="img/stdc.jpg" style="width:104%"/>
				<br/>
				<p>Welcome you all students, here you can see your attendance report, circulars, download assignments which submitted via faculties, and also see the student details..</p><br/>
				<p>You can see your branch's notice board</p>
				</CENTER>
			</div>
		</div>
		<div class="sidebar-right">
			<?php
			if(isset($_SESSION['logged'])) {
			?>
			<br/><center><h4>Welcome <?php echo $_SESSION['username']; ?>!!</h4>
			<br/><hr style="margin-bottom:5px" />
			<form action="accounts.php"><input type='hidden' name='logout' value="<?php echo session_id(); ?>" /><input type="submit" value="Logout"/></form>
			</center>
			<?php
			} else {
			?>
			&nbsp;&nbsp;<b>Login to your account:-</b><br/>
			<form method="post" action="accounts.php" style='margin-left:10px'>
				Username:<br/><input type="text" name="username" style='width:95%;border:1px solid black;-moz-border-radius:8px;border-radius:8px'/><br/>
				Password:<br/><input type="password" name="password"  style='width:95%;border:1px solid black;-moz-border-radius:8px;border-radius:8px'/><br/>
				<br/><center><input type="submit" value="Login >>"> <input type="button" onClick="document.fgp.submit()" value="Forgot Password" /></center>
			</form><form name="fgp" action="forgotpassword.php"></form><br/>
			<?php
			}	
			?>
		</div>
		<div style="clear:both"></div>
	</div>
	<div style="clear:both"></div>
	</div>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
