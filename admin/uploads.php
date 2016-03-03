<br/><h3>Upload your file</h3><br/>
<?php
if(isset($_GET['do'])) {
	if($_GET['do']=="upload") {
		echo "<br/><h4>Upload form</h4>";
		if(isset($_POST['action'])) {
			$nm=$_POST['nm'];
			$file="./download/$nm".".".substr($_FILES['file']['name'],-3,3);
			if(file_exists($file) && is_file($file)) {
				echo "<div id='warning'>This file is already exists!! try with different name please!!</div><br/>";
			} else {
				if($_FILES['file']['size']>0) {
					if(move_uploaded_file($_FILES['file']['tmp_name'],$file)) {
						echo "<div id='done'>Your file is uploaded!!<br/><a href='$file'>You can download it by clicking here</a></div><br/>";
					} else {
						echo "<div id='error'>Something went wrong, server can accept this file!! try again after sometime!!</div><br/>";
					}
				} else {
					echo "<div id='error'>Please select file to upload it!!</div><br/>";
				}
			}
		}
		?>
		<form method="post" enctype="multipart/form-data" style="text-align:left">
			<b>Enter filename :-</b><br/><input type="text" name="nm" style="width:100%"/><br/>
			<b>Select file :-</b><br/><input type="file" name="file" style="width:100%" /><br/>
			<input type="submit" value="Upload" name="action"/>
		</form>
		<?php
	} else {
		echo "<br/><h4>Remove file</h4><br/>";
		if(isset($_GET['file'])) {
			$file=$_GET['file'];
			$file=str_replace("./","./",$file);
			$file=str_replace("../","./",$file);
			$ff="./download/$file";
			if(file_exists($ff) && is_file($ff)) {
				if(unlink($ff)) {
					echo "<div id='done'>File removed!!</div><br/>";
				} else {
					echo "<div id='error'>Sorry did not allow me to delete this file!!</div><br/>";
				}
			} else {
				echo "<div id='error'>Sorry selected file doesnt exists!!</div><br/>";
			}
		}
		?>
		<table class="mytable" cellspacing="0">
			<tr class="head"><td style="width:5%">ID</td><td>FILENAME</td></tr>
			<?php
			$dir=scandir("./download/");
			for($i=0;$i<count($dir);$i++) {
				$file=$dir[$i];$ff="./download/$file";
				if(file_exists($ff) && is_file($ff)) {
					echo "<tr><td><a href='?page=uploads&do=remove&file=$file'>".($i+1)."</a></td><td><a href='?page=uploads&do=remove&file=$file'>".strtoupper($file)."</a></td></tr>";
				}
			}
			?>
		</table>
		<?php
	}
}
?>
<br/><div class="linkbox">
	<a href="?page=uploads&do=upload">Upload file</a>
	<a href="?page=uploads&do=remove">Remove file</a>
</div>
