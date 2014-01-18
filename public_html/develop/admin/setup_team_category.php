<?php
#
# Copyright (C) 2002 David Whittington
# Copyright (C) 2005 Jonathan Geisler
# Copyright (C) 2005 Victor Replogle
# Copyright (C) 2005 Steve Overton
# Copyright (C) 2005 David Crim
#
# See the file "COPYING" for further information about the copyright
# and warranty status of this work.
#
# arch-tag: standings.php
#
include_once("lib/admin_config.inc");
include_once("lib/data.inc");
include_once("lib/session.inc");
include_once("lib/header.inc");

    $link = mysql_connect ($db_host , $db_user, $db_pass) or die ("Could not connect to database");
    mysql_select_db ($db_name) or die ("Could not select database");

    if(isset($_POST["submit"]))
    {
    	$sql = "DELETE FROM CATEGORY_TEAM";
		mysql_query($sql);
	
    	foreach($_POST as $box => $value) {
	    if($value == 'on') {
	    	$team = explode("|", $box);
			echo $team;
		$sql = "INSERT INTO CATEGORY_TEAM (TEAM_ID, CATEGORY_ID) VALUES ('$team[0]', '$team[1]');";
		mysql_query($sql);
	    }
	}
    }

    $sql = "SELECT * FROM CATEGORIES";
    $category = mysql_query($sql);
    $num_cat = mysql_num_rows($category);
    $cat_row = mysql_fetch_assoc($category);

    $tmp = $num_cat * 10;
    echo " <div class=\"container\">";
    echo " <div class=\"table-responsive\">";
    echo "<form method='POST' action='setup_team_category.php'>";
    echo " <table class=\"table\" align=\"left\" width=90%>";
    echo "<tr><td>";
    echo "<h3>Teams</h3>";
    echo "</td></tr>";
    echo "<tr>";
    echo "<td>Team Name</td>\n";
    for($i=1; $i<=$num_cat; $i++) { 
	echo "<td><b>".$cat_row["CATEGORY_NAME"]."</b></td>";
	$cat_row = mysql_fetch_assoc($category);
    }
    echo "</tr>\n";

    $sql = "SELECT * FROM TEAMS";
    $team = mysql_query($sql);
    $num_teams = mysql_num_rows($team);
    $team_row = mysql_fetch_assoc($team);
    
    for($i=0; $i<$num_teams; $i++) {
	if($i%2 == 0) {
	    echo "<tr>\n";
	} else {
	    echo "<tr>\n";
	}
	echo "<td>".$team_row["TEAM_NAME"]."</td>";

	for($x=1; $x<=$num_cat; $x++) {
	    $sql = "SELECT * FROM CATEGORY_TEAM WHERE TEAM_ID = ".$team_row["TEAM_ID"]." AND CATEGORY_ID=$x";
	    $query = mysql_query($sql);
	    $check = mysql_num_rows($query);
	    
	    echo "<td><input type='checkbox' ";
	    if($check==1)
	    	echo"checked=checked ";
	    echo "name='".$team_row["TEAM_ID"]."|$x'/></td>";
	}
	
	$team_row = mysql_fetch_assoc($team);
	echo "</tr>";
    }
    echo "<tr>";
    echo "<td colspan=5>";
    echo "<input type='submit' value='Make Changes' name='submit'/>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
?>
