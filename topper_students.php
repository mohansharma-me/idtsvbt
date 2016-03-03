<div class="content">
    <center><h3>Topper students of our college</h3></center><br/>
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
            <td><input type="submit" value="Search" /></td>
        </tr>
    </table>
    </form>
    </center>
    <?php
    if(isset($_POST['branch'])) {
        $branch=$_POST['branch'];
        include_once "settings.php";
        $conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
        mysql_select_db("idtsvbt_db_faculty");
        $students=mysql_query("select t.fname,t.rank,t.sem,t.spi,p.img from toppers as t,profiles as p where lower(t.branch)='".strtolower($branch)."' AND lower(t.enrollno)=lower(p.enrollno)");
        if(strlen(mysql_error())==0) {
            if(mysql_affected_rows()==0) {
                echo "<br/><center><code id='error'>No data found of selected branch!</code></center>";
            } else {
                echo "<div class='boxitems'>";
                while(($row=mysql_fetch_array($students))) {
                    echo "<a href='javascript:void()'><img src='".$row['img']."'>".ucwords($row['fname'])."<br/>".$row['sem']." semester<br/>SPI: ".$row['spi']."<br/>Rank: ".$row['rank']."</a>";
                }
                echo "</div>";
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
