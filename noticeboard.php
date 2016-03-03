<?php include_once "import.php"; ?><html>
<head>
	<title>Notice Board - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	<style type="text/css">
	</style>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<center><h2>Notice Board</h2></center><br/>
		<center>
			<form method="post">
				<table>
					<tr>
						<td>Select branch:<input type="hidden" name="page" value="1" /></td>
						<td>
							<select name="branch" style="width:300px">
							<?php
						            include_once "settings.php";
						            $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
						            mysql_select_db("idtsvbt_db_faculty");
						            $getbranch="select distinct bname from branch";
						            $getbranch=mysql_query($getbranch);
						            while($row=mysql_fetch_array($getbranch)) {
						                echo "<option value='".$row['bname']."'>".$row['bname']."</option>";
						            }
						        ?>
							</select>
						</td>
						<td><input type="submit" value="Show" /></td>
					</tr>
				</table>
			</form>
		</center>
		<?php
		if(isset($_POST['branch'])) {
			$branch=strtolower($_POST['branch']);
			include_once "settings.php";
			$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
			mysql_select_db("idtsvbt_db_faculty");
			$page=$_POST['page'];
			if(isset($_POST['action'])) {
				if($_POST['action']=="Previous") {
					$page--;
				} else {
					$page++;
				}
			}
			$start=($page*10)-10;
			$count=mysql_query("select count(id) from notice_board where lower(branch)='$branch'");
			$row=mysql_fetch_row($count);
			$total=$row[0];
			$search=mysql_query("select * from notice_board where lower(branch)='$branch' order by id desc limit $start,10");
			if(cerr()) {
				if(mysql_affected_rows()==0) {
					echo "<br/><center><div id='error'>Sorry no data found for selected branch!</div></center>";
				} else {
					$data['current']=$page;
					$data['total']=ceil($total/10);
		?>
		<div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
			<table cellspacing="0" class="mytable" style="width:100%">
				<tr class="head">
					<td style="width:20%"><b>Notice Date:</b></td><td style="width:60%"><b>Notice Description:</b></td><td style="width:20%"><b>Semester:</b></td>
				</tr>
				<?php while(($row=mysql_fetch_array($search))) { ?>
					<tr><td><u><?=$row[0]?>.</u> <?=$row[1]?></td><td><a href='<?=$row[5]?>'><?=$row[2]?></a></td><td><?=$row[4]?> semester</td></tr>
				<?php } ?>
			</table>
		</div>
		<br/>
		<center><form method="post">
			<input type="hidden" name="branch" value="<?=$branch?>"/>
			<input type="hidden" name="page" value="<?=$page?>"/>
			<?php
				if($page==1) {
					echo "<input disabled='true' type='submit' name='action' value='Previous'/>";
					echo "&nbsp;&nbsp;Page ".$data['current']." of ".$data['total']."&nbsp;&nbsp;";
					if($data['total']==1) {
						echo "<input disabled='true' type='submit' name='action' value='Next'/>";
					} else {
						echo "<input type='submit' name='action' value='Next'/>";
					}
				} elseif($page==$data['total']) {
					echo "<input type='submit' name='action' value='Previous'/>";
					echo "&nbsp;&nbsp;Page ".$data['current']." of ".$data['total']."&nbsp;&nbsp;";
					echo "<input disabled='true' type='submit' name='action' value='Next'/>";
				} else {
					echo "<input type='submit' name='action' value='Previous'/>";
					echo "&nbsp;&nbsp;Page ".$data['current']." of ".$data['total']."&nbsp;&nbsp;";
					echo "<input type='submit' name='action' value='Next'/>";
				}
			?>

		</form></center>
		<?php
				}
			} else {
				ms_err("1");
			}
		}
		?>
	</div>

	<?php include_once "bottombar.php"; ?>
</body>
</html>









