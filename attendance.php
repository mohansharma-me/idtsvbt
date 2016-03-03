<?php include_once "import.php"; ?><html>
<head>
	<title>Attendance - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	<style type="text/css">
	.input {
		disabled:true;
	}
	</style>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<center><h2>Attendance</h2></center><br/>
		<center>
			<form method="post">
				<table>
					<tr>
						<td>Enter enrollment no:</td>
						<td><input type="text" name="enrollno" style="width:300px" /></td>
						<td><input type="submit" value="Show" /></td>
					</tr>
				</table>
			</form>
		</center>
		<center>
		<?php
		if(isset($_POST['enrollno'])) {
			include_once 'settings.php';
			$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
			mysql_select_db("idtsvbt_db_faculty");
			$enrollno=strtolower($_POST['enrollno']);
			$search=mysql_query("select * from attendance where lower(enrollno)='$enrollno'");
			if(cerr()) {
				if(mysql_affected_rows()==0) {
					echo "<center><div id='error'>Sorry, your entered enrollment no may be incorrect or not in database!</div></center>";					
				} else {
					$row=mysql_fetch_row($search);
					?>
					<br/>
					<div style="margin-left:2%;border:1px solid black;padding:10px;width:900px">
						<div style="float:left;width:300px"><b>Name:</b><br/><?=ucwords($row[1])?></div>
						<div style="float:left;width:300px"><b>Enrollment no:</b><br/><?=ucwords($row[2])?></div>
						<div style="float:left;width:300px"><b>Updated date:</b><br/><?=ucwords($row[3])?></div>
						<div style="float:left;width:900px"><b>Notice:</b><br/><u><?=ucwords($row[6])?></u></div>
						<div style="float:left;width:300px"><b>Subjects:</b><br/>
							<?php
								$subjects=explode("|",$row[4]);
								for($i=0;$i<count($subjects);$i++) {
									echo strtoupper($subjects[$i])."<br/>";
								}
							?>
						</div>
						<div style="float:left;width:300px"><b>Percantages:</b><br/>
							<?php
								$perc=explode("|",$row[5]);
								$sum=0;
								for($i=0;$i<count($perc);$i++) {
									$sum+=$perc[$i];
									echo strtoupper($perc[$i])."%<br/>";
								}
							?>
						</div>
						<div style="float:left;width:300px"><b>Average:</b><br/>&nbsp; <?=$sum/count($perc)?>%<br/><b>Attendance level:</b><br/>
						<?php
						if(($sum/count($perc))==$row[7]) {
							echo "<div id='warning' style='width:200px'>Medium (=".$row[7]."%)</div>";
						} elseif(($sum/count($perc))<=$row[7]) {
							echo "<div id='error' style='width:200px'>Low (<".$row[7]."%)</div>";
						} elseif(($sum/count($perc))>=$row[7]) {
							echo "<div id='done' style='width:200px'>High (>".$row[7]."%)</div>";
						}
						
						?>
						</div>
						<div style="clear:both"></div>
					</div>
					<?php										
				}
			} else {
				ms_err("1");
			}
		}
		?></center>
	</div>
	<?php include_once "bottombar.php"; ?>
</body>
</html>









