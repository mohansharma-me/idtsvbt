<?php include_once "import.php"; ?><html>
<head>
	<title>About Institute - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<div class="sidebar-left">
			<div class="sidebar-left">
				<center><h4>Navigation</h4></center><hr/>
				<div class="msgs" style="overflow:inherit;height:auto">
					<li><a href="faculties.php">Faculties</a></li>
					<li><a href="gallery.php">Gallery</a></li>
					<li><a href="principal.php">Principal</a></li>
					<li><a href="mngtprofile.php">Management Profiles (Trusties)</a></li>
					<li><a href="location.php">How to reach ? (Location)</a></li>
					<li><a href="aboutus.php">About Us</a></li>
				</div>
			</div>
			<div class="sidebar-right">
				<br/><br/>
				<?php
					include_once 'settings.php';
					$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
					mysql_select_db("idtsvbt_db_faculty");
					$latest_news=mysql_query("select * from clgprofile order by id desc");
					while($row=mysql_fetch_array($latest_news)) {
						$img=$row['img'];$wmsg=$row['welcomemsg'];
						echo "<center><img src='$img' style='width:100%' /></center><br />";
						echo "$wmsg<br/><br/>";
						break;
					}
				?>
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
