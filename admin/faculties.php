<br/><h3>Faculties</h3><br/>
<?php
if(isset($_GET['func'])) {
	$func=$_GET['func'];
	if($func=="add") {
	echo "<u><h5>Add faculty</h5></u>";
	if(isset($_POST['action'])) {
		$img="NULL";$nm=strtolower($_POST['nm']);
		if($_FILES['img']['size']>0) {
			$img="./faculty/faculty_$nm.jpg";
			move_uploaded_file($_FILES['img']['tmp_name'],$img);
		}
		if(carr($_POST)) {
			$do=strtolower($_POST['do']);$qu=strtolower($_POST['qu']);$ex=strtolower($_POST['ex']);$de=strtolower($_POST['de']);
			$des=strtolower($_POST['des']);$su=strtolower($_POST['su']);$ad=strtolower($_POST['ad']);$co=strtolower($_POST['co']);
			$em=strtolower($_POST['em']);$ge=strtolower($_POST['ge']);
			mysql_select_db("idtsvbt_db_faculty");
            if($_FILES['img']['size']>0) {
                $ins=mysql_query("insert into faculties(fname,dob,qual,expe,depa,desg,subj,address,contact,email,img,gender) values('$nm','$do','$qu','$ex','$de','$des','$su','$ad','$co','$em','./faculty/faculty_$nm.jpg','$ge')");
            } else {
                $ins=mysql_query("insert into faculties(fname,dob,qual,expe,depa,desg,subj,address,contact,email,gender) values('$nm','$do','$qu','$ex','$de','$des','$su','$ad','$co','$em','$ge')");
            }			
			if(cerr()) {
				echo "<div id='done'>Added successfully!!</div><br/>";
			} else {
				ms_err("1");
			}
		} else {
			echo "<div id='error'>You have to fill all the textbox(s) to add faculty!!</div>";
		}
	}
	?>
	<form method="post" enctype="multipart/form-data" style="text-align:left">
		<b>Enter name :-</b><br/><input type="text" name="nm" style="width:100%" /><br/>
		<b>Date of birth :-</b><br/><input type="text" name="do" style="width:100%" /><br/>
		<b>Qualification :-</b><br/><input type="text" name="qu" style="width:100%" /><br/>
		<b>Experiance :-</b><br/><input type="text" name="ex" style="width:100%" /><br/>
		<b>Department/Branch :-</b><br/>
			<select name="de" style="width:100%">
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
			</select>
		<b>Desgination :-</b><br/><input type="text" name="des" style="width:100%" /><br/>
		<b>Subjects :-</b><br/><input type="text" name="su" style="width:100%" /><br/>
		<b>Address :-</b><br/><input type="text" name="ad" style="width:100%" /><br/>
		<b>Contact :-</b><br/><input type="text" name="co" style="width:100%" /><br/>
		<b>Email address :-</b><br/><input type="text" name="em" style="width:100%" /><br/>
		<b>Photo :-</b><br/><input type="file" name="img" style="width:100%" /><br/>
		<b>Gender :-</b><br/><select name="ge" style="width:100%"><option value="male">Male</option><option value="female">Female</option></select><br/>
		<input type="submit" name="action" value="ADD" />
	</form>
	<?php
	} elseif($func=="edit") {
		echo "<u><h5>Edit faculty</h5></u>";
		if(isset($_GET['id'])) {
			$id=$_GET['id'];
			mysql_select_db("idtsvbt_db_faculty");
			if(isset($_POST['action'])) {
				if($_POST['action']=="Update") {
					$img="NULL";$nm=strtolower($_POST['nm']);
					if($_FILES['img']['size']>0) {
						$img="./faculty/faculty_$nm.jpg";
						move_uploaded_file($_FILES['img']['tmp_name'],$img);
					}
					if(carr($_POST)) {
						$do=strtolower($_POST['do']);$qu=strtolower($_POST['qu']);$ex=strtolower($_POST['ex']);$de=strtolower($_POST['de']);
						$des=strtolower($_POST['des']);$su=strtolower($_POST['su']);$ad=strtolower($_POST['ad']);$co=strtolower($_POST['co']);
						$em=strtolower($_POST['em']);$ge=strtolower($_POST['ge']);
                        if($_FILES['img']['size']>0) {
                            $upd=mysql_query("update faculties set fname='$nm',dob='$do',qual='$qu',expe='$ex',desg='$des',depa='$de',subj='$su',address='$ad',contact='$co',email='$em',img='./faculty/faculty_$nm.jpg',gender='$ge' where id='$id'");
                        } else {
                            $upd=mysql_query("update faculties set fname='$nm',dob='$do',qual='$qu',expe='$ex',desg='$des',depa='$de',subj='$su',address='$ad',contact='$co',email='$em',gender='$ge' where id='$id'");
                        }
						if(cerr()) {
							echo "<div id='done'>Updated successfully!!</div><br/>";
						} else {
							ms_err("1");
						}
					} else {
						echo "<div id='error'>You have to fill all the textbox(s) to update faculty details!!</div><br/>";
					}
				} else {
					if(isset($_POST['delete'])) {
						$q=mysql_query("delete from faculties where id='$id'");
						if(cerr()) {
							echo "<div id='done'>Deleted successfully!!</div><br/>";
						} else {
							ms_err("1");
						}
					} else {
					?>
					<div id='error'><h3><div>Are you sure to delete faculty now ?</div></h3><br/>
						<center>
							<form name="dform" id="dform" method="post"><input type="hidden" name="action" value="delete" /><input type="hidden" name="delete" value="yes" /></form>
							<div class="linkbox">
								<a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=faculties&func=edit">NO</a>
							</div>
						</center>
					</div>
					<?php
					}
					
				}
			} else {
				$qu=mysql_query("select * from faculties where id='$id'");
				if(cerr()) {
					$row=mysql_fetch_row($qu);
					?>
					<form method="post" enctype="multipart/form-data" style="text-align:left">
						<b>Enter name :-</b><br/><input type="text" name="nm" style="width:100%" value="<?=$row[1]?>"/><br/>
						<b>Date of birth :-</b><br/><input type="text" name="do" style="width:100%" value="<?=$row[2]?>" /><br/>
						<b>Qualification :-</b><br/><input type="text" name="qu" style="width:100%" value="<?=$row[3]?>" /><br/>
						<b>Experiance :-</b><br/><input type="text" name="ex" style="width:100%" value="<?=$row[4]?>" /><br/>
						<b>Department/Branch :-</b><br/>
							<select name="de" style="width:100%">
									<?php
									mysql_select_db("idtsvbt_db_faculty");
									$q=mysql_query("select distinct bname from branch");
									if(cerr()) {
										while(($ro=mysql_fetch_array($q))) {
											if($row[5]==$ro[0])
												echo "<option value='$ro[0]' selected=selected>".ucwords($ro[0])."</option>";
											echo "<option value='$ro[0]'>".ucwords($ro[0])."</option>";
										}
									} else {
										ms_err("1");
									}
									?>
							</select>
						<b>Desgination :-</b><br/><input type="text" name="des" style="width:100%" value="<?=$row[6]?>"/><br/>
						<b>Subjects :-</b><br/><input type="text" name="su" style="width:100%" value="<?=$row[7]?>"/><br/>
						<b>Address :-</b><br/><input type="text" name="ad" style="width:100%" value="<?=$row[8]?>"/><br/>
						<b>Contact :-</b><br/><input type="text" name="co" style="width:100%" value="<?=$row[9]?>"/><br/>
						<b>Email address :-</b><br/><input type="text" name="em" style="width:100%" value="<?=$row[10]?>"/><br/>
						<b>Photo :-</b><br/><img src="<?=$row[11]?>" style="width:160px;height:120px"/><br/><input type="file" name="img" style="width:100%" /><br/>
						<b>Gender :-</b><br/><select name="ge" style="width:100%">
							<?php
							if($row[12]=="male") {
								echo "<option value='male' selected=selected>Male</option><option value='female'>Female</option>";
							} else {
							?>
							<option value="male">Male</option><option value="female" selected=selected>Female</option> <?php } ?>
						</select><br/>
						<input type="submit" name="action" value="Update" /> <input type="submit" name="action" value="Delete" />
					</form>
					<?php
				} else {
					ms_err("1");
				}
			}
		} else {
			echo "<table class='mytable' cellspacing='0'>";
				echo "<tr class='head'><td><b>Faculty name</b></td><td>Branch/Department</td></tr>";
				mysql_select_db("idtsvbt_db_faculty");
				$sea=mysql_query("select * from faculties");
				if(cerr()) {
					while(($row=mysql_fetch_row($sea))) {
						echo "<tr><td><a href='?page=faculties&func=edit&id=$row[0]'>".ucwords($row[1])."</a></td><td><a href='?page=faculties&func=edit&id=$row[0]'>".ucwords($row[5])."</a></td></tr>";
					}
				} else {
					ms_err("1");
				}
			echo "</table>";
		}
		
	}
}
?>
<br/><hr/><br/><div class="linkbox">
	<a href="?page=faculties&func=add">Add faculty</a>
	<a href="?page=faculties&func=edit">Edit/Delete faculty</a>
</div>
