<br/><h3>Latest news</h3><br/>
<?php
if(isset($_GET['create'])) {
	if(isset($_POST['submit'])) {
		if(carr($_POST)) {
			mysql_select_db("idtsvbt_db_faculty");
			$nt=strtolower($_POST['nt']);$nl=strtolower($_POST['nl']);
			if(substr($nl,0,7)!="http://") {
                $nl="http://".$nl;
            }
			$q=mysql_query("insert into latest_news(title,link) values('$nt','$nl')");
			if(cerr()) {
				echo "<div id='done'>Added successfully!!</div><br/>";
			} else {
				ms_err("1");
			}
		} else {
			echo "<div id='error'>You have to fill all the textbox(s) to add new news!!</div>";
		}
	}
?>
	<form method="post"><table>
		<tr><td>News title :-<br/><input type="text" name="nt" style="width:400px" /></td></tr>
		<tr><td>News link :-<br/><input type="text" name="nl" style="width:400px" value="http://"/></td></tr>
		<tr><td><br/><input type="submit" name="submit" value="Add" /></td></tr>
	</table></form>
<?php	
} else {
?>
<?php
	if(isset($_GET['id'])) {
		$id=$_GET['id'];
		if(isset($_POST['asubmit'])) {
			if($_POST['asubmit']=="Update") {
				mysql_select_db("idtsvbt_db_faculty");
				if(carr($_POST)) {
					$nt=strtolower($_POST['nt']);$nl=strtolower($_POST['nl']);
                    if(substr($nl,0,7)!="http://") {
                        $nl="http://".$nl;
                    }
					$q=mysql_query("update latest_news set title='$nt',link='$nl' where id='$id'");
					if(cerr()) {
						echo "<div id='done'>Successfully updated!!</div><br/>";
					} else {
						ms_err("1");
					}
				} else {
					echo "<div id='error'>You have to fill all the textbox(s) to update it!!</div><br/>";
				}
			} elseif($_POST['asubmit']=="Delete") {
                if(isset($_POST['delete'])) {
                    mysql_select_db("idtsvbt_db_faculty");
                    $q=mysql_query("delete from latest_news where id='$id'");
                    if(cerr()) {
                        echo "<div id='done'>Successfully deleted!!</div><br/>";
                    } else {
                        ms_err("1");
                    }
                } else {
                ?>
                <div id='error'><h3><div>Are you sure to delete selected news now ?</div></h3><br/>
                    <center>
                        <form name="dform" id="dform" method="post"><input type="hidden" name="asubmit" value="Delete" /><input type="hidden" name="delete" value="yes" /></form>
                        <div class="linkbox">
                            <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=news">NO</a>
                        </div>
                    </center>
                </div>
                <?php
                }
			}
		} else {
            mysql_select_db("idtsvbt_db_faculty");
            $q=mysql_query("select * from latest_news where id='$id'");
            if(cerr()) {
                if(mysql_affected_rows()==0) {
                    echo "<div id='error'>Sorry, selected identifier not found!!</div><br/>";
                } else {
                    $row=mysql_fetch_row($q);
                    ?>
                    <form method="post"><table>
                        <tr><td>News title :-<br/><input type="text" name="nt" style="width:400px" value="<?=$row[1]?>" /></td></tr>
                        <tr><td>News link :-<br/><input type="text" name="nl" style="width:400px" value="<?=$row[2]?>" /></td></tr>
                        <tr><td><br/><input type="submit" name="asubmit" value="Update" /> <input type="submit" name="asubmit" value="Delete" /></td></tr>
                    </table></form>
                    <?php
                }
            } else {
                ms_err("1");
            }
        }
	} else {
		mysql_select_db("idtsvbt_db_faculty");
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
		$start=($page*10)-10;
		$count=mysql_query("select count(id) from latest_news");
		$row=mysql_fetch_row($count);
		$total=$row[0];
		$search=mysql_query("select * from latest_news order by id desc limit $start,10");
		if(cerr()) {
			    if(mysql_affected_rows()==0) {
			            echo "<br/><center><div id='error'>Sorry you didnt added any news yet!</div><br/></center>";
			    } else {
			            $data['current']=$page;
			            $data['total']=ceil($total/10);
		?>
		<div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
			    <table cellspacing="0" class="mytable">
			            <tr class="head">
			                    <td><b>Title:</b></td>
			            </tr>
			            <?php while(($row=mysql_fetch_array($search))) { ?>
			                    <tr><td><a href='?page=news&id=<?=$row[0]?>'><?=$row[1]?></a></td></tr>
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
	<a href="accounts.php?page=news&create=yes">Add news</a>
</div>
<?php 
}
?>
