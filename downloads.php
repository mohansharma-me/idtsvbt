<?php include_once "import.php"; ?><html>
<head>
	<title>Downloads - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
<?php
if(isset($_GET['id'])) {
$id=strtolower($_GET['id']);
include_once 'settings.php';
$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
mysql_select_db("idtsvbt_db_faculty");
$search=mysql_query("select * from downloads where lower(id)='$id'");
echo "<div class='content'>";
if(cerr()) {
    $row=mysql_fetch_row($search);
    echo "<center><h3>$row[2]</h3></center><br/>";
    echo "<center><h5>Date: $row[1]</h5></center><br/>";
    echo "<center style='border:1px solid black;padding:10px'>".ucwords($row[3])."</center><br/>";
    echo "<center><div id='warning' style='text-align:left'><b>Download files :-</b><br/>";
    $arr=explode("|",$row[4]);
    echo "<ol type='1' style='margin-left:30px'>";
    for($i=0;$i<count($arr);$i++) {
        $file=getfilename($arr[$i]);
        echo "<li><a target='_blank' href='$arr[$i]'>$file</a></li>";
    }
    echo "</ol>";
    echo "</div></center><br/>";
    echo "<center><a href='javascript:history.back(0)'><< Go Back</a></center>";
} else {
    ms_err("1");
}
echo "</div>";
} else {
?>
	<div class="content">
		<center><h2>Downloads</h2></center><br/>
                <center><form>
                    Search: <input type="text" name="query" style="width:300px" /><input type="submit" value="Search" />
                </form></center>
                <br/>
<?php
include_once 'settings.php';
$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
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
if(isset($_GET['query'])) {
    $query=strtolower($_GET['query']);
    $search=mysql_query("select id,tdate,dtitle from downloads where lower(dtitle) LIKE '%$query%' OR lower(ddesc) LIKE '%$query%' OR lower(tdate) LIKE '%$query%' order by id desc");
} else {
    $count=mysql_query("select count(id) from downloads");
    $row=mysql_fetch_row($count);
    $total=$row[0];    
    $search=mysql_query("select id,tdate,dtitle from downloads order by id desc limit $start,10");
}
if(cerr()) {
    if(mysql_affected_rows()==0) {
            echo "<br/><center><div id='error'>Sorry no data found!</div></center>";
    } else {
        if(!isset($_GET['query'])) {
            $data['current']=$page;$data['total']=ceil($total/10);
        }
        echo "<table cellspacing='0' class='mytable' style='width:100%'>";
        echo "<tr class='head'><td style='width:20%'>Date.</td><td style='width:80%'>Download Description.</td></tr>";
        while(($row=mysql_fetch_array($search))) {
            echo "<tr><td><a href='?id=$row[0]'>$row[1]</a></td><td><a href='?id=$row[0]'>".ucwords($row[2])."</a></td></tr>";
        }
        echo "</table>";
        if(!isset($_GET['query'])) {
        ?><br/>
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
    }
} else {
    ms_err("1");echo mysql_error();
}
?>
                </table>
	</div>
<?php } ?>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
