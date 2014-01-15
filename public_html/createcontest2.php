<?php
include_once("lib/session.inc");
include_once("lib/create.inc");
if($_POST['B1'] == "Submit") {
   $contest = $_POST['contest_name'];
   $dbhost = $_POST['dbhost'];
   $dbpw = $_POST['dbpassword'];
   $HOST = $_POST['contest_host'];
}
?>
<html>
<body bgcolor="<?=$page_bg_color?>" link="0000cc" alink="000066" vlink="0000cc">
<table width="90%" align="center" cellpadding="1" cellspacing="0" border="0" bgcolor="#000000">
        <tr><td>
                <table width="100%" cellpadding="5" cellspacing="0" border="0">
                        <tr bgcolor="<?=$title_bg_color?>">
                                <td>
                                <!-- Beautification hack. 2006-09-25 -sb -->

                                <font color="#ffffff">
                                <b>Creating Contest</b>  <small></small>
                                </font>
                                </td>
                                <td align="right">
                                         <font color="#ffffff">
                                         <b>ADMIN</b>
                                         </font>
                                </td>
                        </tr>
                        <tr>
                                <td bgcolor="#ffffff" colspan="2">
				<center><b>
<?php

$user = `whoami`;
$user = str_replace("\n","",$user);
$user = str_replace(" ","",$user);

$dbPass = $dbpw;
$dbU = "contest_skeleton";
$db_name = preg_replace("/ /", "_", $contest);
$contest_noesc = $contest;
$contest = preg_replace("/ /", "\ ", $contest);
$contest_dir = "../$contest";
$base_dir = "/home/$user/$contest";
echo "<p>Creating contest folder (takes a while) . . . \n";
   $cmd = "cp -pr ../develop/ ";
   $cmd .= $contest_dir;
   system($cmd, $result);
echo "Finished.</p>\n";
echo "<p>Clearing folders . . . ";
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/data/*";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/judged/*";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/queue/*";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/test_compile/*";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/c_jail/home/$user/*";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/cpp_jail/home/$user/*";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/java_jail/home/$user/*";
   system($cmd2, $result);
   echo "Result: $result \n";
echo"Finished.</p>\n";
echo "<p>Making Directories . . . ";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/cpp_jail/home";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/c_jail/home/$user";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/c_jail/home/$user/";
   $cmd2 .= $contest;
   $cmd2 .= "/judged";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/c_jail/home/$user/";
   $cmd2 .= $contest;
   $cmd2 .= "/data";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/cpp_jail/home";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/cpp_jail/home/$user";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/cpp_jail/home/$user/";
   $cmd2 .= $contest;
   $cmd2 .= "/judged";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/cpp_jail/home/$user/";
   $cmd2 .= $contest;
   $cmd2 .= "/data";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/java_jail/home/$user/";
   $cmd2 .= $contest;
   $cmd2 .= "/judged";
   system($cmd2, $result);
   echo "Result: $result \n";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/java_jail/home/$user/";
   $cmd2 .= $contest;
   $cmd2 .= "/data";
   system($cmd2, $result);
   echo "Result: $result \n";
echo"Finished.</p>\n";

echo "<p> Adding in jail files. . . ";
//cpp_jail
	$user = str_replace("\n","",$user);
	$cmd = "cp -R /home/$user/jails/cpp_jail/lib64 /home/$user/$contest/cpp_jail/lib64";
	system($cmd,$result);
	echo "Result: $result \n";
	$cmd = "cp -R /home/$user/jails/cpp_jail/usr /home/$user/$contest/cpp_jail/usr";
	system($cmd,$result);
	echo "Result: $result \n";
	$cmd = "cp -R /home/$user/jails/cpp_jail/lib /home/$user/$contest/cpp_jail/lib";
	system($cmd,$result);
	echo "Result: $result \n";
	$cmd = "cp -R /home/$user/jails/cpp_jail/bin /home/$user/$contest/cpp_jail/bin";
	system($cmd,$result);
	echo "Result: $result \n";

//c_jail	
	$cmd = "cp -R /home/$user/jails/c_jail/lib64 /home/$user/$contest/c_jail/lib64";
	system($cmd,$result);
	echo "Result: $result | dir = $contest \n";
	$cmd = "cp -R /home/$user/jails/c_jail/usr /home/$user/$contest/c_jail/usr";
	system($cmd,$result);
	echo "Result: $result \n";
	$cmd = "cp -R /home/$user/jails/c_jail/lib /home/$user/$contest/c_jail/lib";
	system($cmd,$result);
	echo "Result: $result \n";
	$cmd = "cp -R /home/$user/jails/c_jail/bin /home/$user/$contest/c_jail/bin";
	system($cmd,$result);
	echo "Result: $result \n";
	
	$test = "chmod -R 0755 /home/$user/$contest";
	system($test);
	echo "Finished</p>";
	
echo "<p>Creating Database . . . ";
   $cmd3 = "mysqladmin --password=$dbPass -u root create $db_name";
   system($cmd3, $result);
   $cmd3 = "mysql --password=$dbPass -u root $db_name < dbcreate.sql";
   system($cmd3, $result);
   $cmd4 = "cp -r develop/ ./";
   $cmd4 .= $contest;
   system($cmd4, $result);
   
$link = mysql_connect($dbhost, $dbU, $dbpw);
if (!$link) {
    print "Sorry.  Database connect failed.";
    exit;
}

$connect_good = mysql_select_db($db_name);
if (!$connect_good) {
    print "Sorry.  Database selection failed.";
    exit;
}

$contest_info = mysql_query("INSERT INTO CONTEST_CONFIG (HOST, CONTEST_NAME, FREEZE_DELAY, CONTEST_END_DELAY, BASE_DIRECTORY, JUDGE_USER) VALUES ('$HOST', '$contest', '14400', '18000', '$base_dir', 'judge')");
if (!$contest_info) {
    print "Sorry.  Database request (INSERT) failed.";
    exit;
}
echo"Finished.</p>";


#-----------editing database.inc----------------------------------
echo "<p>Editing Settings . . . ";
$fhdl = fopen("$contest_noesc/lib/database.inc", "r") OR die("Error with opening file 1");
$file = fread($fhdl, filesize("$contest_noesc/lib/database.inc"));
$file = preg_replace("/YOUR.DB.HOST/", $dbhost, $file);
$file = preg_replace("/YOUR_PASSWORD_HERE/", "$dbpw", $file);
$file = preg_replace("/CONTEST_DATABASE_HERE/", "$db_name", $file);
fclose($fhdl);
$fhdl = fopen("$contest_noesc/lib/database.inc", "w") OR die("Error with opening file 2");
$chk = fwrite($fhdl, $file);
fclose($fhdl);


#-------------------Copy new database.inc for admin-------------------------
$cmd = "cp $contest_noesc/lib/database.inc $contest_noesc/admin/lib/database.inc";
system($cmd,$result);


#-------------------Copy new database.inc for judge-------------------------
$cmd = "cp $contest_noesc/lib/database.inc $contest_noesc/judge/lib/database.inc";
system($cmd,$result);

#---------editing chroot_wrapper.c--------------------------------
$fhdl = fopen("../$contest_noesc/chroot_wrapper.c", "r") OR die("Error with opening file");
$file = fread($fhdl, filesize("../$contest_noesc/chroot_wrapper.c"));
$file = preg_replace("/develop/", "$contest", $file);
fclose($fhdl);
$fhdl = fopen("../$contest_noesc/chroot_wrapper.c", "w") OR die("Error with opening file");
$chk = fwrite($fhdl, $file);
fclose($fhdl);
$cmd5 = "gcc -o ../$contest_noesc/chroot_wrapper.exe ../$contest_noesc/chroot_wrapper.c";
system($cmd5, $result);
if($result) {
echo "Something happened<br>";
}
$cmd5 = "sudo chown root:root ../$contest_noesc/chroot_wrapper.exe";
system($cmd5, $result);
if($result) {
echo "Unable to set root permissions on chroot wrapper<br>";
}
$cmd5 = "sudo chmod +xs ../$contest_noesc/chroot_wrapper.exe";
system($cmd5, $result);
if($result) {
echo "Unable to set chroot wrapper setuid<br>";
}
$cmd5 = "sudo chmod -R go+rx $contest_noesc";
system($cmd5, $result);
if ($result) {
echo "Unable to set contest directory permissions<br />";
}
echo "Finished.</p>";


#-------------------------edit readme-----------------------------
$fhdl = fopen("readme/inst.html", "r") OR die("Error with opening file");
$file = fread($fhdl, filesize("readme/inst.html"));
$file = preg_replace("/URLHERE/", "http://touche.cse.taylor.edu/~$user/$contest", $file);
fclose($fhdl);
$fhdl = fopen("readme/inst.html", "w") OR die("Error with opening file");
$chk = fwrite($fhdl, $file);
fclose($fhdl);

#-----------------------------------------------------------------
echo "<p>To finish setting up the contest go to: <a href='http://touche.cse.taylor.edu/~$user/$contest_noesc/admin/index.php'>Administration setup</a></p>";
?>
</center></b></td></tr>
</body>
</html>
