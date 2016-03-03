<br/><h3>Permission</h3><br/>
<?php
if(isset($_GET['permission'])) {
	if($_GET['permission']=="grant") {
		if(isset($_POST['action'])) {
			if(carr($_POST)) {
				$username=strtolower($_POST['unm']);
				$data="";
				for($i=1;$i<=22;$i++) {
					if(strlen($data)==0) {
						if(isset($_POST["chk".$i])) {
							$data="1";
						} else {
							$data="0";
						}
					} else {
						if(isset($_POST["chk".$i])) {
							$data.="1";
						} else {
							$data.="0";
						}
					}
				}
				include_once 'settings.php';
				$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
				mysql_select_db("idtsvbt_db_faculty");
				$search=mysql_query("select * from permission where username='$username'");
				if(mysql_affected_rows()>0) {
					echo "<div id='error'>This user already have on old grant permission, you can update it by visiting update page!!</div><br/>";
				} else {
					$ins=mysql_query("insert into permission(username,permission) values('$username','$data')");
					if(cerr()) {
						echo "<div id='done'>Granted!!</div><br/>";
					} else {
						ms_err("1");echo mysql_error();
					}
				}
			} else {
				echo "<div id='error'>You have to enter a perfect username for granting an module to him!!</div><br/>";
			}
		} else {
		?>
		<form method="post" style="width:100%;text-align:left">
			<table>
			<?php
				
				echo "<tr><td style='text-align:right'>Faculty :- </td><td>";
				echo "<select name='unm' style='width:600px'>";
					mysql_select_db("idtsvbt_db_faculty");
					$getfac_user=mysql_query("select f.fname,f.acc_id,f.desg,l.username from faculty as f,login as l where l.id=f.acc_id");
					if(cerr()) {
						while(($row=mysql_fetch_array($getfac_user))) {
							echo "<option value='$row[3]'>".ucwords($row[0])." (".(strtoupper($row[2])).")</option>";
						}
					} else {
						ms_err("1");
					}
				echo "</select>";
				echo "</td></tr>";
			?>
			</table>
			<br/><b>Permissions :-</b><br/><br/>
			<div style="margin-left:20px;">
				<table>
					<tr><td style='text-align:right'><span>Students management :-</td><td><input type="checkbox" name="chk1"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Faculties management :-</td><td><input type="checkbox" name="chk2"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Results :-</td><td><input type="checkbox" name="chk3"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Circulars :-</td><td><input type="checkbox" name="chk4"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Downloads :-</td><td><input type="checkbox" name="chk5"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Notice Board :-</td><td><input type="checkbox" name="chk6"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Time Table :-</td><td><input type="checkbox" name="chk7"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Gallery :-</td><td><input type="checkbox" name="chk8"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Attendance :-</td><td><input type="checkbox" name="chk9"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Subscribes :-</td><td><input type="checkbox" name="chk10"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Accounts :-</td><td><input type="checkbox" name="chk11"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>College Profile :-</td><td><input type="checkbox" name="chk12"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Fees details :-</td><td><input type="checkbox" name="chk13"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Requests :-</td><td><input type="checkbox" name="chk14"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Branchs :-</td><td><input type="checkbox" name="chk15"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Contact us(Inbox) :-</td><td><input type="checkbox" name="chk16"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Latest news :-</td><td><input type="checkbox" name="chk17"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Pages :-</td><td><input type="checkbox" name="chk18"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Management profiles:-</td><td><input type="checkbox" name="chk19"/><br/></span></td></tr>
					<tr><td style='text-align:right'><span>Principal details :-</td><td><input type="checkbox" name="chk20" /><br/></span></td></tr>				
					<tr><td style='text-align:right'><span>Upload files :-</td><td><input type="checkbox" name="chk21" /><br/></span></td></tr>
                    <tr><td style='text-align:right'><span>Import data :-</td><td><input type="checkbox" name="chk22" /><br/></span></td></tr>
                    
				</table>
			</div><br/>
			<input type="submit" name="action" value="GRANT" />
		</form>
		<?php
		}
	} elseif($_GET['permission']=="update") {
		if(isset($_POST['action'])) {
			$action=$_POST['action'];
			$username=strtolower($_POST['unm']);
			include_once 'settings.php';
			$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
			mysql_select_db("idtsvbt_db_faculty");
			$se=mysql_query("select * from permission where username='$username'");
			if(cerr()) {
				if(mysql_affected_rows()==0) {
					echo "<div id='error'>This username doesnt have any permission yet, please grant this user from Grant page!!</div><br/>";
				} else {
					if(isset($_POST['action2'])) {
						$unm=strtolower($_POST['unm']);
						$data="";
						for($i=1;$i<=22;$i++) {
							if(strlen($data)==0) {
								if(isset($_POST["chk".$i])) {
									$data="1";
								} else {
									$data="0";
								}
							} else {
								if(isset($_POST["chk".$i])) {
									$data.="1";
								} else {
									$data.="0";
								}
							}
						}
						$upd=mysql_query("update permission set permission='$data' where username='$unm'");
						if(cerr()) {
							echo "<div id='done'>Updated!!</div><br/>";
						} else {
							ms_err("1");
						}
					} else {
						$row=mysql_fetch_row($se);
						echo "<form method='post' style='text-align:left;width:100%'>";
							echo "<b>Username :-</b> <span>$username</span><input type='hidden' name='unm' value='$username' /><br/>";
							echo "<br/><b>Permissions :-</b><br/><br/><div style='margin-left:20px;'><table>";
								$arr=array(1=>"Student management :-","Faculties management :-","Results :-","Circulars :-","Downloads :-","Notice Board :-","Time table :-","Gallery :-","Attendance :-","Subscribes :-","Accounts :-","College profile :-","Fees details :-","Requests :-","Branchs :-","Contact us (Inbox) :-","Latest news :-","Pages :-","Management profiles :-","Principal details :-","Upload files :-","Import data :-");
								for($i=1;$i<=22;$i++) {
									if($row[2][$i-1]=="0") {
										echo "<tr><td style='text-align:right'><span>$arr[$i]</span></td><td><input type='checkbox' name='chk$i'/></td></tr>";
									} else {
										echo "<tr><td style='text-align:right'><span>$arr[$i]</span></td><td><input type='checkbox' name='chk$i' checked=checked/></td></tr>";								
									}
								}
							echo "</table></div><br/>";
							echo "<input type='submit' name='action2' value='Update'><input type='hidden' name='action' value='Next >>' />";
						echo "</form>";
					}
				}
			} else {
				ms_err("1");
			}
		} else {
		?>
		<form method="post" style="text-align:left">
            <table>
			<?php
				
				echo "<tr><td style='text-align:right'>Faculty :- </td><td>";
				echo "<select name='unm' style='width:600px'>";
					mysql_select_db("idtsvbt_db_faculty");
					$getfac_user=mysql_query("select f.fname,f.acc_id,f.desg,l.username from faculty as f,login as l where l.id=f.acc_id");
					if(cerr()) {
						while(($row=mysql_fetch_array($getfac_user))) {
							echo "<option value='$row[3]'>".ucwords($row[0])." (".(strtoupper($row[2])).")</option>";
						}
					} else {
						ms_err("1");
					}
				echo "</select>";
				echo "</td></tr>";
			?>
			</table>
			
			<input type="Submit" value="Next >>" name="action"/>
		</form>
		<?php
		}
	} else {
		if(isset($_GET['action'])) {
			$u=strtolower($_GET['unm']);
			if(isset($_GET['ans'])) {
				include_once 'settings.php';
				$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
				mysql_select_db("idtsvbt_db_faculty");				
				$del=mysql_query("delete from permission where username='$u'");
				if(cerr()) {
					echo "<div id='done'>Revoked!!</div><br/>";
				} else {
					ms_err("1");
				}
			} else {
				echo "<div id='error'><h3>Are you sure to revoke all the permission from $u ?</h3><br/><div class='linkbox'><a href='?page=permission&permission=revoke&action=next&unm=$u&ans=yes'>YES</a> <a href='?page=permission&permission=revoke'>NO</a></div></div><br/>";
			}
		} else {
		?>
		<form method="get" style="text-align:left">
			<input type="hidden" name="page" value="permission" /><input type="hidden" name="permission" value="revoke" />
			<b>Enter username of faculty to update :-</b><br/><input type="text" name="unm" style="width:100%" /><br/>
			<input type="Submit" value="Next >>" name="action"/>
		</form>
		<?php
		}
	}
}
?>
<br/><div class="linkbox">
	<a href="?page=permission&permission=grant">Grant</a>
	<a href="?page=permission&permission=update">Update</a>
	<a href="?page=permission&permission=revoke">Revoke All</a>
</div>