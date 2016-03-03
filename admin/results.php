<br/><h3>Results</h3><br/>
<?php
if(isset($_GET['job'])) {
	if($_GET['job']=="new") {
		if(isset($_GET['action'])) {
			if(carr($_GET)) {
				$br=strtolower($_GET['br']);$exty=strtolower($_GET['ex_ty']);$se=strtolower($_GET['se']);$exda=strtolower($_GET['ex_da']);$exsu=strtolower($_GET['ex_su']);$exto=strtolower($_GET['ex_to']);$exfa=strtolower($_GET['ex_fa']);
				mysql_select_db("idtsvbt_db_faculty");
				$resultid="$br$se$exty$exda"."_".time();
				$resultid=str_replace(" ","",$resultid);
				$resultid=str_replace("-","",$resultid);
				$resultid=str_replace("(","",$resultid);
				$resultid=str_replace(")","",$resultid);
                $exsu=trim($exsu,",;| ");
				$ins=mysql_query("insert into result_table(branch,sem,exam_date,type,result_date,result_id) values('$br','$se','$exda','$exty','".getdtime()."',\"$resultid\")");
				if(cerr()) {
					mysql_query("create table $resultid(id int(4) not null auto_increment unique,enrollno text,fname text,subjects text,marks text,outof text,fail text)");
					if(cerr()) {
						$exsu=str_replace(";","|",$exsu);
						$ins=mysql_query("insert into $resultid(enrollno,fname,subjects,outof,fail) values('00000','administrator','$exsu','$exto','$exfa')");
						if(cerr()) {
							echo "<div id='done'>New result is successfully declared!!<br/><a href='?page=results&job=add'>Now you can add student to this result by clicking here</a></div><br/>";
						} else {
							ms_err("3");
						}
					} else {
						ms_err("2");
					}
				} else {
					ms_err("1");
				}
			} else {
				echo "<div id='error'>You have to fill all the textbox(s) to add new result!!</div><br/>";
			}
		}
		?>
		<u><h5>New Result</h5></u><br/>
		<form method="get" style="text-align:left">
			<input type="hidden" name="page" value="results" />
			<input type="hidden" name="job" value="new" />
			<b>Select branch :-</b><br/>
			<select name="br" style="width:100%">
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
			</select><br/>
			<b>Semester :-</b><br/>
			<select name="se" style="width:100%">
				<?php
				for($i=1;$i<8;$i++) {
					echo "<option value='$i'>$i semester</option>";
				}
				?>
			</select><br/>
			<b>Examination date (DD-MM-YYYY) :-</b><br/><input type="text" name="ex_da" style="width:100%" /><br/>			
			<b>Examination type (internal, practical):-</b><br/><input type="text" name="ex_ty" style="width:100%" /><br/>
			<b>Subject names <span>(each subject separated by semi-colon ; ex. java;cpp;dcc;dbms)</span> :-</b><br/><input type="text" name="ex_su" style="width:100%" /><br/>
			<b>Total mark (only for one subject ex. 30) :-</b><br/><input type="text" name="ex_to" style="width:100%" /><br/>
			<b>Minimum mark for pass (ex. 12):-</b><br/><input type="text" name="ex_fa" style="width:100%" /><br/><br/>
			<input type="submit" name="action" value="Next" />
		</form>
		<?php
	} elseif($_GET['job']=="add") {
		if(isset($_GET['id'])) {
			$id=$_GET['id'];
			mysql_select_db("idtsvbt_db_faculty");
			$s=mysql_query("select * from result_table where id='$id'");
			if(cerr()) {
				$row=mysql_fetch_row($s);
				$rid=$row[6];
				$s1=mysql_query("select * from $rid where enrollno='00000'");
				$row1=mysql_fetch_row($s1);
				$subjs=explode("|",$row1[3]);
				if(isset($_POST['action'])) {
					if(carr($_POST)) {
						$nm=strtolower($_POST['nm']);$en=strtolower($_POST['en']);$tot_subj=count($subjs);
						$arr="";$marks="";
						for($i=0;$i<$tot_subj;$i++) {
							$arr[$i]=strtolower($_POST['s'.$i]);
                            if($arr[$i]>$row1[5] || $arr[$i]<0) {
                                die("Please enter mark in between 0 and $row1[5]!!<br/><a href='?page=results&job=add&id=$id'><< Go Back</a></div>");
                            }
							if(strlen($marks)==0) {
								$marks=$arr[$i];
							} else {
								$marks=$marks."|".$arr[$i];
							}
						}
						$ins=mysql_query("insert into $rid(enrollno,fname,subjects,marks,outof,fail) values('$en','$nm','$row1[3]','$marks','$row1[5]','$row1[6]')");						
						if(cerr()) {
							echo "<div id='done'>".strtoupper($nm)." having enrollment no $en is added!!</div><br/>";
						} else {
							ms_err("1");
						}
					} else {
						echo "<div id='error'>You have to fill all the textbox(s) to add student to existing result!!</div><br/>";
					}
				}
				echo "<form method='post' style='text-align:left'>";
				echo "<b>Name :-</b><br/><input type='text' name='nm' style='width:100%' /><br/>";
				echo "<b>Enrollment no :-</b><br/><input type='text' name='en' style='width:100%' /><br/>";
				for($i=0;$i<count($subjs);$i++) {
					echo "<b>Mark for ".strtoupper($subjs[$i])." in between 0 to $row1[5] :-</b><br/><input type='text' name='s$i' style='width:100%'/><br/>";
				}
				echo "<br/><input type='submit' name='action' value='Add' />";
				echo "</form>";
			} else {
				ms_err("1");
			}
		} else {
			echo "<u><h5>Add student to result</h5></u><br/>";
			?>
			<table class="mytable" cellspacing="0">
				<tr class="head">
					<td>Branch & Semester</td><td style="width:30%">Exam. date & Result date.</td><td style="width:20%">Exam. type</td>
				</tr>
				<?php
				mysql_select_db("idtsvbt_db_faculty");
				$sea=mysql_query("select * from result_table");
				if(cerr()) {
					while(($row=mysql_fetch_array($sea))) {
						echo "<tr><td><a href='?page=results&job=add&id=$row[0]'>".ucwords($row[1])."<br/>$row[2] semester</a></td><td><a href='?page=results&job=add&id=$row[0]'>".ucwords($row[3])."<br/>$row[5]</a></td><td><a href='?page=results&job=add&id=$row[0]'>".ucwords($row[4])."</a></td></tr>";
					}
				} else {
					ms_err("1");
				}
				?>
			</table>
		<?php
		}
	} else {
		echo "<u><h5>Delete result</h5></u><br/>";
		if(isset($_GET['id'])) {
			$id=$_GET['id'];
			if(isset($_POST['delete'])) {
				mysql_select_db("idtsvbt_db_faculty");
				$sea=mysql_query("select result_id from result_table where id='$id'");
				$row=mysql_fetch_row($sea);
				$rid=$row[0];
				$del1=mysql_query("delete from result_table where id='$id'");
				if(cerr()) {
					$del2=mysql_query("drop table $rid");
					if(cerr()) {
						echo "<div id='done'>Successfully deleted!!</div><br/>";
					} else {
						ms_err("2");
					}
				} else {
					ms_err("1");
				}
			} else {
			?>
			<div id='error'><h3><div>Are you sure to delete faculty now ?</div></h3><br/>
				<center>
					<form name="dform" id="dform" method="post"><input type="hidden" name="action" value="delete" /><input type="hidden" name="delete" value="yes" /></form>
					<div class="linkbox">
						<a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=results&job=delete">NO</a>
					</div>
				</center>
			</div>
			<?php
			}
		} else {
	?>
	<table class="mytable" cellspacing="0">
		<tr class="head">
			<td>Branch & Semester</td><td style="width:30%">Exam. date & Result date.</td><td style="width:20%">Exam. type</td>
		</tr>
		<?php
		mysql_select_db("idtsvbt_db_faculty");
		$sea=mysql_query("select * from result_table");
		if(cerr()) {
			while(($row=mysql_fetch_array($sea))) {
				echo "<tr><td><a href='?page=results&job=delete&id=$row[0]'>".ucwords($row[1])."<br/>$row[2] semester</a></td><td><a href='?page=results&job=delete&id=$row[0]'>".ucwords($row[3])."<br/>$row[5]</a></td><td><a href='?page=results&job=delete&id=$row[0]'>".ucwords($row[4])."</a></td></tr>";
			}
		} else {
			ms_err("1");
		}
		?>
	</table>
	<?php
		}
	}
}
?>
<br/><br/><hr/><br/><div class="linkbox">
	<a href="?page=results&job=new">New Result</a>
	<a href="?page=results&job=delete">Delete Result</a>
	<a href="?page=results&job=add">Add student to existing result</a>
</div>
