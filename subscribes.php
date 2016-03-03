<?php include_once "import.php"; ?><html>
<head>
	<title>Subscribes - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<center><h2>Subscribes</h2></center><br/>
		<?php
		if(isset($_POST['email'])) {
			if(cvar($_POST['email'])) {
				if(is_mail($_POST['email'])) {
					include_once 'settings.php';
					$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
					mysql_select_db("idtsvbt_db_faculty");
					$search=mysql_query("select * from subscribers where lower(email)='".strtolower($_POST['email'])."'");
					if(cerr()) {
						if(mysql_affected_rows()==0) {
							$insert=mysql_query("insert into subscribers(email) value('".strtolower($_POST['email'])."')");
							if(cerr()) {
								echo "<center><div id='done'>Congratulation, your email(".strtoupper($_POST['email']).") is subscribed now.<br>now you have all latest new on your mail-box<br>Thank you</div></center>";
							} else {
								ms_err("1");
							}
						} else {
							echo "<center><div id='error'>Sorry this email address is already registered!</div></center>";
						}
					} else {
                                            ms_err("2");
                                        }
				} else {
					echo "<center><div id='error'>Please enter correct email address..</div></center>";
				}
			} else {
				echo "<center><div id='error'>Please enter correct email address..</div></center>";
			}
		}
		?><br/>
		<center>
		<form method="post">
			Email address:
			<input type="text" name="email" style="width:300px"/>
			<input type="submit" value="Subscribes now" />
		</form>
		<br/>You can register your email address to get our news-letter in your mail-box, every latest news will ne sent to your registered email address....
		</center>
	</div>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
