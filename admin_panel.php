<?php
if(isset($hidesidebar)) {
} else {
$hidesidebar=false;
?>
<div class="sidebar-right">
	<h3>Control Panel</h3>
	<hr/>
	<div align=left style="padding-left:20px;height:auto" class="msgs">
		<li><a href="accounts.php?page=students">Students</a></li>
		<li><a href="accounts.php?page=faculties">Faculties</a></li>
		<li><a href="accounts.php?page=results">Results</a></li>
		<li><a href="accounts.php?page=circulars">Circulars</a></li>
		<li><a href="accounts.php?page=downloads">Downloads</a></li>
		<li><a href="accounts.php?page=noticeboard">Notice Board</a></li>
		<li><a href="accounts.php?page=timetable">Time table</a></li>
		<li><a href="accounts.php?page=gallery">Gallery</a></li>
		<li><a href="accounts.php?page=attendance">Attendance</a></li>
		<li><a href="accounts.php?page=subscribes">Subscribes</a></li>
		<li><a href="accounts.php?page=accounts">Accounts</a></li>
		<li><a href="accounts.php?page=clgprofile">College Profile</a></li>
		<li><a href="accounts.php?page=fees">Fees details</a></li>
		<li><a href="accounts.php?page=requests">Requests</a>
		<li><a href="accounts.php?page=branchs">Branchs (Fields)</a></li>
		<li><a href="accounts.php?page=inbox">Contact us (Inbox)</a></li>
		<li><a href="accounts.php?page=news">Latest news</a></li>
		<li><a href="accounts.php?page=pages">Pages</a></li>
		<li><a href="accounts.php?page=mgntp">Management profiles</a></li>
		<li><a href="accounts.php?page=principal">Principal details</a></li>
		<li><a href="accounts.php?page=uploads">Upload File</a></li>
		<li><a href="accounts.php?page=import">Import data</a></li>
		<li><a href="accounts.php?page=permission">Permission</a></li>	
		<li><a href="accounts.php?logout=<?=$_SESSION['id']?>">Logout</a></li>
	</div>
</div>
<?php } ?>
<div class="sidebar-left">
	<center><h4>Welcome <?=$_SESSION['username']?> as  <?=ucwords($_SESSION['account'])?>.</h4><hr/>
	<?php
	include_once 'settings.php';
	$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
	if(isset($_GET['page'])) {
		$page=strtolower($_GET['page']);
		$file="./admin/".strtolower($page).".php";
		if(file_exists($file) && is_file($file)) {
			include_once $file;
		} else {
			echo "<br/><div id='error'>Invalid function!!</div>";
		}
	}
    if(!isset($_GET['page']) && $hidesidebar==false) {
	?>
        
	<br/>
	Welcome admin, now you can manage whole college website at one place... and there is any problem any page you can directly contact the site developer using him email address... you get it from contact us page..
	<br/><br/>
    <b>Function of administrator :-</b><br/><br/>
    <div class="linkbox">
        <a href="accounts.php?page=students">Students</a>
		<a href="accounts.php?page=faculties">Faculties</a>
		<a href="accounts.php?page=results">Results</a>
		<a href="accounts.php?page=circulars">Circulars</a>
		<a href="accounts.php?page=downloads">Downloads</a>
		<a href="accounts.php?page=noticeboard">Notice Board</a>
		<a href="accounts.php?page=timetable">Time table</a><br/><br/>
		<a href="accounts.php?page=gallery">Gallery</a>
		<a href="accounts.php?page=attendance">Attendance</a>
		<a href="accounts.php?page=subscribes">Subscribes</a>
		<a href="accounts.php?page=accounts">Accounts</a>
		<a href="accounts.php?page=clgprofile">College Profile</a>
		<a href="accounts.php?page=fees">Fees details</a><br/><br/>
		<a href="accounts.php?page=requests">Requests</a>
		<a href="accounts.php?page=branchs">Branchs (Fields)</a>
		<a href="accounts.php?page=inbox">Contact us (Inbox)</a>
		<a href="accounts.php?page=news">Latest news</a>
		<a href="accounts.php?page=pages">Pages</a><br/><br/>
		<a href="accounts.php?page=permission">Permission</a>
		<a href="accounts.php?page=mgntp">Management profiles</a>
		<a href="accounts.php?page=principal">Principal details</a>
		<a href="accounts.php?page=uploads">Upload file</a>
		<a href="accounts.php?page=import">Import data</a>
		<br/><br/><br/>
		<a href="accounts.php?logout=<?=$_SESSION['id']?>" style="padding:13px">Logout</a>
    </div>
    <?php } else { 
		if($_SESSION['account']!="admin")
			echo "<br/><div id='warning'>Administrator give you an special permission to do an work as administrator on this website!!<br/>Your available funtions are displayed in Control Panel!!</div><br/>"; 
	}?>
	<br/><hr/></center>
</div>
<div style="clear:both"></div>
