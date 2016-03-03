<div class="bottombar">
	<div class="footer"><center>
		<div id="logo" style="margin-top:6px">
			<?php
			if(isset($_SESSION['username'])) {
				if($_SESSION['account']!="admin") {
					$v=0;
					if(file_exists("visits.txt") && is_file("visits.txt")) {
						$v=file_get_contents("visits.txt");
						$v++;
					}
					file_put_contents("visits.txt",$v);
				}
			} else {
					$v=0;
					if(file_exists("visits.txt") && is_file("visits.txt")) {
						$v=file_get_contents("visits.txt");
						$v++;
					}
					file_put_contents("visits.txt",$v);
			}
			?>
			<marquee direction="left" behavior="alternate">
			&copy; <? echo date("Y")?> C.U.Shah. Developed by Mohan, Anil.</h3>
			</marquee>
		</div></center>
	</div>
</div>
