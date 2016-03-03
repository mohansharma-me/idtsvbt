<?php include_once "import.php"; ?><html>
<head>
	<title>Registration - C.U.Shah Technical Institute Of Diploma Studies, WadhwanCity</title>
	
</head>
<body>
	<?php include_once "topbar.php"; ?>
        <?php
        if(isset($_SESSION['logged'])) {
            echo("<br/><center><div id='error'>You have to logout first then you can create account!</div></center><br/>");
        } else {
        ?>
	<div class="content">
		<center><h2>Registration</h2></center><br/>
		<center>
		<?php
			if(isset($_POST['account'])) {
				if($_POST['account']=="student") {
					echo "<label><u>Student Registration</u></label><br/><br/>";
					if(isset($_POST['submit'])) {
						if(cvar($_POST['fname']) && cvar($_POST['enrollno']) && cvar($_POST['username']) && cvar($_POST['password']) && cvar($_POST['mobile']) && cvar($_POST['email']) && cvar($_POST['branch']) && cvar($_POST['sem'])) {
							$fname=strtolower($_POST['fname']);$enrollno=strtolower($_POST['enrollno']);$username=strtolower($_POST['username']);$password=strtolower($_POST['password']);$mobile=strtolower($_POST['mobile']);$email=strtolower($_POST['email']);$branch=strtolower($_POST['branch']);$sem=strtolower($_POST['sem']);
							if(is_mail($email) && is_numeric($mobile) && is_numeric($enrollno)) {
								include_once 'settings.php';
								$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
								mysql_select_db("idtsvbt_db_faculty");
								$search=mysql_query("select username from login where lower(username)='$username'");
								if(cerr()) {
									if(mysql_affected_rows()==0) {
										$search=mysql_query("select enrollno from student where enrollno='$enrollno'");
										if(cerr()) {
											if(mysql_affected_rows()==0) {
												$insertlogin=mysql_query("insert into login(username,password,acc_type,status) values('$username','$password','student','0')");
												if(cerr()) {
													$insertstudent=mysql_query("insert into student(fname,enrollno,email,branch,sem,mobile) values('$fname','$enrollno','$email','$branch','$sem','$mobile')");
													if(cerr()) {
														$getid_login=mysql_query("select id from login where lower(username)='$username'");
														$id['login']=mysql_fetch_row($getid_login);
														if(cerr()) {
															$getid_student=mysql_query("select id from student where lower(enrollno)='$enrollno'");
															$id['student']=mysql_fetch_row($getid_student);
															if(cerr()) {
																$update_login=mysql_query("update login set acc_id='".$id['student'][0]."' where id='".$id['login'][0]."'");
																if(cerr()) {
																	$update_student=mysql_query("update student set acc_id='".$id['login'][0]."' where id='".$id['student'][0]."'");
																	if(cerr()) {
																		$sent_req=mysql_query("insert into acc_request(username,acc_type) values('$username','student')");
																		if(cerr()) {
																			echo "<div id='done'>Congratulation ".strtoupper($fname).", your account details is sent to administrator for verifies your submitted details<br/>and you have to wait until administrator verifies your account details.<br>Thank You</div>";
																		} else {
																			ms_err("9");
																		}
																	} else {
																		ms_err("8");
																	}
																} else {
																	ms_err("7");
																}
															} else {
																ms_err("6");
															}
														} else {
															ms_err("5");
														}
													} else {
														ms_err("4");
													}
												} else {
													ms_err("3");
												}
											} else {
												echo "<div id='error'>Sorry, this enrollment no is already registered<br>we do not allow a multiple account for one student.</div>";
											}
										} else {
											ms_err("2");
										}
									} else {
										echo "<div id='error'>Sorry, this username is already taken, <br/>please choose another one to register!</div>";
									}
								} else {
									ms_err("1");
								}
							} else {
								echo "<div id='error'>Mobile number or Email address or Enrolment no is in incorrect format!</div>";
							}
						} else {
							echo "<div id='error'>You have to fill all the textbox to done your registration</div>";
						}
					} else {
						echo "<div id='warning'>You have to fill all the textbox to done your registration!</div>";
					}
				?>
				<br/><br/>
				<form action="register.php?step3" method="post">
				<table>
					<tr>
						<td>Full name:</td>
						<td>Enrollment no:</td>
					</tr>
					<tr>
						<td><input type="text" name="fname" style="width:300px"/></td>
						<td><input type="text" name="enrollno" style="width:300px"/></td>
					</tr>
					<tr>
						<td>Username:</td>
						<td>Password:</td>
					</tr>
					<tr>
						<td><input type="text" name="username" style="width:300px"/></td>
						<td><input type="password" name="password" style="width:300px"/></td>
					</tr>
					<tr>
						<td>Mobile number:</td>
						<td>Email address:</td>
					</tr>
					<tr>
						<td><input type="text" name="mobile" style="width:300px"/></td>
						<td><input type="text" name="email" style="width:300px"/></td>
					</tr>
					<tr>
						<td>Branch:</td>
						<td>Semester:</td>
					</tr>
					<tr>
						<td>
							<select name="branch" style="width:300px">
								<option>[ Select your branch ]</option>
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
								<option>[ Select your semester ]</option>
								<?php
									for($i=1;$i<8;$i++) {
										echo "<option value='$i'>$i</option>";
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align:center"><br/><a href="javascript:history.go(-1)"><< Back</a></td>
						<td style="text-align:center"><br/><input type="submit" value="Next >>"/></td>
					</tr>
					<tr>
						<td><input type="hidden" name="account" value="student"/></td>
						<td><input type="hidden" name="submit" value="yes"/></td>
					</tr>
				</table>
				</form>
				<?php
				} elseif($_POST['account']=="faculty") {
                                    echo "<label><u>Faculty Registration</u></label><br/><br/>";
				    if(isset($_POST['submit'])) {
					if(cvar($_POST['fname']) && cvar($_POST['desg']) && cvar($_POST['username']) && cvar($_POST['password']) && cvar($_POST['email']) && cvar($_POST['mobile']) && cvar($_POST['address'])) {
						$fname=strtolower($_POST['fname']);$desg=strtolower($_POST['desg']);$username=strtolower($_POST['username']);$password=strtolower($_POST['password']);$email=strtolower($_POST['email']);$mobile=strtolower($_POST['mobile']);$address=strtolower($_POST['address']);
						if(is_mail($email) && is_numeric($mobile)) {
							include_once 'settings.php';
							$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
							mysql_select_db("idtsvbt_db_faculty");
							$search=mysql_query("select username from login where lower(username)='$username'");
							if(cerr()) {
								if(mysql_affected_rows()==0) {
									$insertlogin=mysql_query("insert into login(username,password,acc_type,status) values('$username','$password','faculty','0')");
									if(cerr()) {
										$insertfaculty=mysql_query("insert into faculty(fname,desg,email,mobile,address) values('$fname','$desg','$email','$mobile','$address')");
										if(cerr()) {
											$getid_login=mysql_query("select id from login where lower(username)='$username'");
											$id['login']=mysql_fetch_row($getid_login);
											if(cerr()) {
												$getid_faculty=mysql_query("select id from faculty where lower(fname)='$fname' AND lower(email)='$email' AND lower(desg)='$desg' AND lower(mobile)='$mobile'");
												$id['faculty']=mysql_fetch_row($getid_faculty);
												if(cerr()) {
													$update_login=mysql_query("update login set acc_id='".$id['faculty'][0]."' where id='".$id['login'][0]."'");
													if(cerr()) {
														$update_student=mysql_query("update faculty set acc_id='".$id['login'][0]."' where id='".$id['faculty'][0]."'");
														if(cerr()) {
															$sent_req=mysql_query("insert into acc_request(username,acc_type) values('$username','faculty')");
															if(cerr()) {
																echo "<div id='done'>Congratulation ".strtoupper($fname).", your account details is sent to administrator for verifies your submitted details<br/>and you have to wait until administrator verifies your account details.<br>Thank You</div>";
															} else {ms_err("8");}
														} else {ms_err("7");}
													} else {ms_err("6");}
												} else {ms_err("5");}
											} else {ms_err("4");}
										} else {ms_err("3");}
									} else {ms_err("2");}
								} else {
									echo "<div id='error'>Sorry, this username is already taken.<br>please choose another one to complete registration!</div>";
								}
							} else {ms_err("1");}
						} else {
							echo "<div id='error'>Mobile number or Email address is in incorrect format.<br>Try to submit correct data.</div>";
						}
					} else {
						echo "<div id='error'>You have to fill up all the textbox to complete registeration!</div>";
					}
				    }
                                ?>
                                <br/><br/>
                                <form action="register.php?step3" method="post">
                                <table>
                                    <tr>
                                        <td>Full name:</td>
                                        <td>Designation:</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="fname" style="width:300px"/></td>
                                        <td><input type="text" name="desg" style="width:300px"/></td>
                                    </tr>
                                    <tr>
                                        <td>Username:</td>
                                        <td>Password:</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="username" style="width:300px"/></td>
                                        <td><input type="password" name="password" style="width:300px"/></td>
                                    </tr>
                                    <tr>
                                        <td>Email address:</td>
                                        <td>Mobile number:</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="email" style="width:300px"/></td>
                                        <td><input type="text" name="mobile" style="width:300px"/></td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="address" style="width:300px"/></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center"><br/><a href="javascript:history.go(-1)"><< Back</a></td>
                                        <td style="text-align:center"><br/><input type="submit" value="Next >>"/></td>
                                    </tr>
                                    <tr>
                                            <td><input type="hidden" name="account" value="faculty"/></td>
                                            <td><input type="hidden" name="submit" value="yes"/></td>
                                    </tr>
                                </table>
                                </form>
                                <?php
                                } elseif($_POST['account']=="parents") {
                                    echo "<label><u>Parents Registration</u></label><br/><br/>";
				    if(isset($_POST['submit'])) {
					    if(cvar($_POST['username']) && cvar($_POST['password']) && cvar($_POST['fname']) && cvar($_POST['email']) && cvar($_POST['mobile']) && cvar($_POST['address']) && cvar($_POST['qual']) && cvar($_POST['occ']) && cvar($_POST['enrollno']) && cvar($_POST['branch']) && cvar($_POST['sem'])) {
						$username=strtolower($_POST['username']);$password=strtolower($_POST['password']);$fname=strtolower($_POST['fname']);$email=strtolower($_POST['email']);$mobile=strtolower($_POST['mobile']);$address=strtolower($_POST['address']);$qual=strtolower($_POST['qual']);$occ=strtolower($_POST['occ']);$enrollno=strtolower($_POST['enrollno']);$branch=strtolower($_POST['branch']);$sem=strtolower($_POST['sem']);
						if(is_mail($email) && is_numeric($mobile) && is_numeric($mobile)) {
							include_once 'settings.php';
							$conn=mysql_connect(serverinfo::$server,serverinfo::$username,serverinfo::$password);
							mysql_select_db("idtsvbt_db_faculty");
							$search=mysql_query("select username from login where lower(username)='$username'");
							if(cerr()) {
								if(mysql_affected_rows()==0) {
									$insert_login=mysql_query("insert into login(username,password,acc_type,status) values('$username','$password','parents','0')");
									if(cerr()) {
										$insert_parents=mysql_query("insert into parents(fname,email,mobile,address,qual,occ,enrollno,branch,sem) values('$fname','$email','$mobile','$address','$qual','$occ','$enrollno','$branch','$sem')");
										if(cerr()) {
											$getid_login=mysql_query("select id from login where lower(username)='$username'");
											$id['login']=mysql_fetch_row($getid_login);
											if(cerr()) {
												$getid_parents=mysql_query("select id from parents where lower(fname)='$fname' AND lower(email)='$email' AND lower(mobile)='$mobile' AND lower(enrollno)='$enrollno'");
												$id['parents']=mysql_fetch_row($getid_parents);
												if(cerr()) {
													$update_login=mysql_query("update login set acc_id='".$id['parents'][0]."' where id='".$id['login'][0]."'");
													if(cerr()) {
														$update_parents=mysql_query("update parents set acc_id='".$id['login'][0]."' where id='".$id['parents'][0]."'");
														if(cerr()) {
															$sent_req=mysql_query("insert into acc_request(username,acc_type) values('$username','parents')");
															if(cerr()) {
																echo "<div id='done'>Congratulation ".strtoupper($fname).", your account details is sent to administrator for verifies your submitted details<br/>and you have to wait until administrator verifies your account details.<br>Thank You</div>";
															} else {ms_err("8");}
														} else {ms_err("7");}
													} else {ms_err("6");}
												} else {ms_err("5");}
											} else {ms_err("4");}
										} else {echo mysql_error();ms_err("3");}
									} else {ms_err("2");}
								} else {
									echo "<div id='error'>Sorry, this username is already taken,<br>please try another one to register!</div>";
								}
							} else {ms_err("1");}
						} else {
							echo "<div id='error'>Mobile number or Email address or Enrollment no is in incorrect format,<br>Try to submit correct data.</div>";
						}
					    } else {
						echo "<div id='error'>You have to fill up all the textbox to complete registeration!</div>";
					    }
				    }
                                ?>
                                <br/><br/>
                                <form method="post">
                                <center><u>:: Parents Details ::</u></center><br/>
                                <table>
                                    <tr>
                                        <td>Username:</td>
                                        <td>Password:</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="username" style="width:300px"/></td>
                                        <td><input type="password" name="password" style="width:300px"/></td>
                                    </tr>
                                    <tr>
                                        <td>Full name:</td>
                                        <td>Email address:</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="fname" style="width:300px"/></td>
                                        <td><input type="text" name="email" style="width:300px"/></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile number:</td>
                                        <td>Address:</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="mobile" style="width:300px"/></td>
                                        <td><input type="text" name="address" style="width:300px"/></td>
                                    </tr>
                                    <tr>
                                        <td>Qualification:</td>
                                        <td>Occupation:</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="qual" style="width:300px"/></td>
                                        <td><input type="text" name="occ" style="width:300px"/></td>
                                    </tr>
                                </table>
                                <br/><center><u>:: Student Details ::</u></center><br/>
                                <table>
                                    <tr>
                                        <td>Enrollment no:</td>
                                        <td>Branch:</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="enrollno" style="width:300px"/></td>
                                        <td>
                                            <select name="branch" style="width:300px">
                                                <option>[ Select branch ]</option>
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
                                    </tr>
                                    <tr>
                                        <td style="text-align:right">Select semester:</td>
                                        <td>
                                            <select name="sem" style="width:300px">
                                                <option>[ Select semester ]</option>
                                                <?php
                                                    for($i=1;$i<8;$i++) {
                                                        echo "<option value='$i'>$i</option>";
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center"><br/><a href="register.php"><< Back</a></td>
                                        <td><br/><input type="submit" value="Next >>"/></td>
                                    </tr>
                                    <tr>
                                            <td><input type="hidden" name="account" value="parents"/></td>
                                            <td><input type="hidden" name="submit" value="yes"/></td>
                                    </tr>
                                </table>
                                </form>
                                <?php
                                }
			} else {
		?>
		<form action="register.php?step2" method="post">
		<table>
			<tr>
				<td>Select type of account you want to create:</td>
				<td>
					<select name="account" style="width:200px">
						<option value="student">Student account</option>
						<option value="faculty">Faculty account</option>
						<option value="parents">Parents account</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td><td><input type="submit" value="Next >>" /></td>
			</tr>
		</table>
		</form>
		<?php
			}
		?>
		</center>
	</div>
        <?php } ?>
	<?php include_once "bottombar.php"; ?>
</body>
</html>
