<br/><h3>Fees details</h3><br/>
<?php
if(isset($_GET['create'])) {
	if(isset($_POST['action'])) {
		if(carr($_POST)) {
			$nm=strtolower($_POST['nm']);$en=strtolower($_POST['en']);$br=strtolower($_POST['br']);$se=strtolower($_POST['se']);
			$fe=strtolower($_POST['fe']);$ld=strtolower($_POST['ld']);$su=strtolower($_POST['su']);			
			mysql_select_db("idtsvbt_db_faculty");
			$q=mysql_query("insert into fees_details(fname,enrollno,fees,submitted,branch,sem,ldate) values('$nm','$en','$fe','$su','$br','$se','$ld')");
			if(cerr()) {
				echo "<div id='done'>Added successfully!!</div><br/>";
			} else {
				ms_err("1");
			}
		} else {
			echo "<div id='error'>You have to fill all the textbox(s) to add new student!!</div><br/>";
		}
	}
?>
<form method="post" style="text-align:left">
	Name :-<br/><input type="text" name="nm" style="width:100%"/><br/>
	Enrollment no :-<br/><input type="text" name="en" style="width:100%"/><br/>
	Branch :-<br/>
		<select name="br" style="width:100%">
		<?php
			mysql_select_db("idtsvbt_db_faculty");
			$q=mysql_query("select distinct bname from branch");
			while(($dd=mysql_fetch_array($q))) {
					echo "<option value='$dd[0]'>".ucwords($dd[0])."</option>";
			}
		?>
	</select><br/>
	Semester :-<br/>
		<select name="se" style="width:100%">
		<?php
			for($i=1;$i<8;$i++) {
					echo "<option value='$i'>$i semester</option>";
			}
		?>
	</select><br/>
	Fees :-<br/><input type="text" name="fe" style="width:100%"/><br/>
	Last date :-<br/><input type="text" name="ld" style="width:100%"/><br/>
	Submitted :-<br/><select name="su" style="width:100%">
			<option value="yes" selected=selected>Yes</option><option value="no">No</option>
	</select><br/>
	<input type="submit" name="action" value="ADD" />
</form>
<?php
} else {
	mysql_select_db("idtsvbt_db_faculty");
	if(isset($_GET['id'])) {
		$id=$_GET['id'];
		if(isset($_POST['action'])) {
			if($_POST['action']=="Update") {
				if(carr($_POST)) {
					$nm=strtolower($_POST['nm']);$en=strtolower($_POST['en']);$br=strtolower($_POST['br']);$se=strtolower($_POST['se']);
					$fe=strtolower($_POST['fe']);$ld=strtolower($_POST['ld']);$su=strtolower($_POST['su']);
					$q=mysql_query("update fees_details set fname='$nm',enrollno='$en',branch='$br',sem='$se',fees='$fe',submitted='$su',ldate='$ld' where id='$id'");
					if(cerr()) {
						echo "<div id='done'>Updated successfully!!!</div><br/>";
					} else {
						ms_err("1");
					}
				} else {
					echo "<div id='error'>You have to fill all the textbox(s) to update fees detail!!</div><br/>";
				}
			} else {
                if(isset($_POST['delete'])) {
                    $q=mysql_query("delete from fees_details where id='$id'");
                    if(cerr()) {
                        echo "<div id='done'>Deleted successfully!!!</div><br/>";
                    } else {
                        ms_err("1");
                    }
                } else {
                ?>
                <div id='error'><h3><div>Are you sure to delete selected fees report now ?</div></h3><br/>
                    <center>
                        <form name="dform" id="dform" method="post"><input type="hidden" name="action" value="Delete" /><input type="hidden" name="delete" value="yes" /></form>
                        <div class="linkbox">
                            <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=fees">NO</a>
                        </div>
                    </center>
                </div>
                <?php
                }
			}
		} else {
            $q=mysql_query("select * from fees_details where id='$id'");
            if(cerr()) {
                $row=mysql_fetch_row($q);
                ?>
                <form method="post" style="text-align:left">
                    Name :-<br/><input type="text" name="nm" style="width:100%" value="<?=$row[1]?>" /><br/>
                    Enrollment no :-<br/><input type="text" name="en" style="width:100%" value="<?=$row[2]?>" /><br/>
                    Branch :-<br/>
                        <select name="br" style="width:100%">
                        <?php
                            $q=mysql_query("select distinct bname from branch");
                            while(($dd=mysql_fetch_array($q))) {
                                if($dd[0]==$row[3]) {
                                    echo "<option value='$dd[0]' selected=selected>".ucwords($dd[0])."</option>";							
                                } else {
                                    echo "<option value='$dd[0]'>".ucwords($dd[0])."</option>";
                                }
                            }
                        ?>
                    </select><br/>
                    Semester :-<br/>
                        <select name="se" style="width:100%">
                        <?php
                            for($i=1;$i<8;$i++) {
                                if($i==$row[4]) {
                                    echo "<option value='$i' selected=selected>$i semester</option>";
                                } else {
                                    echo "<option value='$i'>$i semester</option>";
                                }
                            }
                        ?>
                    </select><br/>
                    Fees :-<br/><input type="text" name="fe" style="width:100%" value="<?=$row[5]?>" /><br/>
                    Last date :-<br/><input type="text" name="ld" style="width:100%" value="<?=$row[7]?>" /><br/>
                    Submitted :-<br/><select name="su" style="width:100%">
                        <?php
                        if($row[6]=="yes") {
                        ?>
                            <option value="yes" selected=selected>Yes</option><option value="no">No</option>
                        <?php
                        } else {
                        ?>
                            <option value="yes">Yes</option><option value="no" selected=selected>No</option>
                        <?php } ?>
                    </select><br/>
                    <input type="submit" name="action" value="Update" /><input type="submit" name="action" value="Delete" />
                </form>
                <?php
            } else {
                ms_err("1");
            }
        }
	} else {
		if(isset($_POST['page'])) {
			$page=$_POST['page'];
		} else {
			$page=1;
		}
		if(isset($_POST['action'])) {
				if($_POST['action']=="Previous") {
					    $page--;
				} else {
					    $page++;
				}
		}
		$start=($page*40)-40;
		$count=mysql_query("select count(id) from fees_details");
		$row=mysql_fetch_row($count);
		$total=$row[0];
		$search=mysql_query("select * from fees_details order by id desc limit $start,40");
		if(cerr()) {
				if(mysql_affected_rows()==0) {
					    echo "<br/><center><div id='error'>Sorry you didnt added any fees-detail yet!</div><br/></center>";
				} else {
					    $data['current']=$page;
					    $data['total']=ceil($total/40);
		?>
		<div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
				<table cellspacing="0" class="mytable">
					    <tr class="head">
					            <td><b>Name:</b></td><td><b>Enrollment no:</b></td><td><b>Branch & Semester:</b></td><td><b>Submitted:</b></td>
					    </tr>
					    <?php while(($row=mysql_fetch_array($search))) { ?>
					            <tr><td><a href='?page=fees&id=<?=$row[0]?>'><?=ucwords($row[1])?></a></td><td><a href='?page=fees&id=<?=$row[0]?>'><?=ucwords($row[2])?></a></td><td><a href='?page=fees&id=<?=$row[0]?>'><?=ucwords($row[3])?><br>(<?=$row[4]?> sem.)</a></td><td><a href='?page=fees&id=<?=$row[0]?>'><?=ucwords($row[6])?></a></td></tr>
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
		}
	}
?>
<br/><div class="linkbox">
	<a href="?page=fees&create=yes">Add new student</a>
</div>
<?php
}
?>
