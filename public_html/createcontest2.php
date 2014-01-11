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
$dbU = "contest_skeleton";
$db_name = preg_replace("/ /", "_", $contest);
$contest_noesc = $contest;
$contest = preg_replace("/ /", "\ ", $contest);
$contest_dir = "../$contest";
echo "<p>Creating contest folder (takes a while) . . . \n";
   $cmd = "cp -pr ../develop/ ";
   $cmd .= $contest_dir;
   system($cmd, $result);
   echo $result;
echo "Finished.</p>\n";
echo "<p>Clearing folders . . . ";
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/data/*";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/judged/*";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/queue/*";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/test_compile/*";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/c_jail/home/contest/*";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/cpp_jail/home/contest/*";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "rm -rf ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/java_jail/home/contest/*";
   echo $cmd2."<br/>";
   system($cmd2, $result);
echo"Finished.</p>\n";
echo "<p>Making Directories . . . ";
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/c_jail/home/contest/";
   $cmd2 .= $contest;
   $cmd2 .= "/judged";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/c_jail/home/contest/";
   $cmd2 .= $contest;
   $cmd2 .= "/data";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/cpp_jail/home/contest/";
   $cmd2 .= $contest;
   $cmd2 .= "/judged";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/cpp_jail/home/contest/";
   $cmd2 .= $contest;
   $cmd2 .= "/data";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/java_jail/home/contest/";
   $cmd2 .= $contest;
   $cmd2 .= "/judged";
   echo $cmd2."<br/>";
   system($cmd2, $result);
   $cmd2 = "mkdir -p ";
   $cmd2 .= $contest_dir;
   $cmd2 .= "/java_jail/home/contest/";
   $cmd2 .= $contest;
   $cmd2 .= "/data";
   echo $cmd2."<br/>";
   system($cmd2, $result);
echo"Finished.</p>\n";
echo "<p>Creating Database . . . ";
   $cmd3 = "mysqladmin --password=$dbpw -u root create $db_name";
   echo $cmd3."<br/>";
   system($cmd3, $result);
   $cmd3 = "mysql --password=$dbpw -u root $db_name < dbcreate.sql";
   echo $cmd3."<br/>";
   system($cmd3, $result);
   $cmd4 = "cp -r develop/ ./";
   $cmd4 .= $contest;
   echo $cmd4."<br/>";
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
$base_dir = "";
$contest_info = mysql_query("INSERT INTO CONTEST_CONFIG (HOST, CONTEST_NAME, FREEZE_DELAY, CONTEST_END_DELAY, BASE_DIRECTORY, JUDGE_USER) VALUES ('$HOST', '$contest', '14400', '18000', '$base_dir', 'judge')");
if (!$contest_info) {
    print "Sorry.  Database request (INSERT) failed.";
    exit;
}
echo"Finished.</p>";


#-----------editing database.inc----------------------------------
echo "<p>Editing Settings . . . ";
echo "$contest_noesc/lib/database.inc";
$fhdl = fopen("$contest_noesc/lib/database.inc", "r") OR die("Error with opening file 1");
$file = fread($fhdl, filesize("$contest_noesc/lib/database.inc"));
$file = preg_replace("/YOUR.DB.HOST/", $dbhost, $file);
$file = preg_replace("/YOUR_PASSWORD_HERE/", "$dbpw", $file);
$file = preg_replace("/CONTEST_DATABASE_HERE/", "$db_name", $file);
fclose($fhdl);
$fhdl = fopen("$contest_noesc/lib/database.inc", "w") OR die("Error with opening file 2");
$chk = fwrite($fhdl, $file);
fclose($fhdl);

#-----------Copying over new database.inc to admin----------------
$cmd = "cp $contest_noesc/lib/database.inc $contest_noesc/admin/lib/database.inc";
system($cmd,$result);

#-----------Copying over new database.inc to judge----------------
$cmd = "cp $contest_noesc/lib/database.inc $contest_noesc/judge/lib/database.inc";
system($cmd,$result);

#-------------------edit cron start-------------------------------
$fhdl = fopen("../$contest_noesc/start_contest.crontab", "r") OR die("Error opening start crontab");
$file = fread($fhdl, filesize("../$contest_noesc/start_contest.crontab"));
$file = preg_replace("/CHANGE/", "$contest", $file);
$file = preg_replace("/USERNAME/", "$user", $file);
fclose($fhdl);
$fhdl = fopen("../$contest_noesc/start_contest.crontab", "w") OR die("Error opening start crontab");
$chk = fwrite($fhdl, $file);
fclose($fhdl);


#---------editing chroot_wrapper.c--------------------------------
echo "<br/> trying to open ../$contest_noesc/chroot_wrapper.c<br/>\n";
$fhdl = fopen("../$contest_noesc/chroot_wrapper.c", "r") OR die("Error with opening file 4");
$file = fread($fhdl, filesize("../$contest_noesc/chroot_wrapper.c"));
$file = preg_replace("/develop/", "$contest", $file);
#$file = preg_replace("/502/", "success", $file);
#$file = preg_replace("/need if diff/", "502", $file);
fclose($fhdl);
$fhdl = fopen("../$contest_noesc/chroot_wrapper.c", "w") OR die("Error with opening file 3");
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
$file = preg_replace("/URLHERE/", "http://touche.cse.taylor.edu/~daniel/$contest", $file);
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
