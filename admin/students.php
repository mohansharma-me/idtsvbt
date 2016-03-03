<br/><h3>Students</h3><br/>
<?php
if(isset($_GET['func'])) {
	$func=$_GET['func'];
	if($func=="add") {
		echo "<u><h5>Add student</h5></u>";
		if(isset($_POST['action'])) {
			echo "<br/>";
			if(carr($_POST)) {
				$nm=strtolower($_POST['nm']);$en=strtolower($_POST['en']);$do=strtolower($_POST['do']);$ge=strtolower($_POST['ge']);$em=strtolower($_POST['em']);
				$ad=strtolower($_POST['ad']);$co=strtolower($_POST['co']);$br=strtolower($_POST['br']);$se=strtolower($_POST['se']);
				$sp=strtolower($_POST['sp']);$cp=strtolower($_POST['cp']);
				mysql_select_db("idtsvbt_db_faculty");
				$img="./students/$en.jpg";
				move_uploaded_file($_FILES['img']['tmp_name'],$img);
				$ins=mysql_query("insert into profiles values(NULL,'$nm','$en','$do','$ge','$em','$ad','$co','$img','$br','$se','$sp','$cp')");
				if(cerr()) {
					echo "<div id='done'>Added successfully!!</div><br/>";
				} else {
					ms_err("1");
				}
			} else {
				echo "<div id='error'>You have to fill all the textbox(s) to add new student!!</div><br/>";
			}
		}
		?>
		<form method="post" style="text-align:left" enctype="multipart/form-data">
			<b>Name :-</b><br/><input type="text" name="nm" style="width:100%"/><br/>
			<b>Enrollment no :-</b><br/><input type="text" name="en" style="width:100%"/><br/>
			<b>Date of birth :-</b><br/><input type="text" name="do" style="width:100%"/><br/>
			<b>Gender :-</b><br/><select name="ge" style="width:100%"><option value="male">Male</option><option value="female">Female</option></select><br/>
			<b>Email address :-</b><br/><input type="text" name="em" style="width:100%"/><br/>
			<b>Address :-</b><br/><input type="text" name="ad" style="width:100%"/><br/>
			<b>Contact :-</b><br/><input type="text" name="co" style="width:100%"/><br/>
			<b>Photo :-</b><br/><input type="file" name="img" style="width:100%"/><br/>
			<b>Branch name :-</b><br/>
				<select name="br" style="width:100%">
				    <?php
				    mysql_select_db("idtsvbt_db_faculty");
				    $q=mysql_query("select distinct bname from branch");
				    if(cerr()) {
				        while(($row=mysql_fetch_array($q))) {
				            echo "<option value='$row[0]'>".ucwords($row[0])."</option>";
				        }
				    } else {
				        ms_err("1");
				    }
				    ?>
			</select><br/>
			<b>Semester :-</b><br/>
				<select name="se" style="width:100%">
				    <?php
				    for($i=1;$i<8;$i++) {
				        echo "<option value='$i'>$i semester</option>";
				    }
				    ?>
			</select><br/>
			<b>S.P.I. :-</b><br/><input type="text" name="sp" style="width:100%"/><br/>
			<b>C.P.I. :-</b><br/><input type="text" name="cp" style="width:100%"/><br/>
			<br/><input type="submit" name="action" value="Add" />
		</form>
		<?php
	} elseif($func=="edit") {
		if(isset($_POST['en'])) {
			$en=strtolower($_POST['en']);
			mysql_select_db("idtsvbt_db_faculty");
			$sea=mysql_query("select * from profiles where enrollno='$en'");
			if(cerr()) {
				if(mysql_affected_rows()==0) {
					echo "<div id='warning'>Sorry no student found!!</div><br/>";
				} else {
					if(isset($_POST['action'])) {
						if($_POST['action']=="Update") {
							$img="NULL";
							if(isset($_FILES['img']['tmp_name'])) {
								$img="./students/$en.jpg";
								move_uploaded_file($_FILES['img']['tmp_name'],$img);
							}
							if(carr($_POST)) {
								$nm=strtolower($_POST['nm']);$en=strtolower($_POST['en']);$do=strtolower($_POST['do']);$ge=strtolower($_POST['ge']);
								$ad=strtolower($_POST['ad']);$co=strtolower($_POST['co']);$br=strtolower($_POST['br']);$se=strtolower($_POST['se']);
								$sp=strtolower($_POST['sp']);$cp=strtolower($_POST['cp']);$em=strtolower($_POST['em']);$sid=strtolower($_POST['sid']);
								mysql_select_db("idtsvbt_db_faculty");
								$upd=mysql_query("update profiles set fname='$nm',enrollno='$en',dob='$do',gender='$ge',email='$em',address='$ad',contact='$co',branch='$br',sem='$se',spi='$sp',cpi='$cp' where id='$sid'");
								if(cerr()) {
									echo "<div id='done'>Updated successfully!!</div><br/>";
								} else {
									ms_err("1");
								}
							} else {
								echo "<div id='error'>You have to fill all the textbox(s) to update student!!</div>";
							}
						} else {
							if(isset($_POST['delete'])) {
								$sid=strtolower($_POST['en']);
								mysql_select_db("idtsvbt_db_faculty");
								$del=mysql_query("delete from profiles where enrollno='$sid'");
								if(cerr()) {
									echo "<div id='done'>Deleted successfully!!</div><br/>";
								} else {
									ms_err("1");
								}
							} else {
							?>
							<div id='error'><h3><div>Are you sure to delete student now ?</div></h3><br/>
								<center>
									<form name="dform" id="dform" method="post"><input type="hidden" name="en" value="<?=$en?>" /><input type="hidden" name="action" value="delete" /><input type="hidden" name="delete" value="yes" /></form>
									<div class="linkbox">
										<a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=students&func=edit">NO</a>
									</div>
								</center>
							</div>
							<?php
							}
						}
					} else {
					$row=mysql_fetch_row($sea);
					?>
					<form method="post" style="text-align:left" enctype="multipart/form-data">
						<input type="hidden" name="sid" value="<?=$row[0]?>" />
						<b>Name :-</b><br/><input type="text" name="nm" style="width:100%" value="<?=$row[1]?>"/><br/>
						<b>Enrollment no :-</b><br/><input type="text" name="en" style="width:100%" value="<?=$row[2]?>"/><br/>
						<b>Date of birth :-</b><br/><input type="text" name="do" style="width:100%" value="<?=$row[3]?>"/><br/>
						<b>Gender :-</b><br/><select name="ge" style="width:100%">
							<?php
								if($row[4]=="male") {
									echo "<option value='male' selected=selected>Male</option><option value='female'>Female</option>";
								} else {
									echo "<option value='male'>Male</option><option value='female' selected=selected>Female</option>";
								}
							?>
						</select><br/>
						<b>Email address :-</b><br/><input type="text" name="em" style="width:100%" value="<?=$row[5]?>"/><br/>
						<b>Address :-</b><br/><input type="text" name="ad" style="width:100%" value="<?=$row[6]?>"/><br/>
						<b>Contact :-</b><br/><input type="text" name="co" style="width:100%" value="<?=$row[7]?>"/><br/>
						<b>Photo :-</b><br/><img src="./students/<?=$en?>.jpg" style="width:160px;height:120px"/><br/><input type="file" name="img" style="width:100%"/><br/>
						<b>Branch name :-</b><br/>
							<select name="br" style="width:100%">
								<?php
								mysql_select_db("idtsvbt_db_faculty");
								$q=mysql_query("select distinct bname from branch");
								if(cerr()) {
									while(($rows=mysql_fetch_array($q))) {
										if($rows[0]==$row[9])
											echo "<option value='$rows[0]' selected=selected>".ucwords($rows[0])."</option>";
										echo "<option value='$rows[0]'>".ucwords($rows[0])."</option>";
									}
								} else {
									ms_err("1");
								}
								?>
						</select><br/>
						<b>Semester :-</b><br/>
							<select name="se" style="width:100%">
								<?php
								for($i=1;$i<8;$i++) {
									if($row[10]==$i)
										echo "<option value='$i' selected=selected>$i semester</option>";
									echo "<option value='$i'>$i semester</option>";
								}
								?>
						</select><br/>
						<b>S.P.I. :-</b><br/><input type="text" name="sp" style="width:100%" value="<?=$row[11]?>"/><br/>
						<b>C.P.I. :-</b><br/><input type="text" name="cp" style="width:100%" value="<?=$row[12]?>"/><br/>
						<br/><input type="submit" name="action" value="Update" /> <input type="submit" name="action" value="Delete" />
					</form>
					<?php
					}
				}
			} else {
				ms_err("1");
			}
		} else {
		?>
		<form style="text-align:left" method="post">
			<b>Enter enrollment no :-</b><br/><input type="text" name="en" style="width:100%" /><br/>
			<input type="submit" name="maction" value="Edit" />
		</form>
		<?php
		}
	}
}
?>
<br/><hr/><br/><div class="linkbox">
	<a href="?page=students&func=add">Add student</a>
	<a href="?page=students&func=edit">Edit/Delete student</a>
</div>
