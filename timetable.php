<?php include_once "import.php"; ?><html>
<head>
	<title>Time Table - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
	<div class="content">
		<center><h2>Time Table</h2></center><br/>
                <center><form method="post">
                    Select branch:
                    <select name="branch" style="width:200px">
                        <?php
                        include_once 'settings.php';
			$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
			mysql_select_db("idtsvbt_db_faculty");
                        $search=mysql_query("select bname from branch");
                        if(cerr()) {
                            while(($row=mysql_fetch_array($search))) {
                                echo "<option value='".strtolower($row[0])."'>".ucwords($row[0])."</option>";
                            }
                        } else {
                            echo "<option>".ms_err("1")."</option>";
                        }
                        ?>
                    </select>
                    &nbsp;&nbsp;Select semester:
                    <select name="sem" style="width:200px">
                        <option value="1">1st semester</option>
                        <option value="2">2nd semester</option>
                        <option value="3">3rd semester</option>
                        <option value="4">4th semester</option>
                        <option value="5">5th semester</option>
                        <option value="6">6th semester</option>
                        <option value="7">7th semester</option>
                    </select>
                    <input type="submit" value="Show"/>
                </form></center>
                <?php
                if(isset($_POST['branch']) && isset($_POST['sem'])) {
                    include_once 'settings.php';
                    $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
                    mysql_select_db("idtsvbt_db_faculty");
                    $branch=strtolower($_POST['branch']);$sem=strtolower($_POST['sem']);
                    $search=mysql_query("select * from timetable where lower(branch)='$branch' AND lower(sem)='$sem' order by id desc");
                    if(cerr()) {
                        if(mysql_affected_rows()==0) {
                            echo "<center><br/><div id='error'>Sorry no data found!</div></center>";
                        } else {
                            $row=mysql_fetch_row($search);
                            $titles=strtolower($row[3]);$links=strtolower($row[4]);
                            $tarr=explode("|",$titles);
                            $larr=explode("|",$links);
                            echo "<div class='content'>";
                            echo "<b>Time table details of ".ucwords($branch)." of $sem semester :- </b><br/>";
                            echo "<table class='mytable' style='width:100%' cellspacing='0'>";
                            echo "<tr class='head'><td>Group name.</td><td style='width:30%'>Download link.</td></tr>";
                            for($i=0;$i<count($tarr);$i++) {
                                echo "<tr><td>".strtoupper($tarr[$i])."</td><td><a target='_blank' href='$larr[$i]'>Download now</a></td></tr>";
                            }
                            echo "</table>";
                            echo "</div>";
                        }
                    }
                }
                ?>
	</div>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
