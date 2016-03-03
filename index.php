<?php include_once "import.php"; ?><html>
<head>
	<title>Homepage - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<?php
	if(isset($_GET['pageid'])) {
		echo "<div class='content'>";
		include_once 'settings.php';
		$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
		$pageid=$_GET['pageid'];
		mysql_select_db("idtsvbt_db_faculty");
		$q=mysql_query("select * from pages where id='$pageid'");
		if(cerr()) {
			if(mysql_affected_rows()==0) {
				echo "<center><br/><div id='error'>Sorry no identified page found!!</div><br/></center>";
			} else {
				$row=mysql_fetch_row($q);
				$title=$row[1];$body=$row[2];$auth=$row[3];$desc=$row[4];$adder=$row[5];$flag=false;
				if($auth=="yes") {
					if(isset($_SESSION['logged']))
						$flag=true;
				} else {
					$flag=true;
				}
				if($flag) {
					echo "<center><u><h3>".ucwords($title)."</h3></u></center>";
					echo "<u><center>".ucwords($desc)."</center></u>";
					echo "<script>document.title='".ucwords($title)." - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity';</script>";
					echo "<br/>";
					echo ucwords($body)."<br/>";
					echo "<center>Page created by ".strtoupper($adder).".</center>";
				} else {
					echo "<center><br/><div id='warning'>You have to login first to open this page!!<br/><a href='accounts.php'><< Login here >></a></div><br/></center>";
				}
			}
		} else {
			ms_err("1");
		}
		echo "</div>";
	} else {
	?>
	<div class="content">
		<div class="sidebar-left">
			<div class="sidebar-left">
				<h4>Course Offered :-</h4><hr/>
				<div class="msgs" style="height:auto;overflow:auto">
					<?php
					include_once 'settings.php';
					$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
					mysql_select_db("idtsvbt_db_faculty");
					$latest_news=mysql_query("select * from branch");
					while($row=mysql_fetch_array($latest_news)) {
						echo "<li>".ucwords($row[1])."</li>";
					}
					?>
				</div><br/><br/>
				
				<center><h4>Hit Counter :- <span><?php echo file_get_contents("visits.txt")?></span></h4></center>
			</div>
			<div class="sidebar-right">
				<center><h2>C.U.Shah Diploma Campus :)</h2></center><br/>
				<?php
					include_once 'settings.php';
					$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
					mysql_select_db("idtsvbt_db_faculty");
					$latest_news=mysql_query("select * from clgprofile order by id desc");
					while($row=mysql_fetch_array($latest_news)) {
						$img=$row['img'];$wmsg=$row['welcomemsg'];
						echo "<center><img src='mbp.jpg' style='width:104%;height:304px'/></center><br />";
						echo "$wmsg<br/><br/>";
						break;
					}
				?>
				<br/>
				<div class="slider"><marquee direction="left" onmouseover="this.setAttribute('scrollamount', 0, 0);" onmouseout="this.setAttribute('scrollamount', 4, 0);">
				<?php
				include_once 'settings.php';
				$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
				mysql_select_db("idtsvbt_db_faculty");
				$search=mysql_query("select * from photos where public='y'");
				if(cerr()) {
					while(($row=mysql_fetch_array($search))) {
						echo "<a href='gallery.php?album=$row[3]&t=photos&id=$row[0]'><img title='$row[2]' src='$row[4]' /></a>";
					}
				} else {
					ms_err("1");
				}
				?>
				</marquee></div>		
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
		<div class="sidebar-right" style="margin-top:4px">
			<div class="msgs">
				&nbsp;&nbsp;&nbsp;<b>Latest news :-</b>
				<marquee direction='up' duration='100' scrollamount="3" onmouseover="this.setAttribute('scrollamount', 0, 0);" onmouseout="this.setAttribute('scrollamount', 4, 0);" style='height:350px'>
				<?php
					include_once 'settings.php';
					$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
					mysql_select_db("idtsvbt_db_faculty");
					$latest_news=mysql_query("select * from latest_news order by id desc");
					$i=0;
					while($row=mysql_fetch_array($latest_news)) {
						$ti=$row['title'];$hr=$row['link'];
						echo "<li><a href='$hr'>$ti</a></li>";
						$i++;
					}
					if($i==0) {
						echo "<center><b><font color='red'>No latest news updated!</font></b></center>";
					}
				?></marquee>
			</div>
		</div>
		<div style="clear:both"></div>
	</div>
	<div style="clear:both"></div>
	</div>
	<?php
	}
	?>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
