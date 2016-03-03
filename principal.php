<?php include_once "import.php"; ?>
<html>
<head>
	<title>Principal - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<center><h2>Principal details</h2></center><br/>
		<br/><br/><br/>
		<table style='margin-left:10%'>
		<?php
			include_once 'settings.php';
			$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
			mysql_select_db("idtsvbt_db_faculty");
			$latest_news=mysql_query("select * from principal order by id desc");
			
			while($row=mysql_fetch_array($latest_news)) {
				echo "<td><img src='principal.jpg' style='width:240px'/></td>";
				echo "<td style='padding-left:20px'>";
					echo "<b>Name :-</b> ".$row[1]."<br/><br/>";
					echo "<b>Date of birth :-</b> ".$row[2]."<br/><br/>";
					echo "<b>Qualification :-</b> ".$row[3]."<br/><br/>";
					echo "<b>Experiance :-</b> ".$row[4]."<br/><br/>";
					echo "<b>Department :-</b> ".$row[5]."<br/><br/>";
					echo "<b>Subjects :-</b> ".$row[6]."<br/><br/>";
					echo "<b>Address :-</b> ".$row[7]."<br/><br/>";
					echo "<b>Contact :-</b> ".$row[8]."<br/><br/>";
					echo "<b>Email address :-</b> ".$row[9]."<br/><br/>";
					echo "<b>During :-</b> ".$row[11]."<br/><br/>";
					
				echo "</td>";
				break;
			}
		?>
		</table>
	</div>
	<?php include_once "bottombar.php"; ?>
</body>
</html>