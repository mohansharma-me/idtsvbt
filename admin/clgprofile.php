<br/><h3>College Profiles</h3><br/>
<?php
if(isset($_POST['action'])) {
	mysql_select_db("idtsvbt_db_faculty");
	if($_FILES['mbp']['size']>0) {
		$saved_type=$_FILES['mbp']['type'];
		$saved_file=$_FILES['mbp']['tmp_name'];
		if(strtolower(substr($saved_type,0,5))=="image") {
			$saveto="./mbp.jpg";
			move_uploaded_file($saved_file,$saveto);
		}
	} else {
		$_POST['mbp']="null";
	}
	if(carr($_POST)) {
		$wm=strtolower($_POST['wm']);$ph=strtolower($_POST['ph']);$fa=strtolower($_POST['fa']);$em=strtolower($_POST['em']);$de=strtolower($_POST['de']);$ad=strtolower($_POST['ad']);
		$upd=mysql_query("update clgprofile set descs=\"$de\",phone='$ph',fax='$fa',email='$em',address='$ad',welcomemsg=\"$wm\" where id='1'");
		if(cerr()) {
			echo "<div id='done'>Updated sucessfully!!</div><br/>";
		} else {
			ms_err("1");echo mysql_error();
		}
	} else {
		echo "<div id='error'>You have to fill all the textbox(s) to update principal's details..</div><br/>";		
	}
}
$_GLOBAL['row']="";
mysql_select_db("idtsvbt_db_faculty");
$q=mysql_query("select * from clgprofile where id='1'");
if(cerr()) {
	$r=mysql_fetch_row($q);
	$_GLOBAL['row']=$r;
} else {
	ms_err("1");
}
$row=$_GLOBAL['row'];
?>
<form method="post" style="text-align:left" enctype="multipart/form-data">
	Welcome message :-<br/><textarea name="wm" style="width:100%"><?=$row[6]?></textarea><br/>
	Description :-<br/><textarea name="de" style="width:100%"><?=$row[1]?></textarea><br/>
	Address :-<br/><input type="text" name="ad" style="width:100%" value="<?=$row[5]?>"/><br/>
	Phone :-<br/><input type="text" name="ph" style="width:100%"  value="<?=$row[2]?>"/><br/>
	Fax :-<br/><input type="text" name="fa" style="width:100%"  value="<?=$row[3]?>"/><br/>
	Email address :-<br/><input type="text" name="em" style="width:100%"  value="<?=$row[4]?>"/><br/>
	Main building photo :-<br/><img src="mbp.jpg" style="width:160px;height:120px"/><br/><input type="file" name="mbp" style="width:100%" /><br/><br/>
	<input type="submit" name="action" value="Update" />
</form>
