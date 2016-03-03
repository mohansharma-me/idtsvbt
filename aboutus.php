<?php include_once "import.php"; ?>
<html>
<head>
	<title>About Us - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<center><h2>C.U.Shah Diploma Campus :)</h2></center><br/>
		
		<?php
			include_once 'settings.php';
			$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
			mysql_select_db("idtsvbt_db_faculty");
			$latest_news=mysql_query("select * from clgprofile order by id desc");
			while($row=mysql_fetch_array($latest_news)) {
				$desc=$row['descs'];$phone=$row['phone'];$fax=$row['fax'];$email=$row['email'];$address=$row['address'];
				break;
			}
		?>
		<?=ucwords($desc)?> <br /><br />
		<b>Phone :</b><?=$phone?> <br />
		<b>Fax:</b> <?=$fax?> <br />
		<b>E-mail</b> : <?=$email?> <br /> 
		<b>Address</b> : <?=$address?>
	</div>
	<?php include_once "bottombar.php"; ?>
</body>
</html>