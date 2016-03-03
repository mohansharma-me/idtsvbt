<?php
$con = mysql_connect("localhost","root","");
if (!$con) {die('Could not connect: ' . mysql_error());}
mysql_query("drop database accounts");
mysql_query("drop database clgmg");
mysql_query("drop database results");
mysql_query("drop database gallery");

mysql_query("create database clgmg");
echo mysql_error()."<br>";
mysql_query("create database accounts");
echo mysql_error()."<br>";
mysql_query("create database results");
echo mysql_error()."<br>";
mysql_query("create database gallery");
echo mysql_error()."<br>";


mysql_select_db("idtsvbt_db_faculty");
echo mysql_error()."<br>";
    mysql_query("create table albums(id int(4) not null auto_increment unique,atitle text,adesc text,atype text)");
    echo mysql_error()."<br>";
    mysql_query("create table photos(id int(4) not null auto_increment unique,ptitle text,pdesc text,album text,plink text,public text)");
    echo mysql_error()."<br>";
    mysql_query("create table videos(id int(4) not null auto_increment unique,vtitle text,vdesc text,album text,vlink text,vimg text)");
    echo mysql_error()."<br>";
    
    
mysql_select_db("idtsvbt_db_faculty");
echo mysql_error()."<br>";
	mysql_query("create table messages(id int(4) not null auto_increment unique,fr text,tto text,msg text,td text,readed text)");
	echo mysql_error()."<br>";
	mysql_query("create table contactus(id int(4) not null auto_increment unique,tname text,tsubj text,tmsg text,tdate text)");
	echo mysql_error()."<br>";
	mysql_query("create table mgntp(id int(4) not null auto_increment unique,name text,respect text,post text,img text)");
	mysql_query("create table branch(id int(4) not null auto_increment unique,bname text,sem text)");
	echo mysql_error()."<br>";
            mysql_query("insert into branch(bname,sem) values('Computer Engineering','c.e.')");
            echo mysql_error()."<br>";
            mysql_query("insert into branch(bname,sem) values('Information Technology','i.t.')");
            echo mysql_error()."<br>";
	mysql_query("create table pages(id int(4) not null auto_increment unique,title text,body text,auth text,pdesc text,adder text)");
	echo mysql_error()."<br>";
	mysql_query("create table profiles(id int(4) not null auto_increment unique,fname text,enrollno text,dob text,gender text,email text,address text,contact text,img text,branch text,sem text,spi text,cpi text)");
	echo mysql_error()."<br>";
	mysql_query("create table toppers(id int(4) not null auto_increment unique,fname text,enrollno text,rank text,spi text,sem text,branch text)");
	echo mysql_error()."<br>";
	mysql_query("create table fees_details(id int(4) not null auto_increment unique,fname text,enrollno text,branch text,sem text,fees text,submitted text,ldate text)");
	echo mysql_error()."<br>";
	mysql_query("create table faculties(id int(4) not null auto_increment unique,fname text,dob text,qual text,expe text,depa text,desg text,subj text,address text,contact text,email text,img text,gender text)");
	echo mysql_error()."<br>";
	mysql_query("create table principal(id int(4) not null auto_increment unique,fname text,dob text,qual text,expe text,depa text,subj text,address text,contact text,email text,img text,during text)");
	echo mysql_error()."<br>";
	mysql_query("create table circular(id int(4) not null auto_increment unique,cdate text,cdesc text,link text)");
	echo mysql_error()."<br>";
	//mysql_query("create table ebooks(id int(4) not null auto_increment unique,bname text,author text,total_books text,book_issued text,branch text,sem text,bookid text,mrp text,link text)");
	//echo mysql_error()."<br>";
	mysql_query("create table notice_board(id int(4) not null auto_increment unique,ndate text,ndesc text,branch text,sem text,link text,adder text)");
	echo mysql_error()."<br>";
	mysql_query("create table attendance(id int(4) not null auto_increment unique,fname text,enrollno text,udate text,subjects text,percentages text,notice text,crit text)");
	echo mysql_error()."<br>";
	mysql_query("create table subscribers(id int(4) not null auto_increment unique,email text)");
	echo mysql_error()."<br>";
	mysql_query("create table downloads(id int(4) not null auto_increment unique,tdate text,dtitle text,ddesc text,links text,adder text)");
	echo mysql_error()."<br>";
        mysql_query("create table timetable(id int(4) not null auto_increment unique,branch text,sem text,titles text,links text)");
	echo mysql_error()."<br>";
	mysql_query("create table clgprofile(id int(4) not null auto_increment unique,descs text,phone text,fax text,email text,address text,welcomemsg text,img text)");
	echo mysql_error()."<br>";
		mysql_query("INSERT INTO `clgprofile` (`id`, `descs`, `phone`, `fax`, `email`, `address`, `welcomemsg`, `img`) VALUES(1, 'C. U. Shah Technical Institute Of Diploma Studies WadhwanCity is a Self Finance Polytechnic Institute managed by Wardhman Bharti Trust,\r\naffiliated to Technical Education Board (TEB) - Gandhinagar and Gujarat Technological University (GTU), for new entrant of A.Y. 2008-09.', '+91-2752-294140', '+91-2752-242712', 'idtsvbt@yahoo.co.in', 'Ahmedabad - Surendranagar State Highway, Near Kotharia Village, Wadhwan City - 363 030, (Gujarat) India.', 'Welcome to C.U.Shah Campus''s homepage... please login to your account to manage your profile details or if you are student then you can check your results and share your results to other friends via emails and also you can check your attendance, time-tables etc..', 'pics/1.jpg')");
		echo mysql_error()."<br>";
	mysql_query("create table latest_news(id int(4) not null auto_increment unique,title text,link text,adder text)");
	echo mysql_error()."<br>";
mysql_select_db("idtsvbt_db_faculty");
echo mysql_error()."<br>";
	mysql_query("create table permission(id int(4) not null auto_increment unique,username text,permission text)");
	mysql_query("create table login(id int(4) not null auto_increment unique,acc_id text,username text,password text,acc_type text,status text)");
	echo mysql_error()."<br>";
	mysql_query("create table faculty(id int(4) not null auto_increment unique,acc_id text,fname text,email text,desg text,address text,mobile text)");
	echo mysql_error()."<br>";
	mysql_query("create table student(id int(4) not null auto_increment unique,acc_id text,fname text,enrollno text,email text,branch text,sem text,mobile text)");
	echo mysql_error()."<br>";
	mysql_query("create table parents(id int(4) not null auto_increment unique,acc_id text,fname text,enrollno text,email text,branch text,sem text,qual text,occ text,address text,mobile text)");
	echo mysql_error()."<br>";
	mysql_query("create table admin(id int(4) not null auto_increment unique,username text,password text)");
	echo mysql_error()."<br>";
            mysql_query("insert into admin(username,password) values('idts','vardhman')");
            echo mysql_error();
	mysql_query("create table onlineuser(id int(4) not null auto_increment unique,loginid text,username text)");
	echo mysql_error()."<br>";
        mysql_query("create table acc_request(id int(4) not null auto_increment unique,username text,acc_type text)");
        echo mysql_error();
mysql_select_db("idtsvbt_db_faculty");
echo mysql_error()."<br>";
	mysql_query("create table result_table(id int(4) not null auto_increment unique,branch text,sem text,exam_date text,type text,result_date text,result_id text)");
	echo mysql_error()."<br>";
	mysql_query("create table result_id(id int(4) not null auto_increment unique,enrollno text,fname text,subjects text,marks text,outof text,fail text)");
	echo mysql_error()."<br>";
mysql_close($con);
/*
clgprofile
[descs-C. U. Shah Technical Institute Of Diploma Studies WadhwanCity is a Self Finance Polytechnic Institute managed by Wardhman Bharti Trust,
affiliated to Technical Education Board (TEB) - Gandhinagar and Gujarat Technological University (GTU), for new entrant of A.Y. 2008-09.]
[phone-+91-2752-294140 ]
[fax-+91-2752-242712 ]
[email-idtsvbt[at]yahoo.co.in]
[address-Ahmedabad - Surendranagar State Highway, Near Kotharia Village, Wadhwan City - 363 030, (Gujarat) India.]
[welcomemsg-Welcome to C.U.Shah Campus's homepage... please login to your account to manage your profile details or if you are student then you can check your results and share your results to other friends via emails and also you can check your attendance, time-tables etc..]
[img-pics/1.jpg]
*/
?>



