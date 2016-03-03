<br/><h3>Downloads</h3><br/>
<?php
if(isset($_GET['create'])) {
	if(isset($_POST['action'])) {
		if(carr($_POST)) {
			$dl=strtolower($_POST['dl']);$dd=strtolower($_POST['dd']);$dt=strtolower($_POST['dt']);
			$dl=str_replace(";","|",$dl);
            $data=explode("|",$dl);
            for($i=0;$i<count($data);$i++) {
                if(substr($data[$i],0,7)!="http://") {
                    $dl=str_replace($data[$i],"http://".$data[$i],$dl);
                }
            }
            $dl=trim($dl,",;|");
			mysql_select_db("idtsvbt_db_faculty");
			$q=mysql_query("insert into downloads(tdate,dtitle,ddesc,links,adder) values('".getdtime()."','$dt','$dd','$dl','admin')");
			if(cerr()) {
				echo "<div id='done'>Successfully added!!</div><br/>";
			} else {
				ms_err("1");
			}
		} else {
			echo "<div id='error'>You have to fill all the textbox(s) to add new download!!</div><br/>";
		}
	}
?>
<div style="text-align:left">
<form method="post">
	<table style="width:100%">
		<tr><td>Title :-<br/><input type="text" name="dt" style="width:100%" value="" /></td></tr>
		<tr><td>Description :-<br/><input type="text" name="dd" style="width:100%" value="" /></td></tr>
		<tr><td>Links :-<span>[ all links separated by semi-colon ; ]</span><br/><input type="text" name="dl" style="width:100%" value="" /></td></tr>
		<tr><td><input type="submit" name="action" value="ADD" /></td></tr>
	</table>
</form></div>
<?php
} else {
	mysql_select_db("idtsvbt_db_faculty");
	if(isset($_GET['id'])) {
		$id=$_GET['id'];
		if(isset($_POST['action'])) {
			if($_POST['action']=="Update") {
				$dt=strtolower($_POST['dt']);$dd=strtolower($_POST['dd']);$dl=strtolower($_POST['dl']);
				$dl=str_replace(";","|",$dl);
                $data=explode("|",$dl);
                for($i=0;$i<count($data);$i++) {
                    if(substr($data[$i],0,7)!="http://") {
                        $dl=str_replace($data[$i],"http://".$data[$i],$dl);
                    }
                }$dl=trim($dl,",;|");
				$q=mysql_query("update downloads set dtitle=\"$dt\",ddesc=\"$dd\",links=\"$dl\" where id='$id'");
				if(cerr()) {
					echo "<div id='done'>Successfully updated!!</div><br/>";
				} else {
					ms_err("1");
				}
			} elseif($_POST['action']=="Delete") {
                if(isset($_POST['delete'])) {
                    $q=mysql_query("delete from downloads where id='$id'");
                    if(cerr()) {
                        echo "<div id='done'>Successfully deleted!!</div><br/>";
                    } else {
                        ms_err("1");
                    }
                } else {
                ?>
                <div id='error'><h3><div>Are you sure to delete selected download now ?</div></h3><br/>
                    <center>
                        <form name="dform" id="dform" method="post"><input type="hidden" name="action" value="Delete" /><input type="hidden" name="delete" value="yes" /></form>
                        <div class="linkbox">
                            <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=downloads">NO</a>
                        </div>
                    </center>
                </div>
                <?php
                }
			}
		} else {
            $q=mysql_query("select * from downloads where id='$id'");
            if(cerr()) {
                $row=mysql_fetch_row($q);
                ?>
                <div style="text-align:left">
                <form method="post">
                    <table style="width:100%">
                        <tr><td>Title :-<br/><input type="text" name="dt" style="width:100%" value="<?=$row[2]?>" /></td></tr>
                        <tr><td>Description :-<br/><input type="text" name="dd" style="width:100%" value="<?=$row[3]?>" /></td></tr>
                        <tr><td>Links :-<span>[ all links separated by semi-colon ; ]</span><br/><input type="text" name="dl" style="width:100%" value="<?=str_replace("|",";",$row[4])?>" /></td></tr>
                        <tr><td><input type="submit" name="action" value="Update" /> <input type="submit" name="action" value="Delete" /></td></tr>
                    </table>
                </form></div>
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
		$count=mysql_query("select count(id) from downloads");
		$row=mysql_fetch_row($count);
		$total=$row[0];
		$search=mysql_query("select * from downloads order by id desc limit $start,40");
		if(cerr()) {
				if(mysql_affected_rows()==0) {
					    echo "<br/><center><div id='error'>Sorry you didnt added any download yet!</div><br/></center>";
				} else {
					    $data['current']=$page;
					    $data['total']=ceil($total/40);
		?>
		<div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
				<table cellspacing="0" class="mytable">
					    <tr class="head">
					            <td><b>Title:</b></td><td style="width:25%"><b>Adder:</b></td>
					    </tr>
					    <?php while(($row=mysql_fetch_array($search))) { ?>
					            <tr><td><a href='?page=downloads&id=<?=$row[0]?>'><?=strtoupper($row[2])?></a></td><td><a href='?page=downloads&id=<?=$row[0]?>'><?=strtoupper($row[5])?></a></td></tr>
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
	<br/><div class="linkbox"><a href="?page=downloads&create=yes">Add new download</a></div>
<?php
}
?>
