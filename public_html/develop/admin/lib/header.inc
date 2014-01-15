<?
#
# Copyright (C) 2002 David Whittington
# Copyright (C) 2003, 2004 Jonathan Geisler
#
# See the file "COPYING" for further information about the copyright
# and warranty status of this work.
#
# arch-tag: admin/lib/header.inc
#

include_once("admin_config.inc");
include_once ("session.inc");

$link = mysql_connect($db_host, $db_user, $db_pass);
if (!$link) {
    print "Sorry.  Database connect failed.  Retrying...";
    exit;
}

$connect_good = mysql_select_db($db_name);
if (!$connect_good) {
    print "Sorry.  Database selection failed.  Retrying...";
    exit;
}
	include_once ("../lib/config.inc");
#	include_once ("../lib/data.inc");
	include_once ("lib/session.inc");
	$result = mysql_query("SELECT * FROM CONTEST_CONFIG");
	if (mysql_num_rows($result) > 0) {
		include_once ("lib/contest_info.inc");
	}
?>

<!DOCTYPE html>
<html>
<head>
<style>
	<?php include_once("../styles/css/bootstrap.css"); ?>
</style>
</head>
<body bgcolor="<?=$page_bg_color?>" link="0000cc" alink="000066" vlink="0000cc">

<div class="page-header">
        <div class="container">
        <div class="img-responsive2">
            <?php 
            $path =  "http://$_SERVER[HTTP_HOST]/images/ToucheLogo.png";
            header("Content-Type: image/png");
            echo "<img src='$path' alt='Logo'>";
            ?>
        </div>
         	<div class="text-right">
            	<h3>JUDGE/ADMIN</h3>
        	</div>
        </div>
</div>
		<div class="container">
          <ul class="nav nav-tabs nav-justified">
            <!--<li><a href="#">&laquo;</a></li> -->
            <li><a href="setup_contest.php">Details</a></li>
            <li><a href="setup_problems.php">Problems</a></li>
            <li><a href="setup_data_sets.php">Data</a></li>
            <li><a href="setup_site.php">Sites</a></li>
            <li><a href="setup_teams.php">Teams</a></li>
            <li><a href="setup_categories.php">Categories</a></li>
            <li><a href="setup_team_category.php">TCats</a></li>
            <?$lang_sql = "SELECT 	sum(REPLACE_HEADERS) AS heads,";
				$lang_sql  .= "		sum(CHECK_BAD_WORDS) AS bad_words ";
				$lang_sql  .= "FROM LANGUAGE";
				$sel_sql = mysql_query($lang_sql);
				if (!$sel_sql) {
					echo "Error!  Could not create the header ";
					echo "correctly.<br /> Please contact an ";
					echo "administrator.";
				}
				$contest_stuff = mysql_fetch_assoc($sel_sql);
				if ($contest_stuff['heads'] > 0) { ?>
			<li><a href="setup_headers.php">Headers</a></li>
			<?}
				if ($contest_stuff['bad_words'] > 0) { ?>
            <li><a href="setup_forbidden.php">Forbidden</a></li>
            <?} ?>
            <li><a href="misc.php">Misc</a></li>
			<li><a href="start.php">Start Contest</a></li>

            <!--<li><a href="#">&raquo;</a></li> -->
          </ul>
      	</div>
      	<div class="container">

        <div class="text-center">
				<h2>Official Time: <?=date("H:i:s")?></h2>
        <h5><?=$contest_name?> - <?=$contest_host?></h5>
		    </div>
        </div>

				<?if (!$contest_name)
				{?>
  				<b>No contest exists yet<!-- <?=$contest_name?></b> - <small><?=$contest_host?></small> -->
				<?}
				else { ?>
  				
				<?}?>
 					 

				

