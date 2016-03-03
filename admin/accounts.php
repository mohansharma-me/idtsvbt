<br/><h3>Account details</h3><br/>
<?php
if(isset($_POST['action'])) {
	if(carr($_POST)) {
		$type=strtolower($_POST['at']);$username=strtolower($_POST['un']);
		mysql_select_db("idtsvbt_db_faculty");
		$q=mysql_query("select * from login as l,$type as a where l.username='$username' AND l.id=a.acc_id");
		if(cerr()) {
			if(mysql_affected_rows()==0) {
				echo "<div id='warning'>Sorry no user details found for your entered username!!</div></br>";
			} else {
				$row=mysql_fetch_row($q);
				echo "<table style='width:100%'>";
				echo "<tr><td style='width:25%;text-align:right'><b>Username :-</b></td><td>$row[2]</td></tr>";
				echo "<tr><td style='width:25%;text-align:right'><b>Password :-</b></td><td>$row[3]</td></tr>";
				echo "<tr><td style='width:25%;text-align:right'><b>Account type :-</b></td><td>$row[4]</td></tr>";
				echo "<tr><td style='width:25%;text-align:right'><b>Full name :-</b></td><td>$row[8]</td></tr>";
				if($type=="faculty") {
					echo "<tr><td style='width:25%;text-align:right'><b>Email address :-</b></td><td>$row[9]</td></tr>";
					echo "<tr><td style='width:25%;text-align:right'><b>Designation :-</b></td><td>$row[10]</td></tr>";
					echo "<tr><td style='width:25%;text-align:right'><b>Address :-</b></td><td>$row[11]</td></tr>";
					echo "<tr><td style='width:25%;text-align:right'><b>Mobile number :-</b></td><td>$row[12]</td></tr>";
				} else {
					echo "<tr><td style='width:25%;text-align:right'><b>Enrollment no :-</b></td><td>$row[9]</td></tr>";
					echo "<tr><td style='width:25%;text-align:right'><b>Email address :-</b></td><td>$row[10]</td></tr>";
					echo "<tr><td style='width:25%;text-align:right'><b>Branch name :-</b></td><td>$row[11]</td></tr>";
					echo "<tr><td style='width:25%;text-align:right'><b>Semester :-</b></td><td>$row[12]</td></tr>";
					if($type=="parents") {
						echo "<tr><td style='width:25%;text-align:right'><b>Qualification :-</b></td><td>$row[13]</td></tr>";
						echo "<tr><td style='width:25%;text-align:right'><b>Occupation :-</b></td><td>$row[14]</td></tr>";
						echo "<tr><td style='width:25%;text-align:right'><b>Address :-</b></td><td>$row[15]</td></tr>";
						echo "<tr><td style='width:25%;text-align:right'><b>Mobile number :-</b></td><td>$row[16]</td></tr>";
					}
				}		
				echo "</table><br/>";
			}
		} else {
			ms_err("1");
		}		
	} else {
		echo "<div id='error'>Please enter a username to get account details!!</div><br/>";
	}
	echo "<div class='linkbox'><a href='accounts.php?page=accounts'><< Go Back</a><br/></div>";
} else {
?>
<form method="post" style="text-align:left">
Enter username :-<br/><input type="text" name="un" style="width:100%" /><br/>
Select Account type :-<br/>
	<select name="at" style="width:100%">
		<option value="student">Student account</option>
		<option value="faculty">Faculty account</option>
		<option value="parents">Parents account</option>
	</select><br/>
<input type="submit" name="action" value="Search" />
</form>
<?php
}
?>
