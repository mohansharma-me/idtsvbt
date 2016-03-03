<?php include_once "import.php"; ?><html>
<head>
	<title>Management Profiles - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<div class="sidebar-left">
			
				<center><h2>Management Profiles</h2></center><br/><center>
				<div class="classic" style="margin-left:5%">
					<h3>-: <u>Trusties</u> :-</h3>
					<?php
					include_once 'settings.php';
					$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
					mysql_select_db("idtsvbt_db_faculty");
					$li=mysql_query("select * from mgntp where memtype='0'");
					$i=0;$cou=0;
					if(cerr()) {
						echo "<br/><br/><table class='myt'>";
						while(($row=mysql_fetch_array($li))) {
							if($cou==0) {
								echo "<tr>";
							}
							echo "<td><a href='#$row[0]'><img src='$row[4]'/><br/><br/><span>".ucwords($row[2]." ".$row[1])."</span><br/><span>".ucwords($row[3])."</span></a></td>";
							if($cou==2) {
								echo "</tr>";
								$cou=-1;
							}
							$i++;$cou++;
						}
						if($cou<2) {
							echo "</tr>";
						}
						echo "</table>";
					} else {
						ms_err("1");
					}
					if($i==0) {
						echo "<center><div id='warning'>Sorry there is no data for this page!!</div><br/></center>";
					}
					?>
				</div><div style="clear:both"></div><br/><br/>
				<div class="classic" style="margin-left:5%">
					<h3>-: <u>Member trusties</u> :-</h3>
					<?php
					include_once 'settings.php';
					$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
					mysql_select_db("idtsvbt_db_faculty");
					$li=mysql_query("select * from mgntp where memtype='1'");
					$i=0;$cou=0;
					if(cerr()) {
						echo "<br/><br/><table class='myt'>";
						while(($row=mysql_fetch_array($li))) {
							if($cou==0) {
								echo "<tr>";
							}
							echo "<td><a href='#$row[0]'><img src='$row[4]'/><br/><br/><span>".ucwords($row[2]." ".$row[1])."</span><br/><span>".ucwords($row[3])."</span></a></td>";
							if($cou==2) {
								echo "</tr>";
								$cou=-1;
							}
							$i++;$cou++;
						}
						if($cou<2) {
							echo "</tr>";
						}
						echo "</table>";
					} else {
						ms_err("1");
					}
					?>
				</div>

				
				</center>
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
