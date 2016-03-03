<br/><h3>Pages</h3><br/>
<?php
if(isset($_GET['create'])) {
	if(isset($_POST['submit'])) {
		if(carr($_POST))	{
			mysql_select_db("idtsvbt_db_faculty");
			$pt=strtolower($_POST['pt']);$pd=strtolower($_POST['pd']);$pb=strtolower($_POST['pb']);$pa=strtolower($_POST['pa']);
			$qu=mysql_query("insert into pages(title,pdesc,body,auth,adder) values('$pt','$pd','$pb','$pa','admin')");
			if(cerr()) {
				echo "<div id='done'>Added sucessfully!!</div><br/>";
			} else {
				ms_err("1");
			}
		} else {
			echo "<div id='error'>You have to fill all the textbox(s) to create new page!!</div>";
		}
	}
	?>
	<form method="post"><table>
		<tr><td>Title :-<br/><input type="text" name="pt" value="" style="width:400px"/></td></tr>
		<tr><td>Description :-<br/><input type="text" name="pd" value="" style="width:400px"/></td></tr>
		<tr><td>Body :-<br/><textarea name="pb" style="width:400px"></textarea></td></tr>
		<tr><td>Login required :-<br/><select name="pa" style="width:400px"><option value="yes">Yes</option><option value="no">No</option></select></td></tr>
		<tr><td><br/><input type="submit" name="submit" value="Add"/> <input type="reset" value="Reset"/></td></tr>
	</table></form>
	<?php
} else {
	$_GLOBEL['row']="";
    mysql_select_db("idtsvbt_db_faculty");
	if(isset($_GET['id'])) {
		$id=$_GET['id'];
		if(isset($_POST['asubmit'])) {
			if($_POST['asubmit']=="Update") {
				if(carr($_POST)) {
					$pt=strtolower($_POST['pt']);$pd=strtolower($_POST['pd']);$pb=strtolower($_POST['pb']);$pa=strtolower($_POST['pa']);
					$qu=mysql_query("update pages set title='$pt',pdesc='$pd',body='$pb',auth='$pa' where id='$id'");
					if(cerr()) {
						echo "<div id='done'>Updated sucessfully!!</div><br/>";
					} else {
						ms_err("1");
					}
				} else {
					echo "<div id='error'>You have to fill all the textbox(s) to update page!!</div><br/>";
				}
			} elseif($_POST['asubmit']=="Delete") {
                if(isset($_POST['delete'])) {
                    $qu=mysql_query("delete from pages where id='$id'");
                    if(cerr()) {
                        echo "<div id='done'>Deleted sucessfully!!</div><br/>";
                    } else {
                        ms_err("1");
                    }
                } else {
                ?>
                <div id='error'><h3><div>Are you sure to delete selected page now ?</div></h3><br/>
                    <center>
                        <form name="dform" id="dform" method="post"><input type="hidden" name="asubmit" value="Delete" /><input type="hidden" name="delete" value="yes" /></form>
                        <div class="linkbox">
                            <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=pages">NO</a>
                        </div>
                    </center>
                </div>
                <?php
                }
			}
		} else {
            $qu=mysql_query("select * from pages where id='$id'");
            if(cerr()) {
                $row=mysql_fetch_row($qu);
                ?>
                <form method="post"><table>
                    <tr><td>Title :-<br/><input type="text" name="pt" value="<?=$row[1]?>" style="width:400px"/></td></tr>
                    <tr><td>Description :-<br/><input type="text" name="pd" value="<?=$row[4]?>" style="width:400px"/></td></tr>
                    <tr><td>Body :-<br/><textarea name="pb" style="width:400px"><?=$row[2]?></textarea></td></tr>
                    <tr><td>Login required :-<br/><select name="pa" style="width:400px"><option value="yes">Yes</option><option value="no">No</option></select></td></tr>
                    <tr><td><br/><input type="submit" name="asubmit" value="Update"/> <input type="submit" name="asubmit" value="Delete"/><br/><br/><div class="linkbox"><a href="index.php?pageid=<?=$id?>">Visit now >></a></div></td></tr>
                </table></form>
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
		$start=($page*10)-10;
		$count=mysql_query("select count(id) from pages");
		$row=mysql_fetch_row($count);
		$total=$row[0];
		$search=mysql_query("select * from pages order by id desc limit $start,10");
		if(cerr()) {
		        if(mysql_affected_rows()==0) {
		                echo "<br/><center><div id='error'>Sorry you didnt added any page yet!</div><br/></center>";
		        } else {
		                $data['current']=$page;
		                $data['total']=ceil($total/10);
		?>
		<div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
		        <table cellspacing="0" class="mytable">
		                <tr class="head">
		                        <td style="width:20%"><b>Title:</b></td><td style="width:60%"><b>Description:</b></td><td style="width:20%">Adder.</td>
		                </tr>
		                <?php while(($row=mysql_fetch_array($search))) { ?>
		                        <tr><td><a href='?page=pages&id=<?=$row[0]?>'><?=$row[1]?></a></td><td><a href='?page=pages&id=<?=$row[0]?>'><?=$row[4]?></a></td><td><a href='?page=pages&id=<?=$row[0]?>'><?=$row[5]?></a></td></tr>
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
	<a href="accounts.php?page=pages&create=yes">Create new page</a>
</div>
<?php
}
?>
