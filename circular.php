<?php include_once "import.php"; ?><html>
<head>
	<title>Circular - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	<style type="text/css">
	</style>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<center><h2>Circular Board</h2></center><br/>
		
		<?php
		//if(isset($_POST['branch'])) {
			//$branch=strtolower($_POST['branch']);
			include_once "settings.php";
			$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
			mysql_select_db("idtsvbt_db_faculty");
                        if(isset($_POST['page'])) {
                            $page=$_POST['page'];
                        } else {
                            $page="1";
                        }
			if(isset($_POST['action'])) {
				if($_POST['action']=="Previous") {
					$page--;
				} else {
					$page++;
				}
			}
			$start=($page*10)-10;
			$count=mysql_query("select count(id) from circular");
			$row=mysql_fetch_row($count);
			$total=$row[0];
			$search=mysql_query("select * from circular order by id desc limit $start,10");
			if(cerr()) {
				if(mysql_affected_rows()==0) {
					echo "<br/><center><div id='error'>Sorry no data found!</div></center>";
				} else {
					$data['current']=$page;$data['total']=ceil($total/10);
		?>
		<div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
			<table cellspacing="0" class="mytable" style="width:100%">
				<tr class="head">
					<td><b>Date:</b></td><td style="width:900px"><b>Circular Description:</b></td>
				</tr>
				<?php while(($row=mysql_fetch_array($search))) { ?>
					<tr><td><u><?=$row[0]?>.</u> <?=$row[1]?></td><td><a href='<?=$row[3]?>'><?=$row[2]?></a></td></tr>
				<?php } ?>
			</table>
		</div>
		<br/>
		<center><form method="post">
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
                                echo mysql_error();
			}
		//}
		?>
	</div>

	<?php include_once "bottombar.php"; ?>
</body>
</html>









