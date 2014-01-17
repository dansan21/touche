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
include_once("data.inc");


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
<body>


<!-- This is the start of the top bar -->
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
            	<h3>ADMIN</h3>
        	</div>
        </div>
</div>

<!-- END -->

<!-- START OF NAVIGATION -->

<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?> 

<div class="container">
    <div class="text-center">

        <h5><?=$contest_name?> - <?=$contest_host?></h5>
    </div>

  <ul class="nav nav-tabs nav-justified">
    <!--<li><a href="#">&laquo;</a></li> -->
    <li class=<?php if (strpos($actual_link,'setup_contest.php') !== false) {
                echo "'active'";
            }
        ?>><a href="setup_contest.php">Details</a></li>
    <li class=<?php if (strpos($actual_link,'setup_problems.php') !== false) {
                echo "'active'";
            }
        ?>><a href="setup_problems.php">Problems</a></li>
    <li class=<?php if (strpos($actual_link,'setup_data_sets.php') !== false) {
                echo "'active'";
            }
        ?>><a href="setup_data_sets.php">Data</a></li>
    <li class=<?php if (strpos($actual_link,'setup_site.php') !== false) {
                echo "'active'";
            }
        ?>><a href="setup_site.php">Sites</a></li>
    <li class=<?php if (strpos($actual_link,'setup_teams.php') !== false) {
                echo "'active'";
            }
        ?>><a href="setup_teams.php">Teams</a></li>
    <li class=<?php if (strpos($actual_link,'setup_categories.php') !== false) {
                echo "'active'";
            }
        ?>><a href="setup_categories.php">Categories</a></li>
    <li class=<?php if (strpos($actual_link,'setup_team_category') !== false) {
                echo "'active'";
            }
        ?>><a href="setup_team_category.php">TCats</a></li>
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
	<li class=<?php if (strpos($actual_link,'setup_headers.php') !== false) {
                echo "'active'";
            }
        ?>><a href="setup_headers.php">Headers</a></li>
	<?}
		if ($contest_stuff['bad_words'] > 0) { ?>
    <li class=<?php if (strpos($actual_link,'setup_forbidden.php') !== false) {
                echo "'active'";
            }
        ?>><a href="setup_forbidden.php">Forbidden</a></li>
    <?} ?>
    <li class=<?php if (strpos($actual_link,'misc.php') !== false) {
                echo "'active'";
            }
        ?>><a href="misc.php">Misc</a></li>

         <li class=<?php if (strpos($actual_link,'start.php') !== false) {
                echo "'active'";
            }
        ?>><a href="start.php">Start</a></li>

    <!--<li><a href="#">&raquo;</a></li> -->
  </ul>

<!-- END OF NAVIGATION -->

<div class="panel panel-default">
        <div class="panel-body">
            <table class="table" align='center'>
                <tr>
                <?
                        $freeze_diff = $contest_freeze_ts + $site_start_offset - time();
                        $time_till_freeze_starts = gmdate('H:i:s', $freeze_diff);
                        $time_till_contest_end = gmdate("H:i:s", $contest_end_ts - time());
                        $end_diff = $contest_end_ts + $site_start_offset - time();

                    if ($freeze_diff > 0) {
                                            print "<td align='right'><div class=\"tablehelp\"><h4>Freeze begins in:</h4></div></td> ";
                                            print "<td align='left'><h3>$time_till_freeze_starts</h3></td>";
                                    }
                    else {
                        print"<td align='center' colspan=2><div class='tablehelp'><h4>Standings Are Now Frozen</h4></div></td>";
                    }
                ?>
                    
                </tr>
                <tr>
                        <?php
                        if ($end_diff > 0) {

                            print "<td align='right'><div class=\"tablehelp\"><h4>Contest Ends in:</h4></div></td>";
                            print "<td align='left'><h3>$time_till_contest_end</h3></td>";
                        }

                        else {
                            print "<td align='right' colspan=2><div class='tablehelp'><h4>Contest is Over</h4></div></td>";

                        }

                        ?>
                </tr>

            </table>
        </div>
</div>




</div>

				<?if (!$contest_name)
				{?>
  				<b>No contest exists yet<!-- <?=$contest_name?></b> - <small><?=$contest_host?></small> -->
				<?}
				else { ?>
  				
				<?}?>
<div class='container'>
<div class='innerglow'>
 					 

				

