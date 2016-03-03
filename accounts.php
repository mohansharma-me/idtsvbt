<?php include_once "import.php"; ?><html>
<head>
	
        <title><?php if(isset($_SESSION['logged'])) {echo "My Accounts";} else { ?>Login to your account <?php } ?> - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
</head>
<body>
	<?php
            include_once "topbar.php";
            if(isset($_GET['logout'])) {
                include_once 'settings.php';
                $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
                mysql_select_db("idtsvbt_db_faculty");
                $deleteonline=mysql_query("delete from onlineuser where loginid='".$_SESSION['id']."'");
                session_unset();
                echo "<div class='content'><center>You have completely logged out!<br><a href='accounts.php'>Re-login now</a></center></div>";
				header("Location: ./index.php");
            } else {
            if(isset($_SESSION['logged'])) {
        ?>
        <div class="content"><center>
                <?php 
                    if($_SESSION['account']=="admin") {
                        include_once "admin_panel.php";
                    } elseif($_SESSION['account']=="student") {
                        include_once "student_panel.php";
                    } elseif($_SESSION['account']=="parents") {
                        include_once "parent_panel.php";
                    } elseif($_SESSION['account']=="faculty") {
                        include_once "faculty_panel.php";
                    } 
                ?>
        </center></div>
        <?php
            } else {
        ?>
	<div class="content">
		<center><h2>Login to your account</h2></center><br/>
		<center>
		<?php
			if(isset($_POST['username']) && isset($_POST['password'])) {
				$username=strtolower($_POST['username']);$password=strtolower($_POST['password']);
				include_once 'settings.php';
				$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
				mysql_select_db("idtsvbt_db_faculty");
                                if(substr($username,0,5)=="admin") {
                                    $username=trim(substr($username,6,strlen($username)));
                                    $search=mysql_query("select username,password from admin where username='$username' AND password='$password'");
                                    $row=mysql_fetch_row($search);
                                    if(isset($row[0])) {
                                        $_SESSION['logged']=true;
                                        $_SESSION['username']=$username;
                                        $_SESSION['account']="admin";
                                        $_SESSION['id']=session_id();
                                        $insert=mysql_query("insert into onlineuser(loginid,username) values('".$_SESSION['id']."','".$_SESSION['username']."')");
                                        echo "<body onload=\"document.location='accounts.php'\">";
                                        echo "<a href='accounts.php'><code><< If you are not redirected to the user page then please click here to visit user page >></code></a>";
                                    } else {
                                            echo "<code><font color='red'><b>USERNAME OR PASSWORD NOT MATCHED OR NOT FOUND!<BR>PLEASE TRY AGAIN TO ACCESS YOUR ACCOUNT!<BR><a href='accounts.php'>Login now</a></b></font></code>";
                                    }
                                } else {
                                    $search_user=mysql_query("select username,password,acc_type,status,acc_id,id from login where username='$username' AND password='$password'");
                                    $row=mysql_fetch_row($search_user);
                                    if($row[3]=="0") {
                                        echo "<div id='warning'><b><code>Welcome $row[0], your account details is not verifies by admin yet.<br/>so please wait until admin verifies your account details<br>thank you</code></b></div>";
                                    } else if($row[3]=="-1") {
                                        echo "<div id='error'><b><code>Welcome $row[0], your account details is rejected by admin.<br/>so you are not eligible as this account holder<br>thank you</code></b></div>";
                                    } else {
                                        if(isset($row[0])) {
                                            $_SESSION['logged']=true;
                                            $_SESSION['username']=$username;
                                            $_SESSION['account']=$row[2];
                                            $_SESSION['acc_id']=$row[5];
                                            $_SESSION['id']=session_id();
                                            $insert=mysql_query("insert into onlineuser(loginid,username) values('".$_SESSION['id']."','".$_SESSION['username']."')");
                                            echo "<body onload=\"document.location='accounts.php'\">";
                                            echo "<a href='accounts.php'><code><< If you are not redirected to the user page then please click here to visit user page >></code></a>";
                                        } else {
                                                echo "<code><font color='red'><b>USERNAME OR PASSWORD NOT MATCHED OR NOT FOUND!<BR>PLEASE TRY AGAIN TO ACCESS YOUR ACCOUNT!<BR><a href='accounts.php'>Login now</a></b></font></code>";
                                        }
                                    }
                                }
			} else {
		?>
		<form method="post">
		<table>
			<tr>
				<td>Username:</td>
			</tr>
			<tr>
				<td><input type="text" name="username" style="width:300px" /></td>
			</tr>
			<tr>
				<td>Password:</td>
			</tr>
			<tr>
				<td><input type="password" name="password" style="width:300px" /></td>
			</tr>
		</table><br/>
		<input type="submit" value="LOGIN >>" />
		</form>
		<form action="forgotpassword.php"><input type="submit" value="FORGOT PASSWORD >>" /></form>
		<form action="register.php"><input type="submit" value="CREATE NEW ACCOUNT >>" /></form>
		<?php
			}
		?>
		</center>
	</div>
        <?php
            }}
        ?>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
