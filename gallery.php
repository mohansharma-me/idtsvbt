<?php include_once "import.php"; ?><html>
<head>
	<title>Gallery - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	<style type="text/css">
            
	</style>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
        <?php
        if(isset($_GET['album']) && isset($_GET['t']) && isset($_GET['id'])) {
            $album=strtolower($_GET['album']);$t=strtolower($_GET['t']);$id=strtolower($_GET['id']);
            include_once 'settings.php';
            $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
            mysql_select_db("idtsvbt_db_faculty");
            $search=mysql_query("select * from $t where id='$id'");
            if(cerr()) {
            $row=mysql_fetch_row($search);
            echo "<div class='content'>";
        ?>
        <center><div id='warning' style="text-align:left">
            <b>Album :- </b><u><?=ucwords($album)?></u><br/>
            <b>Title :- </b><u><?=ucwords($row[1])?></u><br/>
            <b>Description :- </b><br/><?=ucwords($row[2])?><br/>
            <?php if($t=="videos") { ?>
            <b>Download/Play :-</b><br/>
            <a target="_blank" href="<?=$row[4]?>"><?=$row[4]?></a>
            <?php } ?>
        </div><br/>
        <img src="<?=($t=="videos"?$row[5]:$row[4])?>"/><br/><br/>
        <a href="javascript:history.back(0)"><< Go Back</a>
        </center>
        <?php
            echo "</div>";
            } else {
                ms_err("1");
            }
        } else {
        ?>
	<div class="content">
		<?php
                if(isset($_POST['album'])) {
                    $album=strtolower($_POST['album']);
                    include_once 'settings.php';
                    $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
                    mysql_select_db("idtsvbt_db_faculty");
                    $search=mysql_query("select * from albums where lower(atitle)='$album'");
                    if(cerr()) {
                        if(mysql_affected_rows()==0) {
                            echo "<div id='error'>Sorry, no data found for selected albums</div>";
                        } else {
                            $row=mysql_fetch_row($search);
                            $count=mysql_query("select count(id) from $row[3] where lower(album)='".strtolower($album)."'");
                            $rows=mysql_fetch_row($count);
                            $total=$rows[0];
                            echo "<center><div id='warning' style='text-align:left'>";
                            echo "<b>Album name :- </b><u>".ucwords($album)."</u><br/>";
                            echo "<b>Album description: (Total ".ucwords($row[3]).":$total)</b><br/>".ucwords($row[2])."<br/>";
                            echo "<b>Album type :- </b>".ucwords($row[3])."<br/>";
                            echo "</div></center><br/>";
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
                            $start=($page*12)-12;
                            
                            $pictures=mysql_query("select * from $row[3] where lower(album)='".$album."' limit $start,12");
                            if(cerr()) {
                                if(mysql_affected_rows()==0) {
                                    echo "<center><div id='green'>Sorry no albums items found!</div></center>";
                                } else {
                                    $data['current']=$page;
                                    $data['total']=ceil($total/12);
                                    echo "<div class='boxitems' style='margin-left:20px'>";
                                    while(($rowo=mysql_fetch_array($pictures))) {
                                        echo "<a href='gallery.php?album=$album&t=$row[3]&id=$rowo[0]'><img src='".($row[3]=="videos"?$rowo[5]:$rowo[4])."'/><br/>$rowo[1]<br>".substr($rowo[2],0,30)."...</a>";
                                    }
                                    echo "</div>";
                                    echo "<div style='clear:both'></div>";
                                    ?><br/>
                                    <center><form method="post">
                                            <input type="hidden" name="album" value="<?=$album?>"/>
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
                                echo mysql_error();
                            }
                        }
                    }
                ?>
                
                <?php
                } else {
                ?>
                <center><h2>Gallery</h2></center><br/>
                <center>
                <form method="post">
                    <label>Select albums:</label>
                    <select name="album" style="width:300px">
                        <?php
			include_once 'settings.php';
			$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
			mysql_select_db("idtsvbt_db_faculty");
			$latest_news=mysql_query("select * from albums order by id desc");
			while($row=mysql_fetch_array($latest_news)) {
				$title=$row["atitle"];$ty=ucwords($row["atype"]);
				echo "<option value='".strtolower($title)."'>".ucwords($title)." ($ty)</option>";
			}
                        ?>
                    </select>
                    <input type="submit" value="Show"/>
                </form>
                </center>
                <?php
                }
                ?>
	</div>
        <?php
        }
        ?>
	<?php include_once "bottombar.php"; ?>
</body>
</html>









