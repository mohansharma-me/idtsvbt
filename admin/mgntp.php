<br/><h3>Management Profiles</h3><br/>
<?php
if(isset($_GET['id'])) {
	$id=strtolower($_GET['id']);
	include_once 'settings.php';
	$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
	mysql_select_db("idtsvbt_db_faculty");
	if(isset($_POST['action'])) {
		if($_POST['action']=="UPDATE") {
			if(carr($_POST)) {
				$img="NULL";
				if($_FILES['img']['size']>0) {
					$img="./mgntp/".$_FILES['img']['name'];
					move_uploaded_file($_FILES['img']['tmp_name'],$img);
				}
				if(carr($_POST)) {
					$nm=strtolower($_POST['nm']);$rw=strtolower($_POST['rw']);$po=strtolower($_POST['po']);$mt=strtolower($_POST['memtype']);
					if($_FILES['img']['size']>0) {
						$qq=mysql_query("update mgntp set name='$nm',memtype='$mt',post='$po',respect='$rw',img='"."./mgntp/".$_FILES['img']['name']."' where id='$id'");
					} else {
						$qq=mysql_query("update mgntp set name='$nm',memtype='$mt',post='$po',respect='$rw' where id='$id'");
					}
					if(cerr()) {
						echo "<div id='done'>Updated!!</div><br/>";
					} else {
						ms_err("1");
					}
				} else {
					echo "<div id='error'>You have to fill all the textbox(s) to update profile!!</div><br/>";
				}
			} else {
				ms_err("1");
			}
		} else {
			if(isset($_POST['delete'])) {
				mysql_select_db("idtsvbt_db_faculty");
				$q=mysql_query("delete from mgntp where id='$id'");
				if(cerr()) {
					echo "<div id='done'>Deleted!!</div><br/>";
				} else {
					ms_err("1");
				}
			} else {
			?>
			<div id='error'><h3><div>Are you sure to delete this profile now ?</div></h3><br/>
				<center>
					<form name="dform" id="dform" method="post"><input type="hidden" name="action" value="DELETE" /><input type="hidden" name="delete" value="yes" /></form>
					<div class="linkbox">
						<a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=mgntp&id=<?=$id?>">NO</a>
					</div>
				</center>
			</div>
			<?php
			}
		}
	} else {
		$se=mysql_query("select * from mgntp where id='$id'");
		if(cerr()) {
			if(mysql_affected_rows()==0) {
				echo "<div id='error'>Sorry this identifier is not validate!!</div><br/>";
			} else {
				$row=mysql_fetch_row($se);
				?>
				<form method="post" enctype="multipart/form-data" style="width:100%;text-align:left">
					<b>Enter name:- </b><br/><input type="text" name="nm" style="width:100%" value="<?=$row[1]?>"/><br/>
					<b>Respect word (ex: Mr,Honrable,Shree etc..):- </b><br/><input type="text" name="rw" style="width:100%" value="<?=$row[2]?>"/><br/>
					<b>Designation:- </b><br/><input type="text" name="po" style="width:100%" value="<?=$row[3]?>" /><br/>
					<b>Photo:- </b><br/><img src="<?=$row[4]?>" style="width:160px;height:120px" /><br/><input type="file" name="img" style="width:100%" /><br/><br/>
					<b>Member type :-</b><br/>
					<select name="memtype" style="width:100%">
						<?php
							if($row[5]=="0") {
								echo "<option value='0' selected>Trusties</option><option value='1'>Member trusties</option>";
							} else {
								echo "<option value='0'>Trusties</option><option value='1' selected>Member trusties</option>";
							}
						?>
						
					</select><br/>
					<input type="submit" value="UPDATE" name="action"/> <input type="submit" value="DELETE" name="action" />
				</form>
				<?php
			}
		} else {
			ms_err("1");
		}
	}
} else {
?>
<?php
if(isset($_GET['profile'])) {
	if(isset($_POST['action'])) {
		if(carr($_POST)) {
			$nm=strtolower($_POST['nm']);$rw=strtolower($_POST['rw']);$po=strtolower($_POST['po']);$mt=strtolower($_POST["memtype"]);
			$save="./mgntp/".$_FILES['img']['name'];
			move_uploaded_file($_FILES['img']['tmp_name'],$save);
			include_once 'settings.php';
			$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
			mysql_select_db("idtsvbt_db_faculty");
			$ins=mysql_query("insert into mgntp(name,respect,post,img,memtype) values('$nm','$rw','$po','$save','$mt')");
			if(cerr()) {
				echo "<div id='done'>Added!!</div><br/>";
			} else {
				ms_err("1");
			}
		} else {
			echo "<div id='error'>You have to fill all the textbox(s) to add new profile!!</div><br/>";
		}
	}
	?>
	<form method="post" enctype="multipart/form-data" style="width:100%;text-align:left">
		<b>Enter name:- </b><br/><input type="text" name="nm" style="width:100%" /><br/>
		<b>Respect word (ex: Mr,Honrable,Shree etc..):- </b><br/><input type="text" name="rw" style="width:100%" /><br/>
		<b>Designation:- </b><br/><input type="text" name="po" style="width:100%" /><br/>
		<b>Photo:- </b><br/><input type="file" name="img" style="width:100%" /><br/>
		<b>Member type :-</b><br/>
			<select name="memtype" style="width:100%"><option value="0">Trusties</option><option value="1">Member trusties</option></select>
		<br/><br/>
		<input type="submit" value="ADD" name="action"/>
	</form>
	<?php
} else {
?>
<div class="classic" style="margin-left:5%">
	<u><h5>Click on profile for editing or deleting</h5></u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
	<?php
	include_once 'settings.php';
	$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
	mysql_select_db("idtsvbt_db_faculty");
	$li=mysql_query("select * from mgntp");
	$i=0;
	if(cerr()) {
		while(($row=mysql_fetch_array($li))) {
			$dtdt="";
			if($row[5]=="0") {
				$dtdt="Trusties";
			} else {
				$dtdt="Member trusties";
			}
			echo "<a href='?page=mgntp&id=$row[0]'><img src='$row[4]'/><br/><br/><span>".ucwords($row[2]." ".$row[1])."</span><br/><span>".ucwords($row[3])."</span><br><span>$dtdt</span></a>";
			$i++;
		}
	} else {
		ms_err("1");
	}
	if($i==0) {
		echo "<center><div id='warning'>Sorry didnt have added profile yet!!</div><br/></center>";
	}
	?>
	<div style="clear:both"></div>
</div>
<br/><div class="linkbox">
	<a href="?page=mgntp&profile=new">New profile</a>
</div>
<?php }} ?>