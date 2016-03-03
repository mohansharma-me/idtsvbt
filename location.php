<?php include_once "import.php"; ?><html>
<head>
	<title>How to reach ? - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<div class="sidebar-left">
			<div class="sidebar-left">
				<h4>Address :-</h4><hr/>
				<div class="msgs" style="height:auto;overflow:auto">
					<?php
					include_once 'settings.php';
					$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
					mysql_select_db("idtsvbt_db_faculty");
					$latest_news=mysql_query("select * from clgprofile where id='1'");
					$row=mysql_fetch_assoc($latest_news);
					echo "<ul>";
						echo ucwords($row["address"]);
					echo "</ul><br/>";
					echo "<div><b>Email Address :-</b><hr/>&nbsp;&nbsp;&nbsp;".$row["email"]."</div><br/>";
					echo "<div><b>Phone Number :-</b><hr/>&nbsp;&nbsp;&nbsp;".$row["phone"]."</div><br/>";
					echo "<div><b>Fax Number :-</b><hr/>&nbsp;&nbsp;&nbsp;".$row["fax"]."</div><br/>";
					?>
				</div>
			</div>
			<div class="sidebar-right" style="text-align:left">
				<center><h2>How to reach ?</h2></center><br/>
				<p><img src="img/gujarat.gif" style="width:320px;height:240px;vertical-align:top;float:left;margin-right:12px"/>C. U. SHAH TECHNICAL INSTITUTE OF DIPLOMA STUDIES  is located at Wadhwan City, Taluka Head Quarter at about 6 Km, from Surendranagar and is situated on scenic banks of the river Bhogava on Ahmedabad-Viramgam-Surendranagar State Highway.
				Wadhwan is well connected to Ahmedabad & Rajkot by road and rail. It is situated on State Highway No. SH17.<br/></p>
				<br/><br/><p><b>By Roadways</b><br/>
				There are frequent bus services to this place from the main bus terminal of Ahmedabad (Geeta Mandir, Paldi, Nehrunagar) and Rajkot frequency of buses is approx. 30-45 minutes.
				Travelling from Ahmedabad, Wadhwan is located approximately 120 kilometers. Take the highway NH-8A near Sarkhej Cross road, and it tarns to SH17 near Viramgam, Onward is Lakhtar & Wadhwan.</p>
				<p><b>By Railways</b><br/>
				There are several trains servicing Surendranagar daily from various cities around. The major daily trains are, Saurashtra Mail, Saurashtra Janta,Saurashtra Exp., Bhavanagar Exp., Surat-Jamnagar InterCity, Ahmedabad-Veraval InterCity, Jabalpur Exp.etc.</p><br/>
				<p><b>Road map to college :-</b><br/>
				<img src="img/map.gif"/>
			</div>
		</div>
		<div class="sidebar-right">
			<?php
			if(isset($_SESSION['logged'])) {
			?>
			<br/><center><h4>Welcome <?php echo $_SESSION['username']; ?>!!</h4>
			<br/><hr style="margin-bottom:3px"/><form action="accounts.php"><input type='hidden' name='logout' value="<?php echo session_id(); ?>" /><input type="submit" value="Logout"/></form>
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
