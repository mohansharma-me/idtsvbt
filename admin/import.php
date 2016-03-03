<br/><h3>Import data</h3><br/>
<?php
if(isset($_GET['t'])) {
	if($_GET['t']=="student") {
		if(isset($_POST['action'])) {
			$name=$_FILES['csv']['name'];
			$tname=$_FILES['csv']['tmp_name'];
			$size=$_FILES['csv']['size'];
			$type=$_FILES['csv']['type'];
			$ext=substr($name,-3,3);
			if($ext=="csv" && $type=="application/vnd.ms-excel") {
				include_once 'settings.php';
				$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
				mysql_select_db("idtsvbt_db_faculty");
				$field=array("fname","enrollno","dob","gender","email","address","contact","branch","sem","spi","cpi");
				echo "<div id='done'>";
				if(isset($_POST['chk'])) {
					CSVImport("profiles",$field,$tname,true);
				} else {
					CSVImport("profiles",$field,$tname);
				}
				echo "</div>";
			} else {
				echo "<div id='warning'>Invalid file!!</div><br/>";
			}
		}
		?>
		<u><h4>Import students data</h4></u><br/>
		<form method="post" enctype="multipart/form-data" style="text-align:left">
			<b>Select CSV file :-</b><br/><input type="file" name="csv" /><br/>
			<b>Clear existing data :-</b><input type="checkbox" name="chk" />
			<br/><input type="Submit" name="action" value="IMPORT" />
		</form><br/>
		<br/>
		<div align=left>
		<b>CSV format for importing student data :-</b>( <span>You have to upload student photo manually from student management page!!</span> )<br/><br/>
		<table class="mytable" cellspacing="1">
			<tr class="head">
				<td>Full name</td><td>Enrollment no</td><td>Date of birth</td><td>Gender</td><td>Email address</td><td>Address</td><td>Contact details</td><td>Branch</td><td>Semester</td><td>SPI</td><td>CPI</td>
			</tr>
		</table><br/><br/>
		<b>Example data for importing student data :-</br><br/>
<textarea style="width:100%" disabled=true>mohan sharma,096520307037,03-04-1993,male,iammegamohan@gmail.com,9722505033,computer engineering,6,9,9
anil amlani,096520307019,11-12-1991,male,anil27927@gmail.com,9428727927,computer engineering,6,9,9
</textarea>
		</div>
		<?php
	} elseif($_GET['t']=="faculty") {
		if(isset($_POST['action'])) {
			$name=$_FILES['csv']['name'];
			$tname=$_FILES['csv']['tmp_name'];
			$size=$_FILES['csv']['size'];
			$type=$_FILES['csv']['type'];
			$ext=substr($name,-3,3);
			if($ext=="csv" && $type=="application/vnd.ms-excel") {
				include_once 'settings.php';
				$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
				mysql_select_db("idtsvbt_db_faculty");
				$field=array("fname","dob","qual","expe","depa","desg","subj","address","contact","email","gender");
				echo "<div id='done'>";
				if(isset($_POST['chk'])) {
					CSVImport("faculties",$field,$tname,true);
				} else {
					CSVImport("faculties",$field,$tname);
				}
				echo "</div>";
			} else {
				echo "<div id='warning'>Invalid file!!</div><br/>";
			}
		}
		?>
		<u><h4>Import faculties data</h4></u><br/>
		<form method="post" enctype="multipart/form-data" style="text-align:left">
			<b>Select CSV file :-</b><br/><input type="file" name="csv" /><br/>
			<b>Clear existing data :-</b><input type="checkbox" name="chk" />
			<br/><input type="Submit" name="action" value="IMPORT" />
		</form><br/>
		<br/>
		<div align=left>
		<b>CSV format for importing faculties data :-</b>( <span>You have to upload faculty photo manually from faculty management page!!</span> )<br/><br/>
		<table class="mytable" cellspacing="1">
			<tr class="head">
				<td>Full name</td><td>Date of birth</td><td>Qualification</td><td>Experiance</td><td>Branch/Depart.</td><td>Designation</td><td>Subject</td><td>Address</td><td>Contact detail</td><td>Email address</td><td>Gender</td>
			</tr>
		</table><br/><br/>
		<b>Example data for importing faculties data :-</br><br/>
<textarea style="width:100%" disabled=true>mitesh mandaliya,03-03-1993,qualification,experiance,computer engineering,designation,subjects,surendranagar,1231231231,mitesh@gmail.com,male</textarea>
		</div>
		<?php
	} elseif($_GET['t']=="result") {
		echo "<u><h4>Import result data</h4></u><br/>";
		if(isset($_GET['id'])) {
			$id=strtolower($_GET['id']);
			mysql_select_db("idtsvbt_db_faculty");
			$se=mysql_query("select * from $id where id='1'");
			if(cerr()) {
				$row=mysql_fetch_row($se);
				if(isset($_POST['action'])) {
                    $name=$_FILES['csv']['name'];
                    $tname=$_FILES['csv']['tmp_name'];
                    $size=$_FILES['csv']['size'];
                    $type=$_FILES['csv']['type'];
                    $ext=substr($name,-3,3);
                    if($ext=="csv" && $type=="application/vnd.ms-excel") {
                        include_once 'settings.php';
                        $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
                        mysql_select_db("idtsvbt_db_faculty");
                        $field=array("enrollno","fname","marks","subjects","outof","fail");
                        echo "<div id='done'>";
                        if(isset($_POST['chk'])) {
                            CSVImport("$id",$field,$tname,true,$row[3].";30;12");
                        } else {
                            CSVImport("$id",$field,$tname,false,$row[3].";30;12");
                        }
                        echo "</div><br/>";
                    } else {
                        echo "<div id='warning'>Invalid file!!</div><br/>";
                    }
                }
				?>
				<form method="post" enctype="multipart/form-data" style="text-align:left">
                    <b>Result ID :-</b> <span><?=$id?></span><br/><br/>
					<b>Select CSV file :-</b><br/><input type="file" name="csv" /><br/>
					<b>Clear existing data :-</b><input type="checkbox" name="chk" />
					<br/><input type="Submit" name="action" value="IMPORT" />
				</form><br/><br/>
                <div align="left">
                <b>CSV format for importing result :-</b><br/>
                <table class="mytable" cellspacing="1">
                    <tr class="head">
                        <td>Enrollment no</td><td>Full name</td><td>Marks for (<?=$row[3]?>)</td>
                    </tr>
                </table>
                <br/><br/><b>Example data for importing results :-</b><br/>
                <textarea style="width:100%" disabled="disabled">096520307037,mohan sharma,23|23|30|12</textarea>
                </div>
				<?php
			} else {
				ms_err("1");
			}
		} else {
			?>
			<div align=left><b>Select result :- </b><br/></div><br/>
			<table class="mytable" cellspacing="0">
				<tr class="head">
					<td>Branch & Semester</td><td style="width:30%">Exam. date & Result date.</td><td style="width:20%">Exam. type</td>
				</tr>
				<?php
				mysql_select_db("idtsvbt_db_faculty");
				$sea=mysql_query("select * from result_table");
				if(cerr()) {
					while(($row=mysql_fetch_array($sea))) {
						echo "<tr><td><a href='?page=import&t=result&id=$row[6]'>".ucwords($row[1])."<br/>$row[2] semester</a></td><td><a href='?page=import&t=result&id=$row[6]'>".ucwords($row[3])."<br/>$row[5]</a></td><td><a href='?page=import&t=result&id=$row[6]'>".ucwords($row[4])."</a></td></tr>";
					}
				} else {
					ms_err("1");
				}
				?>
			</table>
			<?php
		}
	} elseif($_GET['t']=="fees") {
        if(isset($_POST['action'])) {
			$name=$_FILES['csv']['name'];
			$tname=$_FILES['csv']['tmp_name'];
			$size=$_FILES['csv']['size'];
			$type=$_FILES['csv']['type'];
			$ext=substr($name,-3,3);
			if($ext=="csv" && $type=="application/vnd.ms-excel") {
				include_once 'settings.php';
				$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
				mysql_select_db("idtsvbt_db_faculty");
				$field=array("fname","enrollno","branch","sem","fees","submitted","ldate");
				echo "<div id='done'>";
				if(isset($_POST['chk'])) {
					CSVImport("fees_details",$field,$tname,true);
				} else {
					CSVImport("fees_details",$field,$tname);
				}
				echo "</div>";
			} else {
				echo "<div id='warning'>Invalid file!!</div><br/>";
			}
		}
		?>
		<u><h4>Import fees details data</h4></u><br/>
		<form method="post" enctype="multipart/form-data" style="text-align:left">
			<b>Select CSV file :-</b><br/><input type="file" name="csv" /><br/>
			<b>Clear existing data :-</b><input type="checkbox" name="chk" />
			<br/><input type="Submit" name="action" value="IMPORT" />
		</form><br/>
		<br/>
		<div align=left>
		<b>CSV format for importing fees data :-</b><br/><br/>
		<table class="mytable" cellspacing="1">
			<tr class="head">
				<td>Full name</td><td>Enrollment no</td><td>Branch</td><td>Semester</td><td>Fees Amount</td><td>Submitted</td><td>Last date</td>
			</tr>
		</table><br/><br/>
		<b>Example data for importing fees data :-</br><br/>
<textarea style="width:100%" disabled=true>mohan sharma,096520307037,computer engineering,5,13000,yes,03-04-2012</textarea>
		</div>
		<?php
    }
}
?>
<br/><hr/><br/><div class="linkbox">
	<a href="?page=import&t=student">Import student(s)</a>
	<a href="?page=import&t=faculty">Import faculties</a>
	<a href="?page=import&t=result">Import result(s)</a>
	<a href="?page=import&t=fees">Import fees detail(s)</a>
</div>