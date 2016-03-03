<div class="content">
    <center><h3>Students of our college</h3></center><br/>
    <center>
    <form method="post">
    <table>
        <tr>
            <td>Select branch:</td>
            <td>
                <select name="branch" style="width:300px">
                    <option>[ Select branch name here ]</option>
                    <?php
                        include_once "settings.php";
                        $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
                        mysql_select_db("idtsvbt_db_faculty");
                        $getbranch="select distinct bname from branch";
                        $getbranch=mysql_query($getbranch);
                        while($row=mysql_fetch_array($getbranch)) {
                            echo "<option value='".$row['bname']."'>".$row['bname']."</option>";
                        }
                    ?>
                </select>
            </td>
	    <td>
		    <select name="sem" style="width:300px">
			    <option>[ Select semester here ]</option>
			    <?php
			    for($i=1;$i<8;$i++) {
				    echo "<option value='$i'>$i semester</option>";
			    }
			    ?>
		    </select>
	    </td>
	    <td><input type="hidden" name="page" value="1"/></td>
            <td><input type="submit" value="Search" /></td>
        </tr>
    </table>
    </form>
    </center>
    <?php
    if(isset($_POST['branch']) && isset($_POST['sem'])) {
        $branch=$_POST['branch'];$sem=$_POST['sem'];$page=$_POST['page'];
        include_once "settings.php";
        $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
        mysql_select_db("idtsvbt_db_faculty");
	if(isset($_POST['action'])) {
		if($_POST['action']=="Previous") {
			$page--;
		} else {
			$page++;
		}
	}
	$start=($page*12)-12;
	$count=mysql_query("select count(id) from profiles");
	$row=mysql_fetch_row($count);
	$total=$row[0];
        $students=mysql_query("select * from profiles where lower(branch)='".strtolower($branch)."' AND lower(sem)='".strtolower($sem)."' limit $start,12");
        if(strlen(mysql_error())==0) {
            if(mysql_affected_rows()==0) {
                echo "<center><code id='error'>No data found of selected branch!</code></center>";
            } else {
		$data['current']=$page;
		$data['total']=ceil($total/12);
                echo "<div class='boxitems' style='margin-left:20px'>";
                while(($row=mysql_fetch_array($students))) {
					if(!file_exists($row["img"])) {
						$row["img"]="none.jpg";
					}
                    echo "<a href='?profile=".$row['id']."'><img src='".$row['img']."'>".ucwords($row['fname'])."<br/>".$row['enrollno']."<br/>SPI: ".$row['spi']."</a>";
                }
                echo "</div>";
		?>
		<div style="clear:both"></div><br/>
		<center><form method="post">
			<input type="hidden" name="branch" value="<?=$branch?>"/>
			<input type="hidden" name="sem" value="<?=$sem?>"/>
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
    ?>
    <div style="clear:both"></div>
    <?php
    }
    ?>
</div>
