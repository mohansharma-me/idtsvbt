<br/><h3>College Circular</h3><br/>
<?php
if(isset($_GET['create'])) {
    if(isset($_POST['action'])) {
        if(carr($_POST)) {
            $cd=strtolower($_POST['cd']);
            $cl=strtolower($_POST['cl']);
            if(substr($cl, 0, 7) !="http://") {
                $cl="http://".$cl;
            }
            mysql_select_db("idtsvbt_db_faculty");
            $q=mysql_query("insert into circular(cdate,cdesc,link) values('".getdtime()."',\"$cd\",\"$cl\")");
            if(cerr()) {
                echo "<div id='done'>Successfully added!!</div><br/>";
            } else {
                ms_err("1");
            }
        } else {
            echo "<div id='error'>You have to fill all the textbox(s) to add new circular!!</div><br/>";
        }
    }
    ?>
    <div style="text-align:left">
        <form method="post">
            <table style="width:100%">
                <tr><td>Circular Description :-<br/><input type="text" name="cd" style="width:100%" /></td></tr>
                <tr><td>Circular Link :-<br/><input type="text" name="cl" style="width:100%" /></td></tr>
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
                $cd=strtolower($_POST['cd']);
                $cl=strtolower($_POST['cl']);
                if(substr($cl, 0, 7) !="http://") {
                    $cl="http://".$cl;
                }
                $q=mysql_query("update circular set cdesc=\"$cd\",link=\"$cl\" where id='$id'");
                if(cerr()) {
                    echo "<div id='done'>Successfully updated!!</div><br/>";
                } else {
                    ms_err("1");
                }
            } elseif($_POST['action']=="Delete") {
                if(isset($_POST['delete'])) {
                    $q=mysql_query("delete from circular where id='$id'");
                    if(cerr()) {
                        echo "<div id='done'>Successfully deleted!!</div><br/>";
                    } else {
                        ms_err("1");
                    }
                } else {
                ?>
                <div id='error'><h3><div>Are you sure to delete circular now ?</div></h3><br/>
                    <center><? // asdadnakjsdnas ?>
                        <form name="dform" id="dform" method="post"><input type="hidden" name="action" value="Delete" /><input type="hidden" name="delete" value="yes" /></form>
                        <div class="linkbox">
                            <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=circulars&job=delete">NO</a>
                        </div>
                    </center>
                </div>
                <?php
                }
            }
        } else {
            $q=mysql_query("select * from circular where id='$id'");
            if(cerr()) {
                $row=mysql_fetch_row($q);
                ?>
                <div style="text-align:left">
                    <form method="post">
                        <table style="width:100%">
                            <tr><td>Circular Description :-<br/><input type="text" name="cd" style="width:100%" value="<?=$row[2] ?>" /></td></tr>
                            <tr><td>Circular Link :-<br/><input type="text" name="cl" style="width:100%" value="<?=$row[3] ?>" /></td></tr>
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
        $start=($page * 40) - 40;
        $count=mysql_query("select count(id) from circular");
        $row=mysql_fetch_row($count);
        $total=$row[0];
        $search=mysql_query("select * from circular order by id desc limit $start,40");
        if(cerr()) {
            if(mysql_affected_rows()==0) {
                echo "<br/><center><div id='error'>Sorry you didnt added any circular yet!</div><br/></center>";
            } else {
                $data['current']=$page;
                $data['total']=ceil($total / 40);
                ?>
                <div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
                    <table cellspacing="0" class="mytable">
                        <tr class="head">
                            <td style="width:20%"><b>Date:</b></td><td><b>Description:</b></td>
                        </tr>
                        <?php while (($row=mysql_fetch_array($search))) { ?>
                            <tr><td><a href='?page=circulars&id=<?=$row[0] ?>'><?=$row[1] ?></a></td><td><a href='?page=circulars&id=<?=$row[0] ?>'><?=$row[2] ?></a></td></tr>
                <?php } ?>
                    </table>
                </div>
                <br/>
                <center><form method="post">
                        <input type="hidden" name="page" value="<?=$page ?>"/>
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
    <br/><div class="linkbox"><a href="?page=circulars&create=yes">Add new circular</a></div>
    <?php
}
?>
