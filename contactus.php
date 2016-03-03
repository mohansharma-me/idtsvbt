<?php include_once "import.php"; ?><html>
<head>
	<title>Contact us - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<center><h2>Contact us - C.U.Shah Diploma Campus :)</h2></center><br/>
		<center>
			<?php
				if(isset($_POST['tname']) && isset($_POST['tsubj']) && isset($_POST['tmsg'])) {
					$tname=$_POST['tname'];$tsubj=$_POST['tsubj'];$tmsg=$_POST['tmsg'];
                                        if(strlen($tname)!=0 && strlen($tsubj)!=0 && strlen($tmsg)!=0) {
                                            include_once 'settings.php';
                                            $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
                                            mysql_select_db("idtsvbt_db_faculty");
                                            $t=getdtime();
                                            echo "<b>";
                                            if(mysql_query("insert into contactus(tname,tsubj,tmsg,tdate) values('$tname','$tsubj','$tmsg','$t')")) {
                                                    echo "<font color='green'>".strtoupper($tname).", your message sucessfully sent to administrator!!</font>";
                                            } else {
                                                    echo "<font color='red'>Your message cant sent at this time please try again later!!<br>";
                                                    echo mysql_error()."</font>";
                                            }
                                            echo "</b>";
                                        } else {
                                            echo "<code><font color='red'><b>YOU HAVE TO FILL OUT ALL TEXTBOX TO CONTACT ADMINISTRATOR!!</b></font></code>";
                                        }
				} else {
			?>
			<form method="post">
			<table>
				<tr><td><label>Name:</label></td></tr>
				<tr><td><input type="text" name="tname" style="width:300px" /></td></tr>
				<tr><td><label>Subject:</label></td></tr>
				<tr><td><input type="text" name="tsubj" style="width:300px" /></td></tr>
				<tr><td><label>Message:</label></td></tr>
				<tr><td><textarea name="tmsg" style="width:300px;height:100px"></textarea></td></tr>
				<tr><td><input type="submit" value="Send" /></td></tr>
			</table>
			</form>
			<?php
				}
			?>
			<br/>
			This site is totally created/developed by Mohan Sharma and Anil Amlani (Students of C.E. Department)<br/>
            <br/><h3>Developer contact details :</h3><br/>
                <table>
                    <tr>
                        <td><label><b>Email Address:</b></label></td>
                        <td><label>iammegamohan@gmail.com , anil27927@gmail.com</label></td>
                    </tr>
                    <tr>
                        <td><label><b>Facebook id:</b></label></td>
                        <td><label><a href="http://www.facebook.com/iammegamohan">Mohan Sharma</a>,<a href="http://www.facebook.com/anil27927">Anil Amlani</a></label></td>
                    </tr>
                    
                </table>
		</center>		
	</div>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
