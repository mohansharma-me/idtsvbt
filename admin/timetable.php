<br/><h3>Time table</h3><br/>
<?php
if(isset($_GET['create'])) {
    if(isset($_POST['action'])) {
        mysql_select_db("idtsvbt_db_faculty");
        if(carr($_POST)) {
            $br=strtolower($_POST['br']);$ba=strtolower($_POST['ba']);$li=strtolower($_POST['li']);$se=strtolower($_POST['se']);
            $ba=str_replace(";","|",$ba);$li=str_replace(";","|",$li);
            $data=explode("|",$li);
            for($i=0;$i<count($data);$i++) {
                if(substr($data[$i],0,7)!="http://") {
                    $li=str_replace($data[$i],"http://".$data[$i],$li);
                }
            }
            $ba=trim($ba,",;| ");
            $li=trim($li,",;| ");
            
            $qq=mysql_query("insert into timetable(branch,sem,titles,links) values('$br','$se','$ba','$li')");
            if(cerr()) {
                echo "<div id='done'>Successfully added!!</div><br/>";
            } else {
                ms_err("1");
            }
        } else {
            echo "<div id='error'>You have to fill all the textbox(s) to add new timetable!!</div><br/>";
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
    <b>Group name :- <span>[ group name separated by semi-colon ;]</span></b><br/>
        <input type="text" name="ba" style="width:100%"/>
    <b>Links :- <span>[ links are separated by by semi-colon ; according to group name]</span></b><br/>
        <input type="text" name="li" style="width:100%"/><br/><br/>
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
                    $br=strtolower($_POST['br']);$se=strtolower($_POST['se']);$ba=strtolower($_POST['ba']);$li=strtolower($_POST['li']);
                    $ba=str_replace(";","|",$ba);
                    $li=str_replace(";","|",$li);
                    $data=explode("|",$li);
                    for($i=0;$i<count($data);$i++) {
                        if(substr($data[$i],0,7)!="http://") {
                            $li=str_replace($data[$i],"http://".$data[$i],$li);
                        }
                    }
                    $ba=trim($ba,",;| ");
                    $li=trim($li,",;| ");
            
                    $upd=mysql_query("update timetable set branch='$br',sem='$se',titles='$ba',links='$li' where id='$id'");
                    if(cerr()) {
                        echo "<div id='done'>Successfully updated!!</div><br/>";
                    } else {
                        ms_err("1");
                    }
                } else {
                    echo "<div id='error'>You have to fill all the textbox(s) to update timetable!!</div><br/>";
                }
            } else {
                if(isset($_POST['delete'])) {
                    $qq=mysql_query("delete from timetable where id='$id'");
                    if(cerr()) {
                        echo "<div id='done'>Successfully deleted!!</div><br/>";
                    } else {
                        ms_err("1");
                    }
                } else {
                ?>
                <div id='error'><h3><div>Are you sure to delete selected timetable now ?</div></h3><br/>
                    <center>
                        <form name="dform" id="dform" method="post"><input type="hidden" name="action" value="Delete" /><input type="hidden" name="delete" value="yes" /></form>
                        <div class="linkbox">
                            <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=timetable">NO</a>
                        </div>
                    </center>
                </div>
                <?php
                }
            }
        } else {
            $qq=mysql_query("select * from timetable where id='$id'");
            if(cerr()) {
                $dr=mysql_fetch_row($qq);
            ?>
            <form method="post" style="text-align: left">
                <b>Branch name :-</b><br/>
                    <select name="br" style="width:100%">
                        <?php
                        $q=mysql_query("select distinct bname from branch");
                        if(cerr()) {
                            while(($row=mysql_fetch_array($q))) {
                                if($row[0]==$dr[1]) {
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
                            if($dr[2]==$i) {
                                echo "<option value='$i' selected=selected>$i semester</option>";
                            } else {
                                echo "<option value='$i'>$i semester</option>";
                            }
                        }
                        ?>
                    </select><br/>
                <b>Group name :- <span>[ group name separated by semi-colon ;]</span></b><br/>
                    <input type="text" name="ba" style="width:100%" value="<?=str_replace("|",";",$dr[3])?>"/>
                <b>Links :- <span>[ links are separated by by semi-colon ; according to group name ]</span></b><br/>
                    <input type="text" name="li" style="width:100%" value="<?=str_replace("|",";",$dr[4])?>"/><br/><br/>
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
        $count=mysql_query("select count(id) from timetable");
        $row=mysql_fetch_row($count);
        $total=$row[0];
        $search=mysql_query("select * from timetable order by id desc limit $start,40");
        if(cerr()) {
                if(mysql_affected_rows()==0) {
                        echo "<br/><center><div id='error'>Sorry you didnt added any timetable yet!</div><br/></center>";
                } else {
                        $data['current']=$page;
                        $data['total']=ceil($total/40);
        ?>
        <div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
                <table cellspacing="0" class="mytable">
                        <tr class="head">
                            <td><b>Branch name:</b></td><td><b>Semester :</b></td><td><b>Timetables :</b></td>
                        </tr>
                        <?php while(($row=mysql_fetch_array($search))) { $rr=  str_replace("|", ",", $row[3]);?>
                        <tr><td><a href='?page=timetable&id=<?=$row[0]?>'><?=ucwords($row[1])?></a></td><td><a href='?page=timetable&id=<?=$row[0]?>'><?=$row[2]?> semester</a></td><td><a href='?page=timetable&id=<?=$row[0]?>'><?=strtoupper($rr)?></a></td></tr>
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
        <a href="?page=timetable&create=yes">Add new timetable</a>
    </div>
<?php
}
?>