<br/><h3>Contact us - Inbox</h3><br/>
<u><h5>Click on message to delete it!!</h5></u><br/>
	<?php
	mysql_select_db("idtsvbt_db_faculty");
	if(isset($_GET['id'])) {
		$id=$_GET['id'];
        if(isset($_POST['delete'])) {
            $q=mysql_query("delete from contactus where id='$id'");
            if(cerr()) {
                echo "<div id='done'>Deleted successfully!!</div><br/>";
            } else {
                ms_err("1");
            }
        } else {
        ?>
        <div id='error'><h3><div>Are you sure to delete selected message now ?</div></h3><br/>
            <center>
                <form name="dform" id="dform" method="post"><input type="hidden" name="action" value="Delete" /><input type="hidden" name="delete" value="yes" /></form>
                <div class="linkbox">
                    <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=inbox">NO</a>
                </div>
            </center>
        </div>
        <?php
        }
	} else {
    ?>
<table class="mytable" cellspacing="0">
	<tr class="head"><td>Date.</td><td>Name.</td><td>Subject.</td><td>Message.</td></tr>
    <?php
	$q=mysql_query("select * from contactus order by id desc");
	if(cerr()) {
		while(($row=mysql_fetch_array($q))) {
			echo "<tr><td><a href='accounts.php?page=inbox&id=$row[0]'>$row[4]</a></td><td><a href='accounts.php?page=inbox&id=$row[0]'>$row[1]</a></td><td><a href='accounts.php?page=inbox&id=$row[0]'>$row[2]</a></td><td><a href='accounts.php?page=inbox&id=$row[0]'>$row[3]</a></td></tr>";
		}
	} else {
		ms_err("1");
	}
	?>
</table>

<?php } ?>