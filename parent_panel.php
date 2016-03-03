<div class="sidebar-right">
	<h3>Control Panel</h3>
	<hr/>
	<div align=left style="padding-left:20px;height:auto" class="msgs">
		<li><a href="accounts.php" id="<?php !isset($_GET['tab'])?"current":"";?>">Profile</a></li>
		<li><a href="?tab=settings" id="<?php isset($_GET['tab']) && $_GET['tab']=="settings"?"current":"";?>">Settings</a></li>
		<li><a href="?tab=attendance" id="<?php isset($_GET['tab']) && $_GET['tab']=="attendance"?"current":"";?>">Attendance</a></li>
		<li><a href="?tab=result" id="<?php isset($_GET['tab']) && $_GET['tab']=="result"?"current":"";?>">Result</a></li>
		<li><a href="?tab=messages" id="<?php isset($_GET['tab']) && $_GET['tab']=="messages"?"current":"";?>">Messages</a></li>
		<li><a href="?tab=notice" id="<?php isset($_GET['tab']) && $_GET['tab']=="notice"?"current":"";?>">Notice Board</a></li>
		<li><a href="?tab=fees" id="<?php isset($_GET['tab']) && $_GET['tab']=="fees"?"current":"";?>">Fees details</a></li>
		<li><a href="?tab=timetable" id="<?php isset($_GET['tab']) && $_GET['tab']=="timetable"?"current":"";?>">Time Table</a></li>
		<li><a href="accounts.php?logout=<?php echo $_SESSION['id']; ?>">Logout</a></li>
	</div>
</div>
<div class="sidebar-left">
<center><h4>Welcome <?=$_SESSION['username']?> as  <?=ucwords($_SESSION['account'])?>.</h4><hr/>
<?php
$acc_id=$_SESSION['acc_id'];
include_once 'settings.php';
$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
if(isset($_GET['tab'])) {
    $tab=strtolower($_GET['tab']);
    if($tab=="settings") {
        if(isset($_GET['action'])) {
            if($_GET['action']=="change") {
?>
<table class="mytable" style="width:100%" cellspacing="0">
    <tr class="head"><td><center>Change password</center></td></tr>
</table>
<?php
if(isset($_POST['opass']) && isset($_POST['npass'])) {
    $opass=strtolower($_POST['opass']);$npass=strtolower($_POST['npass']);
    mysql_select_db("idtsvbt_db_faculty");
    $search=mysql_query("select password from login where id='$acc_id'");
    if(cerr()) {
        $row=mysql_fetch_row($search);
        $dpass=$row[0];
        if($opass==$dpass) {
            $update=mysql_query("update login set password='$npass' where id='$acc_id'");
            if(cerr()) {
                echo "<div id='done' style='width:80%'>Password changed!</div>";
            } else {
                ms_err("2");
            }
        } else {
            echo "<div id='error' style='width:80%'>Your entered old password is incorrect.</div><br/>";
        }
    } else {
        ms_err("1");
    }
}
?>
<form method="post">
<table class="mytable" style="width:100%" cellspacing="0">
    <tr class="head">
        <td style="width:20%">Old Password :- </td><td><input type="password" name="opass" style="width:600px"/></td>
    </tr>
    <tr class="head">
        <td style="width:20%">New Password :- </td><td><input type="password" name="npass" style="width:600px"/></td>
    </tr>
    <tr class="head">
        <td style="width:20%"> </td><td><input type="submit" value="Save changes"/> <input type="button" onclick="document.location='?tab=settings'" value="Cancel changes"/></td>
    </tr>    
</table>
</form>
<?php
            } elseif($_GET['action']=="delete") {
                ?>
                <div id='error'><h3><div>Are you sure to delete your <?=$_SESSION['account']?> account now ?</div></h3><br/>
                    <center>
                        <?php
                        if(isset($_POST['password'])) {
                            $password=strtolower($_POST['password']);
                            if(carr($_POST)) {
                                mysql_select_db("idtsvbt_db_faculty");
                                $search=mysql_query("select password from login where id='$acc_id' AND lower(password)='$password'");
                                if(cerr()) {
                                    if(mysql_affected_rows()==0) {
                                        echo "You have entered wrong password!";
                                    } else {
                                        $row=mysql_fetch_array($search);
                                        if($password==$row[0]) {
                                            $delete_login=mysql_query("delete from login where id='$acc_id'");
                                            if(cerr()) {
                                                $delete_student=mysql_query("delete from parents where acc_id='$acc_id'");
                                                if(cerr()) {
                                                    header("Location: accounts.php?logout=".$_SESSION['id']);
                                                }  else {
                                                    ms_err("2");
                                                }
                                            } else {
                                                ms_err("2");
                                            }
                                        } else {
                                            echo "You have entered wrong password!";;
                                        }
                                    }
                                } else {
                                    ms_err("1");
                                }
                            } else {
                                echo "You have entered wrong password!  ";
                            }
                        }
                        ?>
                        <form name="dform" method="post">
                            Password :- <input type="password" name="password" style="width:300px"/> 
                        </form><br/>
                        <div class="linkbox">
                            <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?tab=settings">NO</a>
                        </div>
                    </center>
                </div>
                <?php
            } else {
                echo "<div id='error' style='width:80%'>No function found!</div>";
            }
        } else {
            echo "<div class='linkbox'>";
            echo "<br/><a href='?tab=settings&action=change'>Change password</a><br/><br/><a href='?tab=settings&action=delete'>Delete account</a>";
            echo "</div>";
        }
    } elseif($tab=="attendance") {
		echo "<br/><u><h2>Attendance Details</h2></u><br/>";
        mysql_select_db("idtsvbt_db_faculty");
        $search=mysql_query("select enrollno from parents where acc_id='$acc_id'");
        if(cerr()) {
            if(mysql_affected_rows()==0) {
                echo "Sorry no enrollno found from database!";
            } else {
                $row=mysql_fetch_row($search);
                mysql_select_db("idtsvbt_db_faculty");
                $enrollno=strtolower($row[0]);
                $search=mysql_query("select * from attendance where lower(enrollno)='$enrollno'");
                if(cerr()) {
                        if(mysql_affected_rows()==0) {
                                echo "<center><div id='error' style='width:80%'>Sorry, your entered enrollment no may be incorrect or not in database!</div></center>";					
                        } else {
                                $row=mysql_fetch_row($search);
                                ?>
                                <br/>
                                <div style="margin-left:0%;border:1px solid black;padding:10px;width:100%;text-align: left">
                                        <div style="float:left;width:300px"><b>Name:</b><br/><?=ucwords($row[1])?></div>
                                        <div style="float:left;width:300px"><b>Enrollment no:</b><br/><?=ucwords($row[2])?></div>
                                        <div style="float:left;width:300px"><b>Updated date:</b><br/><?=ucwords($row[3])?></div>
                                        <div style="float:left;width:900px"><b>Notice:</b><br/><u><?=ucwords($row[6])?></u></div>
                                        <div style="float:left;width:300px"><b>Subjects:</b><br/>
                                                <?php
                                                        $subjects=explode("|",$row[4]);
                                                        for($i=0;$i<count($subjects);$i++) {
                                                                echo strtoupper($subjects[$i])."<br/>";
                                                        }
                                                ?>
                                        </div>
                                        <div style="float:left;width:300px"><b>Percantages:</b><br/>
                                                <?php
                                                        $perc=explode("|",$row[5]);
                                                        $sum=0;
                                                        for($i=0;$i<count($perc);$i++) {
                                                                $sum+=$perc[$i];
                                                                echo strtoupper($perc[$i])."%<br/>";
                                                        }
                                                ?>
                                        </div>
                                        <div style="float:left;width:300px"><b>Average:</b><br/>&nbsp; <?=$sum/count($perc)?>%<br/><b>Attendance level:</b><br/>
                                        <?php
                                        if(($sum/count($perc))==$row[7]) {
                                                echo "<div id='warning' style='width:200px'>Medium (=".$row[7]."%)</div>";
                                        } elseif(($sum/count($perc))<=$row[7]) {
                                                echo "<div id='error' style='width:200px'>Low (<".$row[7]."%)</div>";
                                        } elseif(($sum/count($perc))>=$row[7]) {
                                                echo "<div id='done' style='width:200px'>High (>".$row[7]."%)</div>";
                                        }

                                        ?>
                                        </div>
                                        <div style="clear:both"></div>
                                </div>
                                <?php										
                        }
                } else {
                        ms_err("2");
                }
            }
        } else {
            ms_err("1");
        }
    } elseif($tab=="result") {
		echo "<br/><u><h2>Results Details</h2></u><br/>";
        mysql_select_db("idtsvbt_db_faculty");
        $search=mysql_query("select branch,sem,enrollno from parents where acc_id='$acc_id'");
        if(cerr()) {
            if(mysql_affected_rows()==0) {
                echo "<div id='error' style='width:80%'>Sorry no branch name and semester field specified in your account!</div>";
            } else {
                $row=mysql_fetch_row($search);
                $branch=strtolower($row[0]);$sem=strtolower($row[1]);$enrollno=strtolower($row[2]);
                mysql_select_db("idtsvbt_db_faculty");
                $search=mysql_query("select * from result_table where lower(branch)='$branch' AND lower(sem)='$sem'");
                if(cerr()) {
                    if(mysql_affected_rows()==0) {
                        echo "<br/><div id='warning'>Sorry there is no result information for your batch!</div><br/>";
                    } else {
                        if(isset($_POST['rid'])) {
                            $rid=strtolower($_POST['rid']);
                            echo "<div class='content'>";
                            $search=mysql_query("select * from $rid where lower(enrollno)='$enrollno'");
                            if(cerr()) {
                                if(mysql_affected_rows()==0) {
                                    echo "<center style='color:red'>Sorry no record found for enrollment no <div>$enrollno</div><br/><a href='javascript:history.back(0)'><< Go Back</a></center>";
                                } else {
                                    $row=mysql_fetch_array($search);
                                    $fname=strtolower($row[2]);$subjects=strtolower($row[3]);$marks=strtolower($row[4]);$outof=strtolower($row[5]);$fail=strtolower($row[6]);
                                    echo "<center><h3 id='warning'>Result of ".ucwords($fname)."</h3></center><br/>";
                                    echo "<table class='mytable' cellspacing='0' style='width:100%'>";
                                    echo "<tr class='head'><td>Subject name.</td><td>Mark.</td><td>Out Of.</td></tr>";
                                    $sarr=explode("|",$subjects);
                                    $marr=explode("|",$marks);
                                    $total=0;
                                    $tot=0;
                                    $fail_flag=false;
                                    for($i=0;$i<count($sarr);$i++) {
                                        if($marr[$i]<$fail) {
                                            $fail_flag=true;
                                            echo "<tr><td style='background:yellow'>".strtoupper($sarr[$i])."</td><td style='background:red'>".strtoupper($marr[$i])." marks</td><td style='background:yellow'>".strtoupper($outof)." marks (Passing at <b>$fail</b> marks)</td></tr>";
                                        } else {
                                            echo "<tr><td style='background:yellow'>".strtoupper($sarr[$i])."</td><td style='background:green;color:white'>".strtoupper($marr[$i])." marks</td><td style='background:yellow'>".strtoupper($outof)." marks (Passing at <b>$fail</b> marks)</td></tr>";
                                        }
                                        $total+=$marr[$i];
                                        $tot+=$outof;
                                    }
                                    $per=(($total*100)/$tot);
                                    $per=substr($per, 0,5);
                                    echo "<tr><td>Total marks :-</td><td>$total marks</td><td>$tot marks</td></tr>";
                                    if($fail_flag==true) {
                                        echo "<tr><td style='background:red'>Percentage :- </td><td style='background:red'>$per%</td><td style='background:red'>Result :- FAILED</td></tr>";
                                    } else {
                                        if($per<=100 && $per>=71) {
                                            echo "<tr><td style='background:green'>Percentage :- </td><td style='background:green'>$per%</td><td style='background:green'>Result :- <b>DITINCTION</b></td></tr>";
                                        } elseif($per<=70 && $per>=61) {
                                            echo "<tr><td style='background:lightgreen'>Percentage :- </td><td style='background:lightgreen'>$per%</td><td style='background:lightgreen'>Result :- <b>FIRST CLASS</b></td></tr>";
                                        } elseif($per<=60 && $per>=51) {
                                            echo "<tr><td style='background:lightblue'>Percentage :- </td><td style='background:lightblue'>$per%</td><td style='background:lightblue'>Result :- <b>SECOND CLASS</b></td></tr>";
                                        } elseif($per<=50 && $per>=35) {
                                            echo "<tr><td style='background:skyblue'>Percentage :- </td><td style='background:skyblue'>$per%</td><td style='background:skyblue'>Result :- <b>THIRD CLASS</b></td></tr>";
                                        } else {
                                            echo "<tr><td style='background:red'>Percentage :- </td><td style='background:red'>$per</td><td style='background:red'>Result :- FAILED</td></tr>";
                                        }                        
                                    }
                                    echo "</table>";
                                }
                            } else {
                                ms_err("1");
                            }
                            echo "<br/><center><a href='javascript:history.back(0)'><< Go Back</a></center>";
                            echo "</div>";
                        } else {
                            echo "<br/><form method='post'>";
                            echo "Select exam:";
                            echo "<select name='rid' style='width:500px'>";
                            while(($row=mysql_fetch_array($search))) {
                                echo "<option value='".strtolower($row[6])."'>".strtoupper($row[4])." on ".strtoupper($row[3])." (declared on ".strtoupper($row[5]).")</option>";
                            }
                            echo "</select>";
                            echo "<input type='submit' value='show' />";
                            echo "</form>";
                        }
                    }
                } else {
                    ms_err("2");
                }
            }
        } else {
            ms_err("1");
        }
    } elseif($tab=="messages") {
		echo "<br/><u><h2>Messages</h2></u><br/>";
        if(isset($_GET['action'])) {
            if($_GET['action']=="create") {
                if(isset($_POST['username']) && isset($_POST['msg'])) {
                    if(carr($_POST)) {
                        $ruser=strtolower($_POST['username']);$msg=strtolower($_POST['msg']);
                        if($ruser==strtolower($_SESSION['username'])) {
                            echo "<font color='red'><div>You cant send message yourself!</div></font>";
                        } else {
                            mysql_select_db("idtsvbt_db_faculty");
                            $search=mysql_query("select username from login where id='$ruser'");
                            if(cerr()) {
                                if(mysql_affected_rows()==0) {
                                    echo "<font color='red'><div>Sorry entered username is not found!</div></font>";
                                } else {
                                    $row=mysql_fetch_row($search);
                                    $ruser=$row[0];
                                    mysql_select_db("idtsvbt_db_faculty");
                                    $insert=mysql_query("insert into messages(fr,tto,msg,td,readed) values('".strtolower($_SESSION['username'])."','$ruser','$msg','".getdtime()."','no')");
                                    if(cerr()) {
                                        echo "<font color='green'><div>Your message sent!</div></font>";
                                    } else {
                                        ms_err("2");
                                    }
                                }
                            } else {
                                ms_err("1");
                            }
                        }
                    } else {
                        echo "<div id='error'>You have to enter perfect username and message!</div><br/>";
                    }
                }
                echo "<center><b><div><font color='green'>You can send message to faculty member only!</font></div></b></center>";
                echo "<form method='post'>";
                echo "<table>";
                echo "<tr><td style='text-align:right'>Faculty :- </td><td>";
                echo "<select name='username' style='width:600px'>";
                    mysql_select_db("idtsvbt_db_faculty");
                    $getfac_user=mysql_query("select fname,acc_id,desg from faculty");
                    if(cerr()) {
                        while(($row=mysql_fetch_array($getfac_user))) {
                            echo "<option value='$row[1]'>".ucwords($row[0])." (".(strtoupper($row[2])).")</option>";
                        }
                    } else {
                        ms_err("1");
                    }
                echo "</select>";
                echo "</td></tr>";
                echo "<tr><td style='text-align:right;vertical-align:top'>Message :- </td><td><textarea name='msg' style='width:600px;height:200px'></textarea></td></tr>";
                echo "<tr><td></td><td><input type='submit' value='Send' /></td></tr>";
                echo "</table>";
                echo "</form>";
            } elseif($_GET['action']=="deleteall") {
                if(isset($_GET['from'])) {
                    $from=strtolower($_GET['from']);
                    mysql_select_db("idtsvbt_db_faculty");
                    $delete=mysql_query("delete from messages where lower(fr)='$from' AND tto='".$_SESSION['username']."'");
                    if(cerr()) {
                        echo "<center>all message deleted from $from!<br/><a href='?tab=messages'><< Go back</a></center>";
                    } else {
                        ms_err("1");
                    }
                }
            } elseif($_GET['action']=="show") {
                if(isset($_GET['subaction']) && isset($_GET['id']) && isset($_GET['from'])) {
                    $id=strtolower($_GET['id']);$from=strtolower($_GET['from']);
                    mysql_select_db("idtsvbt_db_faculty");
                    $delete=mysql_query("delete from messages where id='$id' AND tto='".$_SESSION['username']."'");
                    if(cerr()) {
                        echo "<center>message deleted!<br/></center>";
                    } else {
                        ms_err("1");
                    }
                }
                if(isset($_GET['from'])) {
                    $from=strtolower($_GET['from']);
                    echo "<table class='mytable' style='width:100%' cellspacing='0'>";
                    echo "<tr class='head'><td></td><td style='text-align:center'>Messages from $from</td><td></td></tr>";
                    echo "<tr class='head'><td style='width:25%;'>Date & Time</td><td>Message</td><td style='width:20%'>Commands</td></tr>";
                    mysql_select_db("idtsvbt_db_faculty");
                    $search=mysql_query("select * from messages where lower(fr)='$from' AND lower(tto)='".strtolower($_SESSION['username'])."' order by id desc");
                    if(cerr()) {
                        if(mysql_affected_rows()==0) {
                            echo "<b>No messages from $from!</b>";
                        } else {                            
                            while(($row=mysql_fetch_array($search))) {
                                echo "<tr><td style='text-align:center'>$row[4]</td><td>$row[3]</td><td class='linkbox' style='padding-top:15px;padding-bottom:15px;'><a href='?tab=messages&action=create&user=$from'>Reply</a> <a href='?tab=messages&action=show&subaction=delete&from=$from&id=$row[0]'>Delete</a></td></tr>";
                            }
                        }
                    } else {
                        ms_err("1");
                    }
                    echo "</table><br/>";
                }
            }
        } else {
            echo "<table class='mytable' style='width:100%' cellspacing='0'>";
            echo "<tr class='head'><td style='width:20%;'>Message from</td><td>Commands</td></tr>";
            mysql_select_db("idtsvbt_db_faculty");
            $search=mysql_query("select distinct fr from messages where lower(tto)='".strtolower($_SESSION['username'])."' order by id desc");
            if(cerr()) {
                if(mysql_affected_rows()==0) {
                    echo "<b>Inbox empty!</b>";
                } else {
                    while(($row=mysql_fetch_array($search))) {
                        echo "<tr><td style='text-align:center'>$row[0]</td><td class='linkbox' style='padding-top:15px;padding-bottom:15px;'><a href='?tab=messages&action=show&from=$row[0]'>Show all</a> <a href='?tab=messages&action=create&user=$row[0]'>Reply</a> <a href='?tab=messages&action=deleteall&from=$row[0]'>Delete all</a></td></tr>";
                    }
                }
            } else {
                ms_err("1");
            }
            echo "</table><br/>";
            echo "<div class='linkbox'><a href='?tab=messages&action=create'>Create new message</a>";
        }
    } elseif($tab=="notice") {
		echo "<br/><u><h2>Notice Board</h2></u><br/>";
        mysql_select_db("idtsvbt_db_faculty");
        $search=mysql_query("select branch,sem from parents where acc_id='$acc_id'");
        if(cerr()) {
            $row=mysql_fetch_row($search);
            $branch=strtolower($row[0]);$sem=strtolower($row[1]);
            mysql_select_db("idtsvbt_db_faculty");
            if(isset($_POST['page'])) {
                $page=$_POST['page'];
            } else {
                $page="1";
            }
            if(isset($_POST['action'])) {
                    if($_POST['action']=="Previous") {
                            $page--;
                    } else {
                            $page++;
                    }
            }
            $start=($page*10)-10;
            $count=mysql_query("select count(id) from notice_board where lower(branch)='$branch' AND lower(sem)='$sem'");
            $row=mysql_fetch_row($count);
            $total=$row[0];
            $notices=mysql_query("select * from notice_board where lower(branch)='$branch' AND lower(sem)='$sem' order by id desc limit $start,10");
            if(cerr()) {
                if(mysql_affected_rows()==0) {
                    echo "Sorry there is zero items in your branch's notice board!";
                } else {
                    $data['current']=$page;
                    $data['total']=ceil($total/10);
                    ?><br/>
                    <div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
                            <table cellspacing="0" class="mytable" style="width:100%">
                                    <tr class="head">
                                            <td style="width:20%"><b>Notice Date:</b></td><td><b>Notice Description:</b></td></td>
                                    </tr>
                                    <?php while(($row=mysql_fetch_array($notices))) { ?>
                                            <tr><td><u><?=$row[0]?>.</u> <?=$row[1]?></td><td><a href='<?=$row[5]?>'><?=$row[2]?></a></td></tr>
                                    <?php } ?>
                            </table>
                    </div>
                    <br/>
                    <center><form method="post">
                            <input type="hidden" name="branch" value="<?=$branch?>"/>
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
                ms_err("2");
            }
        } else {
            ms_err("1");
        }
    } elseif($_GET['tab']=="fees") {
		echo "<br/><u><h2>Fees Details</h2></u><br/>";
        mysql_select_db("idtsvbt_db_faculty");
        $getenroll=mysql_query("select enrollno from parents where acc_id='$acc_id'");
        if(cerr()) {
            $row=mysql_fetch_row($getenroll);
            $enrollno=$row[0];
            mysql_select_db("idtsvbt_db_faculty");
            $search=mysql_query("select * from fees_details where lower(enrollno)='$enrollno'");
            if(cerr()) {
                echo "<br/>";
                if(mysql_affected_rows()==0) {
                    echo "<div>Sorry there is no fees details for you!!</div>";
                } else {
                    $row=mysql_fetch_row($search);
                    $fees=strtolower($row[5]);$submit=strtolower($row[6]);$ldate=strtolower($row[7]);
                    if($submit=="yes") {
                        echo "<div>Your Rs. $fees/- fees is submitted for your current semester!</div>";
                    } else {
                        echo "<div>Your Rs. $fees/- fees is <b>not</b> submitted yet for your current semester!<br>You have to submit it before <b>$ldate</b> otherwise suitable action will be taken.</div>";
                    }
                }
                echo "<br/>";
            } else {
                ms_err("2");
            }
        } else {
            ms_err("1");
        }
    } elseif($tab=="timetable") {
		echo "<br/><u><h2>Timetable</h2></u><br/>";
        mysql_select_db("idtsvbt_db_faculty");
        $search=mysql_query("select branch,sem from parents where acc_id='$acc_id'");
        if(cerr()) {
            $row=mysql_fetch_row($search);
            $branch=strtolower($row[0]);$sem=strtolower($row[1]);
            mysql_select_db("idtsvbt_db_faculty");
            $timetable=mysql_query("select * from timetable where lower(branch)='$branch' AND lower(sem)='$sem'");
            if(cerr()) {
                if(mysql_affected_rows()==0) {
                    echo "<div>Sorry there is no record for your branch and sem!</div>";
                } else {
                    while(($row=mysql_fetch_array($timetable))) {
                        echo "<div id='warning' style='text-align:left'>";
                        echo "Time table for <u>".ucwords($branch)."</u> and <u>$sem semester</u>..<br/>";
                        $title=explode("|",$row[3]);
                        $links=explode("|",$row[4]);
                        echo "<b>Download:</b><br/>";
                        for($i=0;$i<count($title);$i++) {
                            echo strtoupper($title[$i])." [ <a href='$links[$i]'>".getfilename($links[$i])."</a> ]<br/>";
                        }
                        echo "</div>";
                    }
                }
            } else {
                ms_err("2");
            }
        } else {
            ms_err("1");
        }
    }
} else {
	echo "<br/><u><h2>Your Details</h2></u><br/>";
    mysql_select_db("idtsvbt_db_faculty");
    $search=mysql_query("select * from parents where acc_id='$acc_id'");
    if(cerr()) {
        $row=mysql_fetch_row($search);
    } else {
        ms_err("1");
    }
    if(isset($_GET['action'])) {
        if($_GET['action']=="edit_profile") {
            if(isset($_POST['fname']) && isset($_POST['email']) && isset($_POST['branch']) && isset($_POST['sem']) && isset($_POST['enrollno']) && isset($_POST['mobile']) && isset($_POST['qual']) && isset($_POST['occ']) && isset($_POST['address'])) {
                if(carr($_POST)) {
                    $fname=strtolower($_POST['fname']);$email=strtolower($_POST['email']);$branch=strtolower($_POST['branch']);$sem=strtolower($_POST['sem']);$enrollno=strtolower($_POST['enrollno']);$mobile=strtolower($_POST['mobile']);$qual=strtolower($_POST['qual']);$occ=strtolower($_POST['occ']);$address=strtolower($_POST['address']);
                    if(is_numeric($mobile) && is_mail($email) && is_numeric($enrollno)) {
                        $update=mysql_query("update parents set fname='$fname',email='$email',branch='$branch',sem='$sem',enrollno='$enrollno',mobile='$mobile',qual='$qual',occ='$occ',address='$address' where acc_id='$acc_id'");
                        if(cerr()) {
                            echo "<br/><div id='done' style='width:80%'>Your details updated successfully.</div><br/>";
                            $search=mysql_query("select * from parents where acc_id='$acc_id'");
                            $row=mysql_fetch_row($search);
                        } else {
                            ms_err("1");
                        }
                    } else {
                        echo "<br/><div id='error' style='width:80%'>Email address or Mobile number or Enrollment no is incorrected filled!</div><br/>";
                    }
                } else {
                    echo "<br/><div id='error' style='width:80%'>You have to fill all the field of the web form to update your details!</div><br/>";
                }
            }
    ?>
    <form method="post">
    <table class="mytable" cellspacing="0" style="width:100%">
    <tr class="head"><td style="width:20%;text-align: right"><b>Name :-</b> </td><td><input type="text" name="fname" value="<?=ucwords($row[2])?>" style="width:500px" /></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Enroll no :-</b></td><td><input type="text" name="enrollno" value="<?=ucwords($row[3])?>" style="width:500px" /></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Email address :-</b></td><td><input type="text" name="email" value="<?=ucwords($row[4])?>" style="width:500px" /></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Branch :-</b></td><td>
            <select name="branch" style="width:500px">
                <?php
                    include_once "settings.php";
                    $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
                    mysql_select_db("idtsvbt_db_faculty");
                    $getbranch="select distinct bname from branch";
                    $getbranch=mysql_query($getbranch);
                    while($rows=mysql_fetch_array($getbranch)) {
                        if(strtolower($rows["bname"])==strtolower($row[5])) {
                            echo "<option value='".$rows['bname']."' selected='true'>".$rows['bname']."</option>";
                        } else {
                            echo "<option value='".$rows['bname']."'>".$rows['bname']."</option>";
                        }
                    }
                ?>
            </select>
    </td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Semester :-</b></td><td>
            <select name="sem" style="width:500px">
                <?php
                for($i=0;$i<8;$i++) {
                    if($i==$row[6]) {
                        echo "<option value='$i' selected='true'>$i semester</option>";
                    } else {
                        echo "<option value='$i'>$i semester</option>";
                    }
                }
                ?>
            </select>
    </td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Qualification :-</b></td><td><input type="text" name="qual" value="<?=ucwords($row[7])?>" style="width:500px" /></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Occupation :-</b></td><td><input type="text" name="occ" value="<?=ucwords($row[8])?>" style="width:500px" /></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Address :-</b></td><td><input type="text" name="address" value="<?=ucwords($row[9])?>" style="width:500px" /></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Mobile :-</b></td><td><input type="text" name="mobile" value="<?=ucwords($row[10])?>" style="width:500px" /></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b></b></td><td><input type="submit" value="Save changes" name="change" /> <input type="button" value="Cancel changes" onclick="document.location='accounts.php'" /></td></tr>
    </table><br/>
    </form>
    <?php
        }
    } else {
    ?>
    <table class="mytable" cellspacing="0" style="width:100%">
    <tr class="head"><td style="width:20%;text-align: right"><b>Name :-</b> </td><td><?=ucwords($row[2])?></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Enroll no :-</b></td><td><?=ucwords($row[3])?></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Email address :-</b></td><td><?=strtolower($row[4])?></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Branch :-</b></td><td><?=ucwords($row[5])?></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Semester :-</b></td><td><?=ucwords($row[6])?> semester</td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Qualification :-</b></td><td><?=ucwords($row[7])?></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Occupation :-</b></td><td><?=ucwords($row[8])?></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Address :-</b></td><td><?=ucwords($row[9])?></td></tr>
    <tr class="head"><td style="width:20%;text-align: right"><b>Mobile :-</b></td><td><?=ucwords($row[10])?></td></tr>    
    </table><br/>
        <div class="linkbox">
            <a href="?action=edit_profile">Edit profile</a>
        </div>
    <?php
    }
}
?>

<br/><hr/></center>
</div>
<div style="clear:both"></div>
