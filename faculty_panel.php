<div class="sidebar-right">
	<h3>Control Panel</h3>
	<hr/>
	<?php
	$fl=false;
	include_once 'settings.php';
	$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);	
	mysql_select_db("idtsvbt_db_faculty");
	$se=mysql_query("select * from permission where username='".strtolower($_SESSION['username'])."'");
	if(cerr()) {
		if(mysql_affected_rows()==0) {
		?>
		<div align=left style="padding-left:20px;height:auto" class="msgs">
			<li><a href="accounts.php" id="<?=!isset($_GET['tab'])?"current":"";?>">Profile</a></li>
			<li><a href="?tab=settings" id="<?=isset($_GET['tab']) && $_GET['tab']=="settings"?"current":"";?>">Settings</a></li>
			<li><a href="?tab=notice" id="<?=isset($_GET['tab']) && $_GET['tab']=="notice"?"current":"";?>">Notice board</a></li>
			<li><a href="?tab=dwnl" id="<?=isset($_GET['tab']) && $_GET['tab']=="dwnl"?"current":"";?>">Downloads</a></li>
			<li><a href="?tab=pages" id="<?=isset($_GET['tab']) && $_GET['tab']=="pages"?"current":"";?>">Pages</a></li>
			<li><a href="?tab=messages" id="<?=isset($_GET['tab']) && $_GET['tab']=="messages"?"current":"";?>">Messages</a></li>
			<li><a href="?tab=search_users" id="<?=isset($_GET['tab']) && $_GET['tab']=="search_users"?"current":"";?>">Users</a></li>
			<li><a href="accounts.php?logout=<?=$_SESSION['id']?>">Logout</a></li>
		</div>
		<?php
		} else {
		$fl=true;
		echo "<br/><div align=left style='padding-left:20px;height:auto' class='msgs'>";
		$row=mysql_fetch_row($se);
		$perm=$row[2];
		$arr=array(1=>"Student management","Faculties management","Results","Circulars","Downloads","Notice Board","Time table","Gallery","Attendance","Subscribes","Accounts","College profile","Fees details","Requests","Branchs","Contact us (Inbox)","Latest news","Pages","Management profiles","Principal details","Upload files","Import data");
		$page=array(1=>"students","faculties","results","circulars","downloads","noticeboard","timetable","gallery","attendance","subscribes","accounts","clgprofile","fees","requests","branchs","inbox","news","pages","mgntp","principal","uploads","import");
		$coun=0;
		for($i=1;$i<=22;$i++) {
			if($row[2][$i-1]=="1") {
				if(isset($_GET['page'])) {
					if($_GET['page']==$page[$i])
						$coun++;
				}
				echo "<li><a href='accounts.php?page=".$page[$i]."'>".$arr[$i]."</a></li>";
			}
		}
		$_GLOBEL['c']=$coun;
		echo "</div><br/>";
		echo "<h3>Faculty rights</h3><hr/><br/>";
		?>
		<div align=left style="padding-left:20px;height:auto" class="msgs">
			<li><a href="accounts.php" id="<?=!isset($_GET['tab'])?"current":"";?>">Profile</a></li>
			<li><a href="?tab=settings" id="<?=isset($_GET['tab']) && $_GET['tab']=="settings"?"current":"";?>">Settings</a></li>
			<li><a href="?tab=notice" id="<?=isset($_GET['tab']) && $_GET['tab']=="notice"?"current":"";?>">Notice board</a></li>
			<li><a href="?tab=dwnl" id="<?=isset($_GET['tab']) && $_GET['tab']=="dwnl"?"current":"";?>">Downloads</a></li>
			<li><a href="?tab=pages" id="<?=isset($_GET['tab']) && $_GET['tab']=="pages"?"current":"";?>">Pages</a></li>
			<li><a href="?tab=messages" id="<?=isset($_GET['tab']) && $_GET['tab']=="messages"?"current":"";?>">Messages</a></li>
			<li><a href="?tab=search_users" id="<?=isset($_GET['tab']) && $_GET['tab']=="search_users"?"current":"";?>">Users</a></li><br/><br/>
			<li><a href="accounts.php?logout=<?=$_SESSION['id']?>">Logout</a></li>
		</div>
		<?php
		}
	} else {
		ms_err("1");echo mysql_error();
	}
	?>
</div>
<?php
if($fl==true) {
	$hidesidebar=true;
	if(isset($_GET['page'])) {
		if($_GLOBEL['c']>0) {
			include_once "admin_panel.php";
		} else {
			echo "<div class='sidebar-left'><div id='error'>This page is not available for you!!</div><br/></div>";
		}
	} else {
	echo "<div class='sidebar-left'><center><br/><div id='warning'>Administrator give you an special permission to do an work as administrator on this website!!<br/>Your available funtions are displayed in Control Panel!!</div><br/></center></div>";
	}
	/* else {
		?>
		<div class="sidebar-left">
		<center><h4>Welcome <?=$_SESSION['username']?> as  <?=ucwords($_SESSION['account'])?>.</h4><hr/>
		<?php echo "<br/><div id='warning'>Administrator give you an special permission to do an work as administrator on this website!!<br/>Your available funtions are displayed in Control Panel!!</div><br/>";  ?>
		</div>
		<?php
	}*/
}// else {
if(!isset($_GET['page'])) {
?>
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
            echo "<div id='error' style='width:80%'>Your entered old password is incorrect.</div>";
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
                                                $delete_student=mysql_query("delete from faculty where acc_id='$acc_id'");
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
                            $search=mysql_query("select username from login where username='$ruser'");
                            if(cerr()) {
                                if(mysql_affected_rows()==0) {
                                    echo "<font color='red'><div>Sorry entered username is not found!</div></font>";
                                } else {
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
                echo "<form method='post'>";
                echo "<table>";
                echo "<tr><td style='text-align:right'>Username :- </td><td>";
                if(isset($_GET['user'])) {
                    echo "<input name='username' value='".strtolower($_GET['user'])."' style='width:600px' />";
                } else {
                    echo "<input name='username' value='' style='width:600px' />";
                }
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
            echo "<div class='linkbox'><a href='?tab=messages&action=create'>Create new message</a></div>";
        }
    } elseif($tab=="search_users") {
		echo "<br/><u><h2>Search Users</h2></u><br/>";
        echo "<br/><form><table>";
        echo "<input type='hidden' name='tab' value='search_users' />";
        echo "<tr><td style='text-align:right'>Search :-</td><td><input type='text' name='search' style='width:600px'/></td></tr>";
        echo "<tr><td style='text-align:right'>Type :-</td><td><select name='ty' style='width:600px'><option value='student'>Students</option><option value='faculty'>Faculties</option><option value='parent'>Parents</option></select></td></tr>";
        echo "<tr><td></td><td><input type='submit' value='GO!!' /></td></tr>";
        echo "</table></form>";
        if(isset($_GET['search']) && isset($_GET['ty'])) {
            $q=strtolower($_GET['search']);$ty=strtolower($_GET['ty']);
            mysql_select_db("idtsvbt_db_faculty");
            if($ty=="student") {
                $search=mysql_query("select acc_id,fname,enrollno from student where lower(fname) LIKE '%".strtolower($q)."%'");
            } elseif($ty=="faculty") {
                $search=mysql_query("select acc_id,fname,desg from faculty where lower(fname) LIKE '%".strtolower($q)."%'");
            } elseif($ty=="parent") {
                $search=mysql_query("select acc_id,fname,enrollno from parents where lower(fname) LIKE '%".strtolower($q)."%'");
            }
            if(cerr()) {
                if(mysql_affected_rows()==0) {
                    echo "<div id='code' style='width:80%'>Sorry there is no results for your search string!</div>";
                } else {
                    echo "<table class='mytable' style='width:100%' cellspacing='0'>";
                    if($ty=="student") {
                        echo "<tr class='head'><td style='width:20%'>Name.</td><td style='width:20%'>Username.</td><td style='width:30%'>Enrollment no.</td><td style='width:30%'>Commands</td></tr>";
                    }
                    if($ty=="faculty") {
                        echo "<tr class='head'><td style='width:20%'>Name.</td><td style='width:20%'>Username.</td><td style='width:30%'>Designation.</td><td style='width:30%'>Commands</td></tr>";
                    }
                    if($ty=="parent") {
                        echo "<tr class='head'><td style='width:20%'>Name.</td><td style='width:20%'>Username.</td><td style='width:30%'>Child's Enrollment no.</td><td style='width:30%'>Commands</td></tr>";
                    }
                    while(($row=mysql_fetch_array($search))) {
                        $aid=$row[0];$fname=strtolower($row[1]);$ed=strtolower($row[2]);
                        $login=mysql_query("select username from login where id='$aid'");
                        if(mysql_affected_rows()>0) {
                            $username=mysql_fetch_row($login);
                            $unm=$username[0];
                            echo "<tr><td>".ucwords($fname)."</td><td>$unm</td><td>".strtoupper($ed)."</td><td><div class='linkbox'><a href='?tab=messages&action=create&user=$unm'>Send message</a></div></td></tr>";
                        }
                    }
                    echo "</table>";
                }
            } else {
                ms_err("1");
            }
        }
    } elseif($tab=="notice") {
		echo "<br/><u><h2>Notice Board</h2></u><br/>";
        if(isset($_GET['action'])) {
            if($_GET['action']=="add") {
                echo "<br/><u><h5>Add notice</h5></u><br/>";
                if(isset($_POST['submit'])) {
                    if(carr($_POST)) {
                        $ndesc=strtolower($_POST['ndesc']);$link=strtolower($_POST['link']);$branch=strtolower($_POST['branch']);$sem=strtolower($_POST['sem']);$adder=strtolower($_SESSION['username']);$ndate=date("d-m-Y");
                        mysql_select_db("idtsvbt_db_faculty");
                        $insert=mysql_query("insert into notice_board(ndate,ndesc,link,adder,branch,sem) values('$ndate','$ndesc','$link','$adder','$branch','$sem')");
                        if(cerr()) {
                            echo "<div id='done' style='width:80%'>New notice added!!!</div>";
                        } else {
                            ms_err("1");
                        }
                    } else {
                        echo "<div id='error' style='width:80%'>You have to fill all the textbox to add new notice!!</div><br/>";
                    }
                    echo "<br/>";
                }
                echo "<form method='post'>";
                echo "<table>";
                echo "<tr><td>Branch :-</td><td>Semester :-</td></tr>";
                echo "<tr><td><select name='branch' style='width:300px'>";
                    mysql_select_db("idtsvbt_db_faculty");
                    $search=mysql_query("select distinct bname from branch");
                    while(($data=mysql_fetch_array($search))) {
                        $v=strtolower($data['bname']);$d=ucwords($v);
                        echo "<option value='$v'>$d</option>";
                    }
                echo "</select></td><td><select name='sem' style='width:300px'><option value='1'>1st semester</option><option value='2'>2nd semester</option><option value='3'>3rd semester</option><option value='4'>4th semester</option><option value='5'>5th semester</option><option value='6'>6th semester</option><option value='7'>7th semester</option></select></td></tr>";
                echo "<tr><td>Notice description :-<br/><textarea name='ndesc' style='width:200%'></textarea></td><td></td></tr>";
                echo "<tr><td>Link :-<br/><input type='text' name='link' style='width:200%' /></td></tr>";
                echo "<tr><td><input type='submit' name='submit' value='Submit' /></td></tr>";
                echo "</table>";
                echo "</form>";
            } elseif($_GET['action']=="edit") {
                if(isset($_GET['id'])) {
                    $id=$_GET['id'];
                    echo "<br/><h5><u>Modify notice</u><br/></h5><br/>";
                    if(isset($_POST['submit'])) {
                        if(carr($_POST)) {
                            $ndesc=strtolower($_POST['ndesc']);$link=strtolower($_POST['link']);$branch=strtolower($_POST['branch']);$sem=strtolower($_POST['sem']);$adder=strtolower($_SESSION['username']);$ndate=date("d-m-Y");
                            mysql_select_db("idtsvbt_db_faculty");
                            $insert=mysql_query("update notice_board set ndate='$ndate',ndesc='$ndesc',link='$link',branch='$branch',sem='$sem' where id='$id'");
                            if(cerr()) {
                                echo "<div id='done' style='width:80%'>Notice updated!!!</div>";
                            } else {
                                ms_err("1");
                            }
                        } else {
                            echo "<div id='code' style='width:80%'>You have to fill all the textbox to add new notice!!</div><br/>";
                        }
                        echo "<br/>";
                    }
                    mysql_select_db("idtsvbt_db_faculty");
                    $gets=mysql_query("select * from notice_board where adder='".$_SESSION['username']."' AND id='$id'");
                    if(mysql_affected_rows()>0) {
                        $row=mysql_fetch_row($gets);
                        echo "<form method='post'>";
                        echo "<table>";
                        echo "<tr><td>Branch :-</td><td>Semester :-</td></tr>";
                        echo "<tr><td><select name='branch' style='width:300px'>";
                            mysql_select_db("idtsvbt_db_faculty");
                            $search=mysql_query("select distinct bname from branch");
                            while(($data=mysql_fetch_array($search))) {
                                $v=strtolower($data['bname']);$d=ucwords($v);
                                if($v==strtolower($row[3])) {
                                    echo "<option value='$v' selected='true'>$d</option>";
                                } else {
                                    echo "<option value='$v'>$d</option>";
                                }
                            }
                        echo "</select></td><td><select name='sem' style='width:300px'>";
                        for($i=1;$i<8;$i++) {
                            if("$i"==$row[4]) {
                                echo "<option value='$i' selected='true'>$i semester</option>";
                            } else {
                                echo "<option value='$i'>$i semester</option>";
                            }
                        }
                        echo "</select></td></tr>";
                        echo "<tr><td>Notice description :-<br/><textarea name='ndesc' style='width:200%'>$row[2]</textarea></td><td></td></tr>";
                        echo "<tr><td>Link :-<br/><input type='text' name='link' style='width:200%' value='$row[5]' /></td></tr>";
                        echo "<tr><td><input type='submit' name='submit' value='Update' /></td></tr>";
                        echo "</table>";
                        echo "</form>";
                    } else {
                        echo "<div id='error' style='width:80%'>Sorry no notice found from this identifier proof!!!</div>";
                    }
                } else {
                    echo "<br/><u><h5>Click on notice to edit it!!</h5></u><br/>";
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
                    $count=mysql_query("select count(id) from notice_board where lower(adder)='".strtolower($_SESSION['username'])."'");
                    $row=mysql_fetch_row($count);
                    $total=$row[0];
                    $search=mysql_query("select * from notice_board where lower(adder)='".strtolower($_SESSION['username'])."' order by id desc limit $start,10");
                    if(cerr()) {
                            if(mysql_affected_rows()==0) {
                                    echo "<br/><center><div id='error'>Sorry you didnt added any notice yet!</div></center>";
                            } else {
                                    $data['current']=$page;
                                    $data['total']=ceil($total/10);
                    ?>
                    <div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
                            <table cellspacing="0" class="mytable" style="width:100%">
                                    <tr class="head">
                                            <td style="width:20%"><b>Notice Date:</b></td><td style="width:60%"><b>Notice Description:</b></td><td style="width:20%"><b>Branch & Semester:</b></td>
                                    </tr>
                                    <?php while(($row=mysql_fetch_array($search))) { ?>
                                            <tr><td><u><?=$row[0]?>.</u> <a href='?tab=notice&action=edit&id=<?=$row[0]?>'><?=$row[1]?></a></td><td><a href='?tab=notice&action=edit&id=<?=$row[0]?>'><?=$row[2]?></a></td><td><a href='?tab=notice&action=edit&id=<?=$row[0]?>'><?=ucwords($row['branch'])?><br/><?=$row[4]?> semester</a></td></tr>
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
            } elseif($_GET['action']=="delete") {
                if(isset($_GET['id'])) {
                    $id=$_GET['id'];
                    echo "<br/><h5><u>Delete notice</u><br/></h5><br/>";
                    if(isset($_POST['submit'])) {
                            mysql_select_db("idtsvbt_db_faculty");
                            $insert=mysql_query("delete from notice_board where id='$id'");
                            if(cerr()) {
                                echo "<div id='done' style='width:80%'>Notice deleted!!!</div>";
                            } else {
                                ms_err("1");
                            }
                            echo "<br/>";
                    } else {
                        mysql_select_db("idtsvbt_db_faculty");
                        $gets=mysql_query("select * from notice_board where adder='".$_SESSION['username']."' AND id='$id'");
                        if(mysql_affected_rows()>0) {
                            $row=mysql_fetch_row($gets);
                            echo "<form method='post'>";
                            echo "<table>";
                            echo "<tr><td>Branch :-</td><td>Semester :-</td></tr>";
                            echo "<tr><td><select name='branch' disabled='true' style='width:300px'>";
                                mysql_select_db("idtsvbt_db_faculty");
                                $search=mysql_query("select distinct bname from branch");
                                while(($data=mysql_fetch_array($search))) {
                                    $v=strtolower($data['bname']);$d=ucwords($v);
                                    if($v==strtolower($row[3])) {
                                        echo "<option value='$v' selected='true'>$d</option>";
                                    } else {
                                        echo "<option value='$v'>$d</option>";
                                    }
                                }
                            echo "</select></td><td><select name='sem' disabled='true' style='width:300px'>";
                            for($i=1;$i<8;$i++) {
                                if("$i"==$row[4]) {
                                    echo "<option value='$i' selected='true'>$i semester</option>";
                                } else {
                                    echo "<option value='$i'>$i semester</option>";
                                }
                            }
                            echo "</select></td></tr>";
                            echo "<tr><td>Notice description :-<br/><textarea disabled='true' name='ndesc' style='width:200%'>$row[2]</textarea></td><td></td></tr>";
                            echo "<tr><td>Link :-<br/><input disabled='true' type='text' name='link' style='width:200%' value='$row[5]' /></td></tr>";
                            echo "<tr><td><input type='submit' name='submit' value='Delete now' /></td></tr>";
                            echo "</table>";
                            echo "</form>";
                        } else {
                            echo "<div id='error' style='width:80%'>Sorry no notice found from this identifier proof!!!</div><br/>";
                        }
                    }
                } else {
                    echo "<br/><u><h5>Click on notice to delete it!!</h5></u><br/>";
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
                    $count=mysql_query("select count(id) from notice_board where lower(adder)='".strtolower($_SESSION['username'])."'");
                    $row=mysql_fetch_row($count);
                    $total=$row[0];
                    $search=mysql_query("select * from notice_board where lower(adder)='".strtolower($_SESSION['username'])."' order by id desc limit $start,10");
                    if(cerr()) {
                            if(mysql_affected_rows()==0) {
                                    echo "<br/><center><div id='error'>Sorry you didnt added any notice yet!</div></center>";
                            } else {
                                    $data['current']=$page;
                                    $data['total']=ceil($total/10);
                    ?>
                    <div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
                            <table cellspacing="0" class="mytable" style="width:100%">
                                    <tr class="head">
                                            <td style="width:20%"><b>Notice Date:</b></td><td style="width:60%"><b>Notice Description:</b></td><td style="width:20%"><b>Branch & Semester:</b></td>
                                    </tr>
                                    <?php while(($row=mysql_fetch_array($search))) { ?>
                                            <tr><td><u><?=$row[0]?>.</u> <a href='?tab=notice&action=delete&id=<?=$row[0]?>'><?=$row[1]?></a></td><td><a href='?tab=notice&action=delete&id=<?=$row[0]?>'><?=$row[2]?></a></td><td><a href='?tab=notice&action=delete&id=<?=$row[0]?>'><?=ucwords($row['branch'])?><br/><?=$row[4]?> semester</a></td></tr>
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
            }
        } else {
            echo "<br/><div class='linkbox'>";
            echo "<a href='?tab=notice&action=add'>Add Notice</a> <a href='?tab=notice&action=edit'>Modify Notice</a> <a href='?tab=notice&action=delete'>Delete Notice</a>";
            echo "</div>";
        }
    } elseif($_GET['tab']=="dwnl") {
		echo "<br/><u><h2>Downloads</h2></u><br/>";
        if(isset($_GET['action'])) {
            if($_GET['action']=="add") {
                echo "<br/><h5>Add download</h5>";
                if(isset($_POST['dtitle']) && isset($_POST['ddesc']) && isset($_POST['dlinks'])) {
                    if(carr($_POST)) {
                        $dtitle=strtolower($_POST['dtitle']);$ddesc=strtolower($_POST['ddesc']);$dlinks=strtolower($_POST['dlinks']);
                        $dt=date("d-m-Y");$adder=$_SESSION['username'];
                        mysql_select_db("idtsvbt_db_faculty");
                        $dlinks=str_replace(";","|",$dlinks);
                        $insert=mysql_query("insert into downloads(tdate,dtitle,ddesc,links,adder) values('$dt','$dtitle','$ddesc','$dlinks','$adder')");
                        if(cerr()) {
                            echo "<font color='green'><h5>Congratulation, new download item added!!</h5></font>";
                        } else {
                            ms_err("1");
                        }
                    } else {
                        echo "<font color='red'><h5>Every field must filled!!</h5></font>";
                    }
                }
                echo "<form method='post'><h5>";
                echo "<table>";
                echo "<tr><td><h5>Title:</h5></td></tr><tr><td><input type='text' name='dtitle' style='width:400px'/></td></tr>";
                echo "<tr><td><h5>Description:</h5><h6>[ html tags allowed ]</h6></td></tr><tr><td><textarea name='ddesc' style='width:400px'></textarea></td></tr>";
                echo "<tr><td><h5>Links:</h5><h6>[ all links separated by semi-colon=; ]</h6></td></tr><tr><td><input name='dlinks' style='width:400px'/></td></tr>";
                echo "<tr><td><input type='submit' value='SUBMIT' /></td></tr>";
                echo "</table>";
                echo "</h5></form>";
            } elseif($_GET['action']=="edit") {
                if(isset($_GET['id'])) {
                    $id=$_GET['id'];$user=$_SESSION['username'];
                    mysql_select_db("idtsvbt_db_faculty");
                    $search=mysql_query("select * from downloads where adder='$user' AND id='$id'");
                    if(cerr()) {
						if(isset($_POST['dtitle']) && isset($_POST['ddesc']) && isset($_POST['dlinks'])) {
							if(carr($_POST)) {
								$dtitle=strtolower($_POST['dtitle']);$ddesc=strtolower($_POST['ddesc']);$dlinks=strtolower($_POST['dlinks']);
								mysql_select_db("idtsvbt_db_faculty");
								$update=mysql_query("update downloads set dtitle='$dtitle', ddesc='$ddesc', links='$dlinks' where id='$id' AND adder='$user'");
								if(cerr()) {
									echo "<u><h5>Updated sucessfully!!</h5></u>";
								} else {
									ms_err("1");
								}
							} else {
								echo "<br/><center id='error'>You have to fill all the textbox to modify it!!</center>";
							}
						} else {
							$row=mysql_fetch_row($search);
							//id-0 date-1 title-2 desc-3 links-4 adder-5
							$links=str_replace("|",";",$row[4]);
							echo "<br/><u><h5>Modify download</h5></u><br/>";
							echo "<form method='post'><h5>";
							echo "<table>";
							echo "<tr><td><h5>Title:</h5></td></tr><tr><td><input type='text' name='dtitle' style='width:400px' value='$row[2]'/></td></tr>";
							echo "<tr><td><h5>Description:</h5><h6>[ html tags allowed ]</h6></td></tr><tr><td><textarea name='ddesc' style='width:400px'>$row[3]</textarea></td></tr>";
							echo "<tr><td><h5>Links:</h5><h6>[ all links separated by semi-colon=; ]</h6></td></tr><tr><td><input value='$links' name='dlinks' style='width:400px'/></td></tr>";
							echo "<tr><td><input type='submit' value='UPDATE' /></td></tr>";
							echo "</table>";
							echo "</h5></form>";
						}
                    } else {
                        ms_err("1");
                    }
                } else {
                echo "<br/><u><h5>Click on download to edit it!!</h5></u><br/>";
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
                $count=mysql_query("select count(id) from downloads where lower(adder)='".strtolower($_SESSION['username'])."'");
                $row=mysql_fetch_row($count);
                $total=$row[0];
                $search=mysql_query("select * from downloads where lower(adder)='".strtolower($_SESSION['username'])."' order by id desc limit $start,10");
                if(cerr()) {
                        if(mysql_affected_rows()==0) {
                                echo "<br/><center><div id='error'>Sorry you didnt added any download yet!</div><br/></center>";
                        } else {
                                $data['current']=$page;
                                $data['total']=ceil($total/10);
                ?>
                <div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
                        <table cellspacing="0" class="mytable" style="width:100%">
                                <tr class="head">
                                        <td style="width:20%"><b>Date:</b></td><td style="width:80%"><b>Title:</b></td>
                                </tr>
                                <?php while(($row=mysql_fetch_array($search))) { ?>
                                        <tr><td><u><?=$row[0]?>.</u> <a href='?tab=dwnl&action=edit&id=<?=$row[0]?>'><?=$row[1]?></a></td><td><a href='?tab=dwnl&action=edit&id=<?=$row[0]?>'><?=$row[2]?></a></td></tr>
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
            } elseif($_GET['action']=="delete") {
				if(isset($_GET['id'])) {
					$id=$_GET['id'];$user=$_SESSION['username'];
					mysql_select_db("idtsvbt_db_faculty");
					$delete=mysql_query("delete from downloads where id='$id' AND adder='$user'");
					if(cerr()) {
						echo "<br/><u><h5>Deleted sucessfully!!</h5></u>";
					} else {
						ms_err("1");
					}
				} else {
				echo "<br/><u><h5>Click on download to delete it!!</h5></u><br/>";
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
                $count=mysql_query("select count(id) from downloads where lower(adder)='".strtolower($_SESSION['username'])."'");
                $row=mysql_fetch_row($count);
                $total=$row[0];
                $search=mysql_query("select * from downloads where lower(adder)='".strtolower($_SESSION['username'])."' order by id desc limit $start,10");
                if(cerr()) {
                        if(mysql_affected_rows()==0) {
                                echo "<br/><center><div id='error'>Sorry you didnt added any download yet!</div></center>";
                        } else {
                                $data['current']=$page;
                                $data['total']=ceil($total/10);
                ?>
                <div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
                        <table cellspacing="0" class="mytable" style="width:100%">
                                <tr class="head">
                                        <td style="width:20%"><b>Date:</b></td><td style="width:80%"><b>Title:</b></td>
                                </tr>
                                <?php while(($row=mysql_fetch_array($search))) { ?>
                                        <tr><td><u><?=$row[0]?>.</u> <a href='?tab=dwnl&action=delete&id=<?=$row[0]?>'><?=$row[1]?></a></td><td><a href='?tab=dwnl&action=delete&id=<?=$row[0]?>'><?=$row[2]?></a></td></tr>
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
            } else {
                echo "Wrong action command!!";
            }
        } else {
            echo "<br/><div class='linkbox'>";
            echo "<a href='?tab=dwnl&action=add'>Add Download</a> <a href='?tab=dwnl&action=edit'>Modify Download</a> <a href='?tab=dwnl&action=delete'>Delete Download</a>";
            echo "</div>";
        }
    } else if($_GET['tab']=="pages") {
		echo "<br/><u><h2>Pages</h2></u><br/>";
		if(isset($_GET['action'])) {
			$get=$_GET['action'];
			if($get=="add") {				
				echo "<br/><u><h5>Add new page</h5></u>";
				if(isset($_POST['ptitle']) && isset($_POST['pbody']) && isset($_POST['pdesc']) && isset($_POST['lreq'])) {
					$ptitle=strtolower($_POST['ptitle']);$pbody=strtolower($_POST['pbody']);$pdesc=strtolower($_POST['pdesc']);$lreq=strtolower($_POST['lreq']);
					if(carr($_POST)) {
						mysql_select_db("idtsvbt_db_faculty");
						$ins=mysql_query("insert into pages(title,body,auth,pdesc,adder) values('$ptitle','$pbody','$lreq','$pdesc','".strtolower($_SESSION['username'])."')");
						if(cerr()) {
							echo "<font color='yellow'><u><h5>New page sucessfully added!!</h5></u></font>";
						} else {
							ms_err("1");
						}
					} else {
						echo "<u><h5>You have to fill up all textbox(s) for adding new page!!</h5></u>";
					}
				}
				echo "<br/><form method='post'>";
                echo "<table>";
                echo "<tr><td><h5>Page Title:</h5></td></tr><tr><td><input type='text' name='ptitle' style='width:400px'/></td></tr>";
                echo "<tr><td><h5>Page Body:</h5><h6>[ html tags allowed ]</h6></td></tr><tr><td><textarea name='pbody' style='width:400px'></textarea></td></tr>";
                echo "<tr><td><h5>Page Description:</h5></td></tr><tr><td><input name='pdesc' style='width:400px'/></td></tr>";
                echo "<tr><td><h5>Login required:</h5></td></tr><tr><td><select name='lreq' style='width:400px'><option value='yes'>Yes</option><option value='no'>No</option></select></td></tr>";
                echo "<tr><td><input type='submit' value='SUBMIT' /></td></tr>";
                echo "</table>";
				echo "</form>";
			} else if($get=="edit") {
				if(isset($_GET['id'])) {
					$id=$_GET['id'];
					mysql_select_db("idtsvbt_db_faculty");
					$sea=mysql_query("select * from pages where id='$id' ANd adder='".$_SESSION['username']."'");
					if(cerr()) {
						$row=mysql_fetch_row($sea);
						echo "<br/><u><h5>Edit pages</h5></u>";
						if(isset($_POST['ptitle']) && isset($_POST['pbody']) && isset($_POST['pdesc']) && isset($_POST['lreq'])) {
							$title=strtolower($_POST['ptitle']);$body=strtolower($_POST['pbody']);$desc=strtolower($_POST['pdesc']);$lreq=strtolower($_POST['lreq']);
							mysql_select_db("idtsvbt_db_faculty");
							$up=mysql_query("update pages set title='$title',body='$body',auth='$lreq',pdesc='$desc' where id='$id' AND adder='".$_SESSION['username']."'");
							if(cerr()) {
								echo "<font color='yellow'><u><h5>Updated sucessfully!!</h5></u></font>";
							} else {
								ms_err("1");
							}
						}
						echo "<br/><form method='post'>";
				        echo "<table>";
				        echo "<tr><td><h5>Page Title:</h5></td></tr><tr><td><input type='text' name='ptitle' value='$row[1]' style='width:400px'/></td></tr>";
				        echo "<tr><td><h5>Page Body:</h5><h6>[ html tags allowed ]</h6></td></tr><tr><td><textarea name='pbody' style='width:400px'>$row[2]</textarea></td></tr>";
				        echo "<tr><td><h5>Page Description:</h5></td></tr><tr><td><input name='pdesc' style='width:400px' value='$row[4]'/></td></tr>";
				        echo "<tr><td><h5>Login required:</h5></td></tr><tr><td><select name='lreq' style='width:400px'>";
						if($row[3]=="yes") {
							echo "<option value='yes' selected='true'>Yes</option><option value='no'>No</option>";
						} else {
							echo "<option value='yes'>Yes</option><option value='no' selected='true'>No</option>";
						}
						echo "</select></td></tr>";
				        echo "<tr><td><input type='submit' value='UPDATE' /></td></tr>";
				        echo "</table>";
						echo "</form>";
					} else {
						ms_err("1");
					}
				} else {
                echo "<br/><u><h5>Click on page to edit it!!</h5></u><br/>";
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
                $count=mysql_query("select count(id) from pages where lower(adder)='".strtolower($_SESSION['username'])."'");
                $row=mysql_fetch_row($count);
                $total=$row[0];
                $search=mysql_query("select * from pages where lower(adder)='".strtolower($_SESSION['username'])."' order by id desc limit $start,10");
                if(cerr()) {
                        if(mysql_affected_rows()==0) {
                                echo "<br/><center><div id='error'>Sorry you didnt added any page yet!</div><br/></center>";
                        } else {
                                $data['current']=$page;
                                $data['total']=ceil($total/10);
                ?>
                <div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
                        <table cellspacing="0" class="mytable" style="width:100%">
                                <tr class="head">
                                        <td style="width:20%"><b>Title:</b></td><td style="width:80%"><b>Description:</b></td>
                                </tr>
                                <?php while(($row=mysql_fetch_array($search))) { ?>
                                        <tr><td><u><?=$row[0]?>.</u> <a href='?tab=pages&action=edit&id=<?=$row[0]?>'><?=$row[1]?></a></td><td><a href='?tab=pages&action=edit&id=<?=$row[0]?>'><?=$row[4]?></a></td></tr>
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
			} else if($get=="delete") {
                if(isset($_GET['id'])) {
                    $id=$_GET['id'];
                    mysql_select_db("idtsvbt_db_faculty");
                    $del=mysql_query("delete from pages where id='$id' AND adder='".$_SESSION['username']."'");
                    if(cerr()) {
                        echo "<br/><u><h5>Sucessfully deleted!!</h5></u>";
                    } else {
                        ms_err("1");
                    }
                } else {
                echo "<br/><u><h5>Click on page to delete it!!</h5></u><br/>";
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
                $count=mysql_query("select count(id) from pages where lower(adder)='".strtolower($_SESSION['username'])."'");
                $row=mysql_fetch_row($count);
                $total=$row[0];
                $search=mysql_query("select * from pages where lower(adder)='".strtolower($_SESSION['username'])."' order by id desc limit $start,10");
                if(cerr()) {
                        if(mysql_affected_rows()==0) {
                                echo "<center><div id='error'>Sorry you didnt added any page yet!</div></center>";
                        } else {
                                $data['current']=$page;
                                $data['total']=ceil($total/10);
                ?>
                <div style="margin-left:10px;max-height:400px;overflow:auto;border:1px solid black">
                        <table cellspacing="0" class="mytable" style="width:100%">
                                <tr class="head">
                                        <td style="width:20%"><b>Title:</b></td><td style="width:80%"><b>Description:</b></td>
                                </tr>
                                <?php while(($row=mysql_fetch_array($search))) { ?>
                                        <tr><td><u><?=$row[0]?>.</u> <a href='?tab=pages&action=delete&id=<?=$row[0]?>'><?=$row[1]?></a></td><td><a href='?tab=pages&action=delete&id=<?=$row[0]?>'><?=$row[4]?></a></td></tr>
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
            } else {
				echo "<br/><u><h5>No page found!!</h5></u>";
			}
		} else {
            echo "<br/><div class='linkbox'>";
		    echo "<a href='?tab=pages&action=add'>Add Page</a> <a href='?tab=pages&action=edit'>Modify Page</a> <a href='?tab=pages&action=delete'>Delete Pages</a>";
		    echo "</div>";
		}
    }
} else {
		echo "<br/><u><h2>Your Details</h2></u><br/>";
        mysql_select_db("idtsvbt_db_faculty");
        $search=mysql_query("select * from faculty where acc_id='$acc_id'");
        if(cerr()) {
            $row=mysql_fetch_row($search);
        } else {
            ms_err("1");
        }
        if(isset($_GET['action'])) {
            if($_GET['action']=="edit_profile") {
                if(isset($_POST['fname']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['address']) && isset($_POST['desg'])) {
                    if(carr($_POST)) {
                        $fname=strtolower($_POST['fname']);$email=strtolower($_POST['email']);$mobile=strtolower($_POST['mobile']);$address=strtolower($_POST['address']);$desg=strtolower($_POST['desg']);
                        if(is_numeric($mobile) && is_mail($email)) {
                            $update=mysql_query("update faculty set fname='$fname',email='$email',mobile='$mobile',desg='$desg',address='$address' where acc_id='$acc_id'");
                            if(cerr()) {
                                echo "<br/><div id='done' style='width:80%'>Your details updated successfully.</div><br/>";
                                $search=mysql_query("select * from faculty where acc_id='$acc_id'");
                                $row=mysql_fetch_row($search);
                            } else {
                                ms_err("1");
                            }
                        } else {
                            echo "<br/><div id='error' style='width:80%'>Email address or Mobile number is incorrected filled!</div><br/>";
                        }
                    } else {
                        echo "<br/><div id='error' style='width:80%'>You have to fill all the field of the web form to update your details!</div><br/>";
                    }
                }
        ?>
        <form method="post">
        <table class="mytable" cellspacing="0" style="width:100%">
        <tr class="head"><td style="width:20%;text-align: right"><b>Name :-</b> </td><td><input type="text" name="fname" value="<?=ucwords($row[2])?>" style="width:500px" /></td></tr>
        <tr class="head"><td style="width:20%;text-align: right"><b>Email address :-</b></td><td><input type="text" name="email" value="<?=ucwords($row[3])?>" style="width:500px" /></td></tr>
        <tr class="head"><td style="width:20%;text-align: right"><b>Designation :-</b></td><td><input type="text" name="desg" value="<?=strtoupper($row[4])?>" style="width:500px" /></td></tr>
        <tr class="head"><td style="width:20%;text-align: right"><b>Address :-</b></td><td><input type="text" name="address" value="<?=ucwords($row[5])?>" style="width:500px" /></td></tr>
        <tr class="head"><td style="width:20%;text-align: right"><b>Mobile :-</b></td><td><input type="text" name="mobile" value="<?=ucwords($row[6])?>" style="width:500px" /></td></tr>
        <tr class="head"><td style="width:20%;text-align: right"><b></b></td><td><input type="submit" value="Save changes" name="change" /> <input type="button" value="Cancel changes" onclick="document.location='accounts.php'" /></td></tr>
        </table><br/>
        </form>
        <?php
            }
        } else {
        ?>
        <table class="mytable" cellspacing="0" style="width:100%">
        <tr class="head"><td style="width:20%;text-align: right"><b>Name :-</b> </td><td><?=ucwords($row[2])?></td></tr>
        <tr class="head"><td style="width:20%;text-align: right"><b>Email address :-</b></td><td><?=strtolower($row[3])?></td></tr>
        <tr class="head"><td style="width:20%;text-align: right"><b>Designation :-</b></td><td><?=strtoupper($row[4])?></td></tr>
        <tr class="head"><td style="width:20%;text-align: right"><b>Address :-</b></td><td><?=ucwords($row[5])?></td></tr>
        <tr class="head"><td style="width:20%;text-align: right"><b>Mobile :-</b></td><td><?=ucwords($row[6])?></td></tr>    
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
<?php 
}
?>