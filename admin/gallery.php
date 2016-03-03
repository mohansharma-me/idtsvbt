<br/><h3>Gallery</h3><br/>
<?php
if(isset($_GET['album'])) {
	if($_GET['album']=="create") {
		if(isset($_POST['at']) && isset($_POST['aty']) && isset($_POST['ad'])) {
			if(carr($_POST)) {
				$at=strtolower($_POST['at']);$ad=strtolower($_POST['ad']);$aty=strtolower($_POST['aty']);
				mysql_select_db("idtsvbt_db_faculty");
				$ins=mysql_query("insert into albums(atitle,adesc,atype) values('$at','$ad','$aty')");
				if(cerr()) {
					echo "<div id='done'>".ucwords($aty)." album created successfully!!</div><br/>";
				} else {
					ms_err("1");
				}
			} else {
				echo "<div id='error'>You have to fill all the textbox(s) to create new album!!</div><br/>";
			}
		}
	?>
	<form method="post" style="text-align:left">
		<b>Album title :-</b><br/><input type="text" name="at" style="width:100%" /><br/>
		<b>Album description :-</b><br/><input type="text" name="ad" style="width:100%" /><br/>
		<b>Album type :-</b><br/><select name="aty" style="width:100%"><option value="photos">Photos</option><option value="videos">Videos</option></select><br/>
		<input type="submit" value="Create" />
	</form>
	<?php
	} elseif($_GET['album']=="delete") {
		if(isset($_POST['nm'])) {
			$nm=strtolower($_POST['nm']);
			mysql_select_db("idtsvbt_db_faculty");
			$del=mysql_query("delete from albums where atitle='$nm'");
			if(cerr()) {
				$del=mysql_query("delete from photos where album='$nm'");
				$del=mysql_query("delete from videos where album='$nm'");
				echo "<div id='done'>Deleted successfully!!</div><br/>";
			} else {
				ms_err("1");
			}
		}
	?>
	<form method="post" style="text-align:left">
	<b>Select album to remove it :-</b><br/>
		<select name="nm" style="width:100%">
			<?php
			mysql_select_db("idtsvbt_db_faculty");
			$se=mysql_query("select atitle,atype from albums");
			while(($row=mysql_fetch_row($se))) {
				echo "<option value='$row[0]'>".ucwords($row[0])." (".ucwords($row[1]).")</option>";
			}
			?>
		</select><br/>
		<input type="submit" value="Delete it!" /> <h6><span>When you delete perticular album then its all items also deleted with it!!</span></h6>
	</form>
	<?php
	} elseif($_GET['album']=="add") {
		if(isset($_POST['action']))  {
			if($_POST['action']=="Next >") {
				$it=$_POST['it'];
				if($it=="photos") {
					if(isset($_POST['saction'])) {
						if($_POST['saction']=="Upload") {
							if(carr($_POST)) {
								$pt=strtolower($_POST['pt']);$pd=strtolower($_POST['pd']);$al=strtolower($_POST['al']);$pu=strtolower($_POST['pu']);
								$save="./gallery/$al"."_"."$pt.jpg";
								move_uploaded_file($_FILES['img']['tmp_name'],$save);
								mysql_select_db("idtsvbt_db_faculty");
								$ins=mysql_query("insert into photos(ptitle,pdesc,album,plink,public) values('$pt','$pd','$al','$save','$pu')");
								if(cerr()) {
									echo "<div id='done'>Successfully added!!</div><br/>";
								} else {
									ms_err("1");
								}
							} else {
								echo "<div id='error'>You have to fill all the textbox(s) to add new photo!!</div><br/>";
							}
						}
					}
					?>
					<form method="post" style="text-align:left" enctype="multipart/form-data">
					<b>Title :-</b><br/><input type="text" name="pt" style="width:100%" /><br/>
					<b>Description :-</b><br/><input type="text" name="pd" style="width:100%" /><br/>
					<b>Select album :-</b><br/>
						<select name="al" style="width:100%">
						<?php
						mysql_select_db("idtsvbt_db_faculty");
						$q=mysql_query("select atitle from albums where atype='photos'");
						while(($row=mysql_fetch_row($q))) {
							echo "<option value='$row[0]'>".ucwords($row[0])."</option>";
						}
						?>
						</select><br/>
					<b>Public :-</b><br/><select name="pu" style="width:100%"><option value="y">Yes</option><option value="n">No</option></select><br/>
					<b>Photo :-</b><br/><input type="file" name="img" style="width:100%" /><br/>
					<input type="hidden" name="action" value="Next >" /><input type="hidden" name="it" value="photos" />
					<input name="saction" type="submit" value="Upload" />
					</form>
					<?php
				} else {
					if(isset($_POST['saction'])) {
						if($_POST['saction']=="ADD") {
							if(carr($_POST)) {
								$pt=strtolower($_POST['pt']);$pd=strtolower($_POST['pd']);$al=strtolower($_POST['al']);$vid=strtolower($_POST['vid']);
                                if(substr($vid,0,7)!="http://") {
                                    $vid="http://".$vid;
                                }
								mysql_select_db("idtsvbt_db_faculty");
								$ins=mysql_query("insert into videos(vtitle,vdesc,album,vlink,vimg) values('$pt','$pd','$al','$vid','img/vid.jpg')");
								if(cerr()) {
									echo "<div id='done'>Successfully added!!</div><br/>";
								} else {
									ms_err("1");
								}
							} else {
								echo "<div id='error'>You have to fill all the textbox(s) to add new photo!!</div><br/>";
							}
						}
					}
					?>
					<form method="post" style="text-align:left" enctype="multipart/form-data">
					<b>Title :-</b><br/><input type="text" name="pt" style="width:100%" /><br/>
					<b>Description :-</b><br/><input type="text" name="pd" style="width:100%" /><br/>
					<b>Select album :-</b><br/>
						<select name="al" style="width:100%">
						<?php
						mysql_select_db("idtsvbt_db_faculty");
						$q=mysql_query("select atitle from albums where atype='videos'");
						while(($row=mysql_fetch_row($q))) {
							echo "<option value='$row[0]'>".ucwords($row[0])."</option>";
						}
						?>
						</select><br/>
					<b>Youtube video link :-</b><br/><input type="text" name="vid" style="width:100%" /><br/>
					<input type="hidden" name="action" value="Next >" /><input type="hidden" name="it" value="videos" />
					<input name="saction" type="submit" value="ADD" />
					</form>
					<?php
				}
			}
		} else {
		?>
		<form method="post" style="text-align:left">
			<b>Select item type:-</b><br/>
				<select name="it" style="width:100%"><option value="photos">Photos</option><option value="videos">Videos</option></select><br/>
				<input type="submit" name="action" value="Next >" />
		</form>
		<?php
		}
	}
}
?>
<br/><hr/><br/><div class="linkbox">
	<a href="accounts.php?page=gallery&album=create">Create album</a>
	<a href="accounts.php?page=gallery&album=delete">Delete album</a>
	<br/><br/>
	<a href="accounts.php?page=gallery&album=add">Add item to album</a>
</div>

