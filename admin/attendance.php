<br/><h3>Attendance</h3><br/>
<?php
if(isset($_GET['job'])) {
	if($_GET['job']=="take") {
		if(isset($_POST['action'])) {
			if(carr($_POST)) {
				$sn=strtolower($_POST['sn']);$en=strtolower($_POST['en']);$su=strtolower($_POST['su']);$pe=strtolower($_POST['pe']);$no=strtolower($_POST['no']);
				$su=str_replace(";","|",$su);$pe=str_replace(";","|",$pe);
				mysql_select_db("idtsvbt_db_faculty");
                $su=trim($su,",;| ");
                $pe=trim($pe,",;| ");
				$ins=mysql_query("insert into attendance(fname,enrollno,udate,subjects,percentages,notice,crit) values('$sn','$en','".getdtime()."','$su','$pe','$no','75')");
				if(cerr()) {
					echo "<div id='done'>Attendance taken successfully!!</div><br/>";
				} else {
					ms_err("1");
				}
			} else {
				echo "<div id='error'>You have to fill all the textbox(s) to take attendance!!</div><br/>";
			}
		}
		?>
		<h5><u>Take attendance</u></h5><br/>
		<form method="post" style="text-align:left">
			<b>Student name :-</b><br/><input type="text" name="sn" style="width:100%" /><br/>
			<b>Enrollment no :-</b><br/><input type="text" name="en" style="width:100%" /><br/>
			<b>Subjects :-</b> <span>[ subjects are separated by semi-colon ; exa: subject1;subejct2;subject3]</span><br/><input type="text" name="su" style="width:100%" /><br/>
			<b>Percentages :-</b> <span>[ percentages are separated by semi-colon ; as subjects]</span><br/><input type="text" name="pe" style="width:100%" /><br/>
			<b>Notice :-</b><br/><input type="text" name="no" style="width:100%" /><br/><br/>
			<input type="submit" name="action" value="Submit" />
		</form>
		<?php
	} else {
		if(isset($_GET['en'])) {
			$en=strtolower($_GET['en']);
			mysql_select_db("idtsvbt_db_faculty");
			if(isset($_POST['action'])) {
				if($_POST['action']=="Update") {
					$enr=strtolower($_POST['en']);$sn=strtolower($_POST['sn']);$su=strtolower($_POST['su']);$pe=strtolower($_POST['pe']);$no=strtolower($_POST['no']);$aid=$_POST['aid'];
					$su=str_replace(";","|",$su);$pe=str_replace(";","|",$pe);
                    $su=trim($su,",;| ");
                    $pe=trim($pe,",;| ");
					$upd=mysql_query("update attendance set fname='$sn',enrollno='$enr',subjects='$su',percentages='$pe',notice='$no' where id='$aid'");
					if(cerr()) {
						echo "<div id='done'>Updated successfully!!</div><br/>";
					} else {
						ms_err("1");
					}
				} else {
                    if(isset($_POST['delete'])) {
                        $aid=$_POST['aid'];
                        $del=mysql_query("delete from attendance where enrollno='$aid'");
                        if(cerr()) {
                            echo "<div id='done'>Successfully deleted!!</div><br/>";
                        } else {
                            ms_err("1");
                        }
                    } else {
                    ?>
                    <div id='error'><h3><div>Are you sure to delete selected attendance report now ?</div></h3><br/>
                        <center>
                            <form name="dform" id="dform" method="post"><input type="hidden" name="aid" value="<?=$en?>" /><input type="hidden" name="action" value="Delete" /><input type="hidden" name="delete" value="yes" /></form>
                            <div class="linkbox">
                                <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?job=update&page=attendance&en=<?=$en?>">NO</a>
                            </div>
                        </center>
                    </div>
                    <?php
                    }
				}
			} else {
                $q=mysql_query("select * from attendance where enrollno='$en'");
                if(cerr()) {
                    if(mysql_affected_rows()==0) {
                        echo "<div id='warning'>No student found who have this enrollment no!!</div><br/>";
                    } else {
                        $row=mysql_fetch_row($q);
                        ?>
                        <h5><u>Update attendance</u></h5><br/>
                        <form method="post" style="text-align:left">
                            <input type="hidden" name="aid" value="<?=$row[0]?>" />
                            <b>Student name :-</b><br/><input type="text" name="sn" style="width:100%" value="<?=$row[1]?>" /><br/>
                            <b>Enrollment no :-</b><br/><input type="text" name="en" style="width:100%" value="<?=$row[2]?>" /><br/>
                            <b>Subjects :-</b> <span>[ subjects are separated by semi-colon ; exa: subject1;subejct2;subject3]</span><br/><input type="text" name="su" style="width:100%" value="<?=str_replace("|",";",$row[4])?>" /><br/>
                            <b>Percentages :-</b> <span>[ percentages are separated by semi-colon ; as subjects]</span><br/><input type="text" name="pe" style="width:100%" value="<?=str_replace("|",";",$row[5])?>" /><br/>
                            <b>Notice :-</b><br/><input type="text" name="no" style="width:100%" value="<?=$row[6]?>" /><br/><br/>
                            <input type="submit" name="action" value="Update" /> <input type="submit" name="action" value="Delete" />
                        </form>				
                        <?php
                    }
                } else {
                    ms_err("1");
                }
            }
		} else {
			echo "<form style='text-align:left'>";
			echo "<input type='hidden' name='job' value='update' /><input type='hidden' name='page' value='attendance' />";
			echo "<b>Enter enrollment no :-</b><br/><input type='text' name='en' style='width:90%' /><input type='submit' value='Go' />";
			echo "</form>";
		}
	}
} else {
?>
<div class="linkbox">
	<a href="?page=attendance&job=take">Take attendance</a>
	<a href="?page=attendance&job=update">Update attendance</a>
</div>
<?php } ?>
