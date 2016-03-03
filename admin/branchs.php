<br/><h3>Branchs (Fields)</h3><br/>
<u><h5>Click on branch to delete it!!</h5></u><br/>
<?php
if(isset($_GET['create'])) {
	if(isset($_POST['bn']) && isset($_POST['sn'])) {
		if(carr($_POST)) {
			$bn=strtolower($_POST['bn']);$sn=strtolower($_POST['sn']);
			mysql_select_db("idtsvbt_db_faculty");
			$q=mysql_query("insert into branch(bname,sem) values('$bn','$sn')");
			if(cerr()) {
				echo "<div id='done'>Successfully added!!</div><br/>";
			} else {
				ms_err("2");
			}
		} else {
			ms_err("1");
		}
	}
	?>
	<form method="post"><table>
	<tr><td>Branch name :-<br/><input type="text" name="bn" style="width:400px" /></td></tr>
	<tr><td>Branch short-name :-<br/><input type="text" name="sn" style="width:400px" /></td></tr>
	<tr><td><br/><input type="submit" value="Add" /></td></tr>
	</table></form>
	<?php
} else {
?>

	<?php
	mysql_select_db("idtsvbt_db_faculty");
	if(isset($_GET['id'])) {
		$id=$_GET['id'];
        if(isset($_POST['delete'])) {
            $q=mysql_query("delete from branch where id='$id'");
            if(cerr()) {
                echo "<div id='done'>Deleted successfully!!</div><br/>";
            } else {
                ms_err("1");
            }
        } else {
        ?>
        <div id='error'><h3><div>Are you sure to delete selected notice now ?</div></h3><br/>
            <center>
                <form name="dform" id="dform" method="post"><input type="hidden" name="action" value="Delete" /><input type="hidden" name="delete" value="yes" /></form>
                <div class="linkbox">
                    <a href="javascript:void()" onclick="document.dform.submit()">YES</a> <a href="?page=branchs">NO</a>
                </div>
            </center>
        </div>
        <?php
        }
	} else {
        ?>
<table class="mytable" cellspacing="0">
	<tr class="head"><td>Branch Name.</td><td>Branch Short-name.</td></tr>
        <?php
        $q=mysql_query("select * from branch order by id desc");
        if(cerr()) {
            while(($row=mysql_fetch_array($q))) {
                echo "<tr><td><a href='accounts.php?page=branchs&id=$row[0]'>".ucwords($row[1])."</a></td><td><a href='accounts.php?page=branchs&id=$row[0]'>".strtoupper($row[2])."</a></td></tr>";
            }
        } else {
            ms_err("1");
        }
    }
	?>
</table>
<br/><div class="linkbox">
	<a href="accounts.php?page=branchs&create=yes">Add branch</a>
</div>
<?php 
}
?>
