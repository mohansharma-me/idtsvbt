<?php include_once "import.php"; ?><html>
<head>
	<title>Results - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
        <?php
        if(isset($_GET['branch']) && isset($_GET['sem']) && isset($_GET['enrollno']) && isset($_GET['rid'])) {
            $branch=strtolower($_GET['branch']);$sem=strtolower($_GET['sem']);$enrollno=strtolower($_GET['enrollno']);$rid=strtolower($_GET['rid']);
            include_once 'settings.php';
            $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
            mysql_select_db("idtsvbt_db_faculty");
            echo "<div class='content'>";
            $search=mysql_query("select * from $rid where lower(enrollno)='$enrollno'");
            if(cerr()) {
                if(mysql_affected_rows()==0) {
                    echo "<center style='color:red'>Sorry no record found for enrollment no <code>$enrollno</code><br/><a href='javascript:history.back(0)'><< Go Back</a></center>";
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
                            echo "<tr><td style='background:green;color:white'>Percentage :- </td><td style='background:green;color:white'>$per%</td><td style='background:green;color:white'>Result :- <b>DISTINCTION</b></td></tr>";
                        } elseif($per<=70 && $per>=61) {
                            echo "<tr><td style='background:lightgreen;'>Percentage :- </td><td style='background:lightgreen;'>$per%</td><td style='background:lightgreen;'>Result :- <b>FIRST CLASS</b></td></tr>";
                        } elseif($per<=60 && $per>=51) {
                            echo "<tr><td style='background:lightblue;color:white'>Percentage :- </td><td style='background:lightblue;color:white'>$per%</td><td style='background:lightblue;color:white'>Result :- <b>SECOND CLASS</b></td></tr>";
                        } elseif($per<=50 && $per>=35) {
                            echo "<tr><td style='background:skyblue;color:white'>Percentage :- </td><td style='background:skyblue;color:white'>$per%</td><td style='background:skyblue;color:white'>Result :- <b>THIRD CLASS</b></td></tr>";
                        } else {
                            echo "<tr><td style='background:red;color:white'>Percentage :- </td><td style='background:red;color:white'>$per</td><td style='background:red;color:white '>Result :- FAILED</td></tr>";
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
        if(isset($_GET['branch']) && isset($_GET['sem'])) {
            $branch=strtolower($_GET['branch']);$sem=strtolower($_GET['sem']);
            include_once 'settings.php';
            $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
            mysql_select_db("idtsvbt_db_faculty");
            $search=mysql_query("select * from result_table where lower(branch)='$branch' AND lower(sem)='$sem'");
            echo "<div class='content'>";
            if(cerr()) {
                if(mysql_affected_rows()==0) {
                    echo "<center><div id='error'>There is no result database for $branch of $sem.</div></center>";
                } else {
                    /*$result=mysql_fetch_row($search);
                    $exam_date=strtoupper($result[3]);$ty=strtoupper($result[4]);$result_date=strtoupper($result[5]);$rid=strtolower($result[6]);
                    echo "<center><div style='text-align:left' id='warning'><b>Exam Date &nbsp;:- </b><u>$exam_date</u><br/><b>Exam Type &nbsp;:- </b><u>$ty</u><br/><b>Result date :- </b><u>$result_date</u></div></center><br/>";
                    */
                    echo "<center><form style='text-align:center'>";
                    echo "<center><table>";
                    echo "<tr><td style='text-align:right'>Select exam :-</td>";
                            $search_rid=mysql_query("select * from result_table where lower(branch)='$branch' AND lower(sem)='$sem'");
                            echo "<td><select name='rid' style='width:500px'>";
                            while(($row=mysql_fetch_array($search_rid))) {
                                echo "<option value='".strtolower($row[6])."'>".strtoupper($row[4])." on ".strtoupper($row[3])." (declared on ".strtoupper($row[5]).")</option>";
                            }
                            echo "</select></td></tr>";
                    echo "<tr><td style='text-align:right'>Enter enrollment no :-</td><td><input type='text' name='enrollno' style='width:300px' /><input type='submit' value='show' /><input type='hidden' name='branch' value='$branch' /><input type='hidden' name='sem' value='$sem' /></td></tr>";
                    echo "</table></center></form></center>";
                }
            } else {
                ms_err("1");
            }
            echo "</div>";
        } else {
        ?>
	<div class="content">
		<center><h2>Results</h2></center><br/>
                <center>
                    <form>
                        Select branch:
                        <select name="branch" style="width:200px">
                            <?php
                            include_once 'settings.php';
                            $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
                            mysql_select_db("idtsvbt_db_faculty");
                            $search=mysql_query("select distinct branch from result_table");
                            if(cerr()) {
                                while(($row=mysql_fetch_array($search))) {
                                    echo "<option value='".strtolower($row[0])."'>".ucwords($row[0])."</option>";
                                }
                            } else {
                                ms_err("1");
                            }
                            ?>
                        </select>
                        Select semester:
                        <select name="sem" style="width:200px">
                            <?php
                            include_once 'settings.php';
                            $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
                            mysql_select_db("idtsvbt_db_faculty");
                            $search=mysql_query("select distinct sem from result_table");
                            if(cerr()) {
                                while(($row=mysql_fetch_array($search))) {
                                    echo "<option value='".strtolower($row[0])."'>".ucwords($row[0])." semester</option>";
                                }
                            } else {
                                ms_err("1");
                            }
                            ?>
                        </select>
                        <input type="submit" value="Show"/>
                    </form>
                </center>
	</div>
        <?php }} ?>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
