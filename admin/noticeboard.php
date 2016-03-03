<br/><h3>Notice board</h3><br/>
<?php
if(isset($_GET['create'])) {
	if(isset($_POST['action'])) {
		$br=strtolower($_POST['br']);$se=strtolower($_POST['se']);$de=strtolower($_POST['de']);$li=strtolower($_POST['li']);$adder="admin";
        if(substr($li,0,7)!="http://") {
            $li="http://".$li;
        }
		mysql_select_db("idtsvbt_db_faculty");
		$ins=mysql_query("insert into notice_board(ndate,branch,sem,link,ndesc,adder) values('".getdtime()."','$br','$se','$li','$de','$adder')");
		if(cerr()) {
			echo "<div id='done'>Successfully added!!</div><br/>";
		} else {
			ms_err("1");
		}
	}
?>
<form method="post" style="text-align: left">
	<b>Branch name :-</b><br/>
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

	<b>Description (Notice) :-</b><br/>
		<input type="text" name="de" style="width:100%" />
	<b>Link :-</b><br/>
		<input type="text" name="li" style="width:100%" /><br/><br/>
	<input type="submit" name="action" value="ADD" />
</form>
<?php
} else {
	if(isset($_GET['id'])) {
		$id=$_GET['id'];
		mysql_select_db("idtsvbt_db_faculty");
		if(isset($_POST['action'])) {
			if($_POST['action']=="Update") {
				if(carr($_POST)) {
					$br=strtolower($_POST['br']);$se=strtolower($_POST['se']);$de=strtolower($_POST['de']);$li=strtolower($_POST['li']);
                    if(substr($li,0,7)!="http://") {
                        $li="http://".$li;
                    }
					$upd=mysql_query("update notice_board set branch='$br',sem='$se',link='$li' where id='$id'");
					if(cerr()) {
						echo "<div id='done'>Updated successfully!!</div><br/>";
					} else {
						ms_err("1");
					}
				} else {
					echo "<div id='error'>You have to fill all the textbox(s) to update notice!!</div><br/>";
				}
			} else {
                if(isset($_POST['delete'])) {
                    $del=mysql_query("delete from notice_board where id='$id'");
                    if(cerr()) {
                        echo "<div id='done'>Deleted successfully</div><br/>";
                    } else {
                        ms_err("1");
                    }
                } else {
                ?>
                <div id='error'><h3><div>Are you sure to delete selected notice now ?</div></h3><br/>
                    <center>
                        <form name="dform" id="dform" method="post"><input type="hidden" name="action" value="Delete" /><input type="hidden" name="delete" value="yes" /></form>
                        <div class="linkbox">
                            <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=noticeboard">NO</a>
                        </div>
                    </center>
                </div>
                <?php
                }
			}
		} else {
            $q=mysql_query("select * from notice_board where id='$id'");
            if(cerr()) {
                $rows=mysql_fetch_row($q);
                ?>
                <form method="post" style="text-align: left">
                    <b>Branch name :-</b><br/>
                        <select name="br" style="width:100%">
                            <?php
                            mysql_select_db("idtsvbt_db_faculty");
                            $q=mysql_query("select distinct bname from branch");
                            if(cerr()) {
                                while(($row=mysql_fetch_array($q))) {
                                    if($rows[3]==$row[0]) {
                                        echo "<option value='$row[0]' selected=selected>".ucwords($row[0])."</option>";															
                                    } else {
                                        echo "<option value='$row[0]'>".ucwords($row[0])."</option>";
                                    }
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
                                if($rows[4]==$i) {
                                    echo "<option value='$i' selected=selected>$i semester</option>";
                                } else {
                                    echo "<option value='$i'>$i semester</option>";
                                }
                            }
                            ?>
                        </select><br/>

                    <b>Description (Notice) :-</b><br/>
                        <input type="text" name="de" style="width:100%" value="<?=$rows[2]?>"/>
                    <b>Link :-</b><br/>
                        <input type="text" name="li" style="width:100%" value="<?=$rows[5]?>"/><br/><br/>
                    <input type="submit" name="action" value="Update" /> <input type="submit" name="action" value="Delete" />
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
		mysql_select_db("idtsvbt_db_faculty");
		$start=($page*40)-40;
		$count=mysql_query("select count(id) from notice_board");
		$row=mysql_fetch_row($count);
		$total=$row[0];
		$search=mysql_query("select * from notice_board order by id desc limit $start,40");
		if(cerr()) {
		        if(mysql_affected_rows()==0) {
		                echo "<br/><center><div id='error'>Sorry you didnt added any notice yet!</div><br/></center>";
		        } else {
		                $data['current']=$page;
		                $data['total']=ceil($total/40);
		?>
		<div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
		        <table cellspacing="0" class="mytable">
		                <tr class="head">
		                    <td style="width:10%"><b>Date :</b></td><td><b>Description :</b></td><td style="width:20%"><b>Branch & Semester :</b></td><td style="width:20%"><b>Adder :</b></td>
		                </tr>
		                <?php while(($row=mysql_fetch_array($search))) {?>
		                <tr><td><a href='?page=noticeboard&id=<?=$row[0]?>'><?=ucwords($row[1])?></a></td><td><a href='?page=noticeboard&id=<?=$row[0]?>'><?=$row[2]?> semester</a></td><td><a href='?page=noticeboard&id=<?=$row[0]?>'><?=strtoupper($row[3])."<br>".$row[4]." sem."?></a></td><td><a href="?page=noticeboard&id=<?=$row[0]?>"><?=strtoupper($row[6])?></a></td></tr>
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
		<a href="?page=noticeboard&create=yes">Add new notice</a>
	</div>
<?php } ?>
