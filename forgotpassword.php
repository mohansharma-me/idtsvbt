<?php include_once "import.php"; ?><html>
<head>
	<title>Forgot Password - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<center><h2>Forgot password</h2></center><br/>
		<?php
		if(isset($_POST['email'])) {
			if(cvar($_POST['email'])) {
				if(is_mail($_POST['email'])) {
					$send="";$aid="";
					$flag=false;
					include_once 'settings.php';
					$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
					mysql_select_db("idtsvbt_db_faculty");
					$fsearch=mysql_query("select email,acc_id from faculty where lower(email)='".strtolower($_POST['email'])."'");
                                        if(cerr()) {
                                            if(mysql_affected_rows()==0) {
                                                $ssearch=mysql_query("select email,acc_id from student where lower(email)='".strtolower($_POST['email'])."'");
                                                if(cerr()) {
                                                    if(mysql_affected_rows()==0) {
                                                        $psearch=mysql_query("select email,acc_id from parents where lower(email)='".strtolower($_POST['email'])."'");
                                                        if(cerr()) {
                                                            if(mysql_affected_rows()==0) {
                                                                echo "<center><h4 id='error'>Sorry this email address is not registered!</h4></center>";
                                                            } else {
                                                                $row=mysql_fetch_array($psearch);
                                                                $send=$row[0];$aid=$row[1];
                                                                $flag=true;
                                                            }
                                                        } else {ms_err("3");}
                                                    } else {
                                                        $row=mysql_fetch_array($ssearch);
                                                        $send=$row[0];$aid=$row[1];
                                                        $flag=true;
                                                    }
                                                } else {ms_err("2");}
                                            } else {
                                                $row=mysql_fetch_array($fsearch);
                                                $send=$row[0];$aid=$row[1];
                                                $flag=true;
                                            }
                                        } else {ms_err("1");}
					
				} else {
					echo "<center><div id='error'>Please enter correct email address..</div></center>";
				}
                                if($flag==true) {
                                    $getpass=mysql_query("select password,username from login where lower(id)='$aid'");
                                    if(cerr()) {
                                        $row=mysql_fetch_row($getpass);
                                        $pass=$row[0];
                                        $user=$row[1];
                                        $message="Username:$user <br/>Password: $pass <br/>Take care of your of password..<br/>&copy;CUSHAH";
                                        if(mail($send, "Your forgotton password! -- CUSHAH", "$message")) {
                                            echo "<center><h4 id='done' style='width:80%'>Congratulation your password was sent to your email address!</h4></center>";
                                        } else {
                                            echo "<center><h4 id='error' style='width:80%'>Sorry we cant sent you password at this time, try again after sometime.</h4></center>";
                                        }
                                    } else {ms_err("1");}
                                } else {
                                    echo "<center><a href='javascript:history.back(0)'><< Go back and try again</a></center>";
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
			<input type="submit" value="Get It >>"
		</form>
		<br/>Kindly enter your registered email address for getting password copy into your mail-box ....
		</center>
	</div>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
