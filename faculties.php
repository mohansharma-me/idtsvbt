<?php include_once "import.php"; ?><html>
<head>
	<title>Faculties - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<center><h2>Faculty Staff</h2></center><br/>
		<?php
		if(isset($_GET['id']) && isset($_GET['branch'])) {
			$id=strtolower($_GET['id']);$branch=strtolower($_GET['branch']);
			include_once 'settings.php';
			$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
			mysql_select_db("idtsvbt_db_faculty");
			$search=mysql_query("select * from faculties where id='$id'");
			if(cerr()) {
				$row=mysql_fetch_row($search);
				?>
				<div class="content" style="margin-left: 20px;">
				<table>
					<tr>
						<?php
						if(strlen($row['11'])>0) {
						?>
						<td><img style="width:240px;height:320px;background:url(none.jpg) black;" src="<?=$row['11']?>"/></td>
						<?php 
						} else {
						?><td><img style="width:240px;height:320px" src="none.jpg"/></td><?php
						}
						?>
						<td style="padding-left:60px">
							<table>
								<tr>
									<td class='td_lbl'><b>Full Name:</b></td>
									<td class='td_val'><?=ucwords($row['1'])?></td>
								</tr>
								<tr>
									<td class='td_lbl'><b>Date of birth:</b></td>
									<td class='td_val'><?=ucwords($row['2'])?></td>
								</tr>
								<tr>
									<td class='td_lbl'><b>Qualifiaction:</b></td>
									<td class='td_val'><?=ucwords($row['3'])?></td>
								</tr>
								<tr>
									<td class='td_lbl'><b>Gender:</b></td>
									<td class='td_val'><?=ucwords($row['12'])?></td>
								</tr>
								<tr>
									<td class='td_lbl'><b>Email:</b></td>
									<td class='td_val'><?=ucwords($row['10'])?></td>
								</tr>
								<tr>
									<td class='td_lbl'><b>Address:</b></td>
									<td class='td_val'><?=ucwords($row['8'])?></td>
								</tr>
								<tr>
									<td class='td_lbl'><b>Department:</b></td>
									<td class='td_val'><?=ucwords($row['5'])?></td>
								</tr>
								<tr>
									<td class='td_lbl'><b>Experiance:</b></td>
									<td class='td_val'><?=ucwords($row['4'])?></td>
								</tr>
								<tr>
									<td class='td_lbl'><b>Designation:</b></td>
									<td class='td_val'><?=ucwords($row['6'])?> semester</td>
								</tr>
								<tr>
									<td class='td_lbl'><b>Subjects:</b></td>
									<td class='td_val'><?=ucwords($row['7'])?></td>
								</tr>
								<tr>
									<td class='td_lbl'><b>Contact details:</b></td>
									<td class='td_val'><?=$row['9']?></td>
								</tr>
							</table>
							<br/><center><a href="javascript:history.back(0)"><< Go Back</a></center>
						</td>
					</tr>
				</table>
				</div>
				<?php
			} else {
				ms_err("1");
			}
		?>

		<?php
		} else {
		?>
		<center><form method="post">
			<label>Select branch:</label>
			<select name="branch" style="width:300px">
				<option>[ Select branch name ]</option>
				<?php
					include_once 'settings.php';
					$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
					mysql_select_db("idtsvbt_db_faculty");
					$latest_news=mysql_query("select distinct bname from branch");
					while($row=mysql_fetch_array($latest_news)) {
						$bname=$row['bname'];
						echo "<option value='$bname'>".ucwords($bname)."</option>";
					}
				?>
			</select>
			<input type="submit" value="Show"/>
		</form></center>
		<?php
			if(isset($_POST['branch'])) {
		?>
		<div class="boxitems" style="margin-left:20px;">
			<?php
				include_once 'settings.php';
				$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
				mysql_select_db("idtsvbt_db_faculty");
				$depa=strtolower($_POST['branch']);
				$count=mysql_query("select count(id) from faculties where lower(depa)='$depa'");
				$row=mysql_fetch_row($count);
				$total=ceil($row[0]/12);
				if(isset($_POST['action'])) {
					if($_POST['action']=="Previous") {
						$page=$_POST['page']-1;
					} else {
						$page=$_POST['page']+1;
					}
				} else {
					$page=1;
				}
				$start=($page*12)-12;
				$latest_news=mysql_query("select * from faculties where lower(depa)='$depa' limit $start,12");
				if(mysql_affected_rows()==0) {
					echo "<center><div id='error'>No data found from selected branch!</div></center><br/></div>";
				} else {
					$data['current']=$page;
					$data['total']=$total;
					while($row=mysql_fetch_array($latest_news)) {
						$id=$row['id'];$img=$row['img'];$fname=$row['fname'];$desg=$row['desg'];
						if(strlen($img)==0) {
							$img="none.jpg";
						}
						echo "<a href='faculties.php?id=$id&branch=$depa'><img src='$img'/><br>".ucwords($fname)."<br>".ucwords($desg)."<br>".ucwords($row['qual'])."</a>";
					}
				
			?>
			<div style="clear:both"></div><br/>
			<center><form method="post">
				<input type="hidden" name="branch" value="<?=$depa?>"/>
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
		</div>
		<div style="clear:both"></div>
		<?php
			}}
		}
		?>
	</div>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
