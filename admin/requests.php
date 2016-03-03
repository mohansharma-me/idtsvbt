<br/><h3>Account requests</h3><br/>
<?php
if(isset($_GET['username']) && isset($_GET['type'])) {
	$username=strtolower($_GET['username']);$type=strtolower($_GET['type']);
	if(isset($_GET['do'])) {
		$do=strtolower($_GET['do']);
		if($do=="accept") {
			mysql_select_db("idtsvbt_db_faculty");
			$q=mysql_query("update login set status='1' where username='$username'");
			if(cerr()) {
				$q=mysql_query("delete from acc_request where username='$username'");
				if(cerr()) {
					echo "<div id='done'>Accepted!</div><br/>";
				} else {
					ms_err("2");
				}
			} else {
				ms_err("1");
			}
		} else {
			mysql_select_db("idtsvbt_db_faculty");
			$q=mysql_query("select id from login where username='$username'");
			$r=mysql_fetch_row($q);
			$q=mysql_query("delete from login where id='$r[0]'");
			if(cerr()) {
				$q=mysql_query("delete from acc_request where username='$username'");
				if(cerr()) {
					$q=mysql_query("delete from $type where acc_id='$r[0]'");
					if(cerr()) {
						echo "<div id='done'>Rejected!</div><br/>";
					} else {
						ms_err("3");
					}
				} else {
					ms_err("2");
				}
			} else {
				ms_err("1");
			}
		}
		echo "<br/><div class='linkbox'><a href='accounts.php?page=requests'>Go back</a></div>";
	} else {
		mysql_select_db("idtsvbt_db_faculty");
		$q=mysql_query("select * from login as l,$type as a where l.username='$username' AND l.id=a.acc_id");
		if(cerr()) {
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
			echo "<div class='linkbox'><a href='accounts.php?page=requests'><< Go Back</a><br/></div>";
		} else {
			ms_err("1");
		}
	}
} else {
?>
<table class="mytable" cellspacing="0">
	<tr class="head">
		<td>Username.</td><td>Account type.</td><td>Action.</td>
	</tr>
	<?php
	mysql_select_db("idtsvbt_db_faculty");
	$q=mysql_query("select * from acc_request");
	if(cerr()) {
		while(($row=mysql_fetch_array($q))) {
			echo "<tr><td><a href='accounts.php?page=requests&username=$row[1]&type=$row[2]'>".strtoupper($row[1])."</a></td><td><a href='accounts.php?page=requests&username=$row[1]&type=$row[2]'>".strtoupper($row[2])."</a></td><td><div class='linkbox'><a href='accounts.php?page=requests&username=$row[1]&do=accept&type=$row[2]'>Accept</a> <a href='accounts.php?page=requests&username=$row[1]&do=reject&type=$row[2]'>Reject</a></div></td></tr>";
		}
	} else {
		ms_err("1");
	}
	?>
</table>
<?php
}
?>
