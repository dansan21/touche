<?
//change lines 8 and 20
include("lib/admin_config.inc");
	include("lib/data.inc");
	include("lib/session.inc");
$user = `whoami`;

#~~~~~~~setup_contest.php automation~~~~~~~~~~~~~~~
$sql = "INSERT INTO CONTEST_CONFIG (HOST, CONTEST_NAME, NUM_PROBLEMS, CONTEST_DATE, START_TIME, FREEZE_DELAY, CONTEST_END_DELAY, BASE_DIRECTORY, IGNORE_STDERR, JUDGE_USER, JUDGE_PASS, TEAM_SHOW, START_TS, HAS_STARTED) VALUES ( 'george', 'georgeofficial30', '1', '0000-00-00', '', '', '', '/home/".$user."/georgeofficial30', '', 'judge', 'judge', '', '', '')";
//$success = mysql_query($sql);
echo "Contest_setup.php automated with response code: " . $success . "<br/>";

#~~~~~~~setup_problems.php automation ~~~~~~~~~~~~~
$problem_dir =  __FILE__;
$problem_dir = str_replace("admin/test.php", "", $problem_dir) . "problems/";
if(!file_exists($problem_dir . "Test"))
		{
			mkdir($problem_dir . "Test");
			echo $problem_dir . "<br/>";
			$cmd = "cp -r /home/".str_replace("\n","",$user)."/docs/* /home/".str_replace("\n","",$user)."/public_html/georgeofficial30/problems/Test/";
			echo $cmd . "<br/>";
			system($cmd,$result);
		}
$sql = "INSERT into PROBLEMS (PROBLEM_NAME, PROBLEM_LOC, PROBLEM_NOTE) values('Test', 'Test', 'Test')";
$success = mysql_query($sql);
echo "setup_problems.php automated with response code: " . $success . "<br/>";

#~~~~~~~~~setup_data_sets.php automation ~~~~~~~~~~~
echo $base_dir . "<br/>";
$data_dir = str_replace(' ', '',$base_dir . "/data/");
echo $data_dir . "<br/>";
$cmd = "cp -r /home/".str_replace("\n","",$user)."/docs/*.in ".$data_dir;
system($cmd,$result);
$cmd = "cp -r /home/".str_replace("\n","",$user)."/docs/*.out ".$data_dir;
system($cmd,$result);
echo "setup+data_sets.php automated with response code: " . $result . "<br/>";

#~~~~~~~~setup_site.php automation ~~~~~~~~~~~~~~~
$sql = "INSERT into SITE (SITE_NAME, START_TIME) values('Test',':')";
$result = mysql_query($sql);
echo "setup_site.php automated with response code: " . $result . "<br/>";

#~~~~~~~setup_teams.php automation ~~~~~~~~~~~~~~~
$sql = "insert into TEAMS (TEAM_NAME, ORGANIZATION, USERNAME, PASSWORD, SITE_ID, COACH_NAME, CONTESTANT_1_NAME, CONTESTANT_2_NAME, CONTESTANT_3_NAME, ALTERNATE_NAME, EMAIL) values('a', 'a', 'a', 'a', '1', 'a', 'a', 'a', 'a', 'a', 'a')";
$result = mysql_query($sql);
echo "setup_teams.php automated with response code: " . $result . "<br/>";

#~~~~~~~setup_categories.php automation ~~~~~~~~~~~~~~~
$sql = "insert into CATEGORIES (CATEGORY_NAME) values('Pro')";
$result = mysql_query($sql);
echo "setup_categories.php automated with response code: " . $result . "<br/>";

#~~~~~~~setup_team_categories.php automation ~~~~~~~~~~~~~~~
$sql = "INSERT INTO CATEGORY_TEAM (TEAM_ID, CATEGORY_ID) VALUES ('1', '1');";
$result = mysql_query($sql);
echo "setup_team_categories.php automated with response code: " . $result . "<br/>";

?>