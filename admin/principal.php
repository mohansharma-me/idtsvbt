<br/><h3>Principal details</h3><br/>
<?php
	if(isset($_POST['submit'])) {
		mysql_select_db("idtsvbt_db_faculty");
		if($_FILES['img']['size']>0) {
			$saved_type=$_FILES['img']['type'];
			$saved_file=$_FILES['img']['tmp_name'];
			if(strtolower(substr($saved_type,0,5))=="image") {
				$saveto="./principal.jpg";
				move_uploaded_file($saved_file,$saveto);
			}
		} else {
			$_POST['img']="null";
		}
		if(carr($_POST)) {
			$fname=strtolower($_POST['fname']);$dob=strtolower($_POST['dob']);$qual=strtolower($_POST['qual']);$expe=strtolower($_POST['expe']);$depa=strtolower($_POST['depa']);$subj=strtolower($_POST['subj']);$address=strtolower($_POST['address']);$contact=strtolower($_POST['contact']);$email=strtolower($_POST['email']);$during=strtolower($_POST['during']);
			$upd=mysql_query("update principal set fname='$fname',dob='$dob',qual='$qual',expe='$expe',depa='$depa',subj='$subj',address='$address',contact='$contact',email='$email',during='$during' where id='1'");
			if(cerr()) {
				echo "<div id='done'>Updated sucessfully!!</div><br/>";
			} else {
				ms_err("1");echo mysql_error();
			}
		} else {
			echo "<div id='error'>You have to fill all the textbox(s) to update principal's details..</div><br/>";		
		}
	}
	$_GLOBEL['row']="";
	mysql_select_db("idtsvbt_db_faculty");
	$qu=mysql_query("select * from principal where id='1'");
	if(cerr()) {
		$_GLOBEL['row']=mysql_fetch_row($qu);
	} else {
		ms_err("1");
	}
	$row=$_GLOBEL['row'];
?>
<form method="post" enctype="multipart/form-data">
	<table>
		<tr><td>Name :-<br/><input type="text" name="fname" style="width:400px" value="<?php echo $row[1]; ?>" /></td></tr>
		<tr><td>Date of birth :-<br/><input type="text" name="dob" style="width:400px" value="<?php echo $row[2]; ?>" /></td></tr>
		<tr><td>Qualification :-<br/><input type="text" name="qual" style="width:400px" value="<?php echo $row[3]; ?>" /></td></tr>
		<tr><td>Experiance :-<br/><input type="text" name="expe" style="width:400px" value="<?php echo $row[4]; ?>" /></td></tr>
		<tr><td>Department :-<br/><input type="text" name="depa" style="width:400px" value="<?php echo $row[5]; ?>" /></td></tr>
		<tr><td>Subjects :-<br/><input type="text" name="subj" style="width:400px" value="<?php echo $row[6]; ?>" /></td></tr>
		<tr><td>Address :-<br/><input type="text" name="address" style="width:400px" value="<?php echo $row[7]; ?>" /></td></tr>
		<tr><td>Contact :-<br/><input type="text" name="contact" style="width:400px" value="<?php echo $row[8]; ?>" /></td></tr>
		<tr><td>Email address :-<br/><input type="text" name="email" style="width:400px" value="<?php echo $row[9]; ?>" /></td></tr>
		<tr><td>Picture :-<br/><img src="./principal.jpg" style="width:160px;height:120px" /><br/><input type="file" name="img" style="width:400px" /></td></tr>
		<tr><td>During :-<br/><input type="text" name="during" style="width:400px" value="<?php echo $row[11]; ?>" /></td></tr>
		<tr><td><br/><input type="submit" name="submit" value="Update" /><input type="reset" value="Reset" /></td></tr>		
	</table>
</form>
