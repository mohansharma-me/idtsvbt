<br/><h3>Subscription</h3><br/>
<?php
if(isset($_GET['send'])) {
    if(isset($_POST['msg'])) {
        $msg=$_POST['msg'];
        $headers = "From:no-reply@vbtidts.com\r\n";
        mysql_select_db("idtsvbt_db_faculty");
        $se=mysql_query("select * from subscribers");
        $arr="";$i=0;
        while(($row=mysql_fetch_array($se))) {
            if(strlen($arr)==0) {
                $arr=$row[1].",";
            } else {
                $arr.=$row[1].",";
            }
            $i++;
        }
        $recipients = trim($arr,",");
        if(mail($recipients, "C.U. Shah Technical Institute Of Diploma Studies, WadhwanCity",$msg, $headers)) {
            echo "<div id='done'>Successfully sent to $i mailbox(s)!!</div><br/>";
        } else {
            echo "<div id='error'>Cant sent,check your SMTP server settings!!</div><br/>";
        }
    } else {
        echo "<form method='post' style='text-align:left'>";
            echo "<b>Message:-</b><br/><textarea name='msg' style='width:100%;height:120px'></textarea><br/>";
            echo "<input type='submit' value='SEND' />";
        echo "</form>";
    }
} else {
    mysql_select_db("idtsvbt_db_faculty");
    if(isset($_GET['id'])) {
        $id=$_GET['id'];
        if(isset($_POST['delete'])) {
            $q=mysql_query("delete from subscribers where id='$id'");
            if(cerr()) {
                echo "<div id='done'>Deleted successfully!!</div><br/>";
            } else {
                ms_err("1");
            }
        } else {
        ?>
        <div id='error'><h3><div>Are you sure to delete selected subscriber now ?</div></h3><br/>
            <center>
                <form name="dform" id="dform" method="post"><input type="hidden" name="delete" value="yes" /></form>
                <div class="linkbox">
                    <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=subscribes">NO</a>
                </div>
            </center>
        </div>
        <?php
        }
    } else {
    $q=mysql_query("select * from subscribers");
        if(cerr()) {
            echo "<h4><u><code>Click on email address to delete it!!</code></u></h4><br/>";
            echo "<table class='mytable' cellspacing='0'>";
            echo "<tr class='head'><td>Email address :</td></tr>";
            while(($row=mysql_fetch_array($q))) {
                echo "<tr><td><a href='?page=subscribes&id=$row[0]'>".strtoupper($row[1])."</a></td></tr>";
            }
            echo "</table>";
        } else {
            ms_err("1");
        }
    }
    ?>
    <br/><div class="linkbox">
        <a href="?page=subscribes&send=msg">Send Message (ALL)</a>
    </div>
<?php 
}
?>