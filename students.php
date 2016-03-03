<?php include_once "import.php"; ?><html>
<head>
	<title>Students information - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<?php
	if(isset($_GET['profile'])) {
		if(cvar($_GET['profile'])) {
			if(isset($_SESSION['logged'])) {
				$id=strtolower($_GET['profile']);
				include_once "settings.php";
				$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
				mysql_select_db("idtsvbt_db_faculty");
				$student=mysql_query("select * from profiles where id='$id'");
				if(cerr()) {
					if(mysql_affected_rows()==0) {
						echo "<code id='error'>Sorry, this profile is is not valid!</code><br/>";
					} else {
						$row=mysql_fetch_row($student);
						if(!file_exists($row[8])) {
							$row[8]="none.jpg";
						}
						?>
						<div class="content" style="margin-left: 20px;">
						<table>
							<tr>
								<td><img style="width:240px;height:320px" src="<?=$row['8']?>"/></td>
								<td style="padding-left:60px">
									<table>
										<tr>
											<td class='td_lbl'><b>Full Name:</b></td>
											<td class='td_val'><?=ucwords($row['1'])?></td>
										</tr>
										<tr>
											<td class='td_lbl'><b>Enrollment no:</b></td>
											<td class='td_val'><?=ucwords($row['2'])?></td>
										</tr>
										<tr>
											<td class='td_lbl'><b>Date of birth:</b></td>
											<td class='td_val'><?=ucwords($row['3'])?></td>
										</tr>
										<tr>
											<td class='td_lbl'><b>Gender:</b></td>
											<td class='td_val'><?=ucwords($row['4'])?></td>
										</tr>
										<tr>
											<td class='td_lbl'><b>Email:</b></td>
											<td class='td_val'><?=ucwords($row['5'])?></td>
										</tr>
										<tr>
											<td class='td_lbl'><b>Address:</b></td>
											<td class='td_val'><?=ucwords($row['6'])?></td>
										</tr>
										<tr>
											<td class='td_lbl'><b>Contact details:</b></td>
											<td class='td_val'><?=ucwords($row['7'])?></td>
										</tr>
										<tr>
											<td class='td_lbl'><b>Branch:</b></td>
											<td class='td_val'><?=ucwords($row['9'])?></td>
										</tr>
										<tr>
											<td class='td_lbl'><b>Semester:</b></td>
											<td class='td_val'><?=ucwords($row['10'])?> semester</td>
										</tr>
										<tr>
											<td class='td_lbl'><b>SPI:</b></td>
											<td class='td_val'><?=ucwords($row['11'])?></td>
										</tr>
										<tr>
											<td class='td_lbl'><b>CPI:</b></td>
											<td class='td_val'><?=$row['12']?></td>
										</tr>
									</table>
									<br/><center><a href="javascript:history.back(0)"><< Go Back</a></center>
								</td>
								<?php
								if(isset($_SESSION['account'])) { 
									if($_SESSION['account']=="admin") {
								mysql_select_db("idtsvbt_db_faculty");
								$qu=mysql_query("select * from toppers where enrollno='$row[2]'");
								if(cerr()) {
									if(mysql_affected_rows()==0) {
										?>
										<td>
											<?php
												if(isset($_GET['topper'])) {
													if(isset($_POST['action'])) {
														$ra=strtolower($_POST['ra']);
														$upd=mysql_query("insert into toppers(fname,enrollno,rank,spi,sem,branch) values('$row[1]','$row[2]','$ra','$row[11]','$row[10]','$row[9]')");
														if(cerr()) {
															echo "<b>Added!!</b>";
														} else {
															ms_err("1");
														}
													} else {
													echo "<form method='post'><b>Enter rank :-</b><br/><input type='text' name='ra' style='width:100%' /><br/><input type='submit' name='action' value='Submit' /></form>";
													}
												} else {
											?>
											<div class="linkbox"><a href="students.php?profile=<?=$row[0]?>&topper=yes">Add to toppers</a></div>
											<?php } ?>
										</td>
										<?php
									} else {
										?>
										<td>
											<?php 
												if(isset($_GET['topper'])) {
													mysql_select_db("idtsvbt_db_faculty");
													$q=mysql_query("delete from toppers where enrollno='$row[2]'");
													if(cerr()) {
														echo "<b>Removed!!</b>";
													} else {
														ms_err("1");
													}
												} else {
											?>
											<b>This student is topper!!</b><br/><br/>
											<div class="linkbox"><a href="?profile=<?=$row[0]?>&topper=delete">Remove from topper!!</a></div>
											<?php } ?>
										</td>
										<?php
									}
								}}}
								?>
							</tr>
						</table>
						</div>
						<?php
					}
				} else {
					ms_err("1");
				}
			} else {
				echo "<div class='content'><center>You have to login first to view this page!<br/><a href='accounts.php'>Click here to login now >></a></center></div>";
			}
		}
	} else {
		if(isset($_SESSION['logged'])) {
			if($_SESSION['account']=="student" || $_SESSION['account']=="parents") {
				include_once "topper_students.php";
			} elseif($_SESSION['account']=="faculty" || $_SESSION['account']=="admin") {
				include_once "faculty_students.php";
			}
		} else {
				include_once "topper_students.php";
		}
	}
	?>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
