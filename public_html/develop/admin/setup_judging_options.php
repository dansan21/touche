<?php
#
# Copyright (C) 2003 David Crim
# Copyright (C) 2003 David Whittington
# Copyright (C) 2005 Victor Replogle
# Copyright (C) 2005 Jonathan Geisler
#
# See the file "COPYING" for further information about the copyright
# and warranty status of this work.
#
# arch-tag: admin/setup_forbidden.php
#
include_once("lib/admin_config.inc");
include_once("lib/data.inc");
include_once("lib/session.inc");
include_once("lib/header.inc");
if ($_GET)
{
	$sql = "select * from RESPONSES";
	$result = mysql_query($sql);
	if(!$result)
	{
		$error_msg = "Error: " . mysql_error();
		$error_msg .= "<br>SQL: $sql";
	}
	else
	{
		$responses = "";
		while($row = mysql_fetch_assoc($result))
		{
			$responses .= $row['RESPONSE'] . ":";
		}
	}
}
else if($_POST)
{
	if($_POST['submit'])
	{
		//parse the headers string
		$build_responses = split("\n", $_POST['edit_responses']);
		unset($error_msg);
		//clear out the DB
		$sql = "delete from RESPONSE";
		$result = mysql_query($sql);
		if(!$result)
		{
			$error_msg .= "Error: " . mysql_error();
			$error_msg .= "<br>SQL: $sql";
		}
		foreach($build_responses as $response)
		{
			//clean out blank lines composed of only whitespace
			$response = trim($response);
			if(strlen($response) > 0)
			{
				$sql = "insert into RESPONSES";
				$sql .= "', '$response')";
				$result = mysql_query($sql);
				if(!$result)
				{
					$error_msg .= "Error: " . mysql_error();
					$error_msg .= "<br>SQL: $sql";
				}
			}
		}
		if(!isset($error_msg))
		{
			$error_msg .= "Forbidden Word changed successfully";
		}
	}
}
/*******************************************************
End of POST section
*******************************************************/
/*//build some http strings we'll need later
$cur_headers = "";
//get all the current categories
$sql = "select * from LANGUAGE";
$result = mysql_query($sql);
if(mysql_num_rows($result) > 0) {
	$cur_headers = "<font size=+1>&nbsp</font><br>";
	$cur_headers .= "<br><table>";
	$cur_headers .= "<tr><td><font size=+1><b>Edit Current Forbidden Words</b></font></td></tr>";
	while($row = mysql_fetch_assoc($result)){
		$cur_headers .= "<tr><td>" . $row['LANGUAGE_NAME']; 
		$cur_headers .= " </td><td><font size=-1>";
		$cur_headers .= "<a href=setup_forbidden.php?lang_id=" . $row['LANGUAGE_ID'] . ">Edit</a>";
		$cur_headers .= "</font>";
		$cur_headers .= "</td></tr>";
	}
	$cur_headers .= "</table>";
}
else
{
	$cur_headers = "No current languages";
} */

//must be a http GET
	echo " <table align=center bgcoloer=#ffffff cellpadding=0 cellspacing=0 border=0 width=100%>";
	echo " <tr><td width=30% valign='top'>";
	//echo $cur_headers;
	echo " </td>";
	echo " <td width=50%>";
	echo " <form action=setup_judging_options.php method=post>";
	echo "	<table width=100% cellpadding=5 cellspacing=1 border=0> ";
	if($error_msg)
	{
		echo "<tr><td><b>$error_msg</b></td></tr>";
	}
	else
	{
		echo "<tr><td><b>&nbsp</b></td></tr>";
	}
	echo "	  <tr bgcolor='$hd_bg_color1'> ";
	echo "		<td align='center' colspan=2>";
	echo "			<font color='$hd_txt_color1'>";
	echo "				<b>Edit Options for Judges</b></font>";
	echo "		</td>";
	echo "	  </tr>";
	echo "	  <tr bgcolor=$hd_bg_color2>";
	echo "		<td align='center' colspan=2><font color='$hd_txt_color2'>";
	echo "		<b>$action</b></font></td>";
	echo "	  </tr> ";
	//in this case, we don't add new things, so we need to check to see if we
	//are editing something
	$sub_headers = split(":", $edit_responses);
	echo "	  <tr bgcolor=\"$data_bg_color1\">";
	echo "		<td valign=top>Responses </td>";
	echo " <td>";
	foreach($sub_headers as $response)
	{
		echo "<tr>$response\n</tr>";
	}
	echo "</td>";
	echo "	  </tr> ";
	echo "	<tr><td><input name=submit type=submit value='Submit'></td></tr>";
	echo "</form>";
	echo "</td></tr>";
	echo "</table>";
	echo "	</td><td width=20%></td></tr>";
	echo "</table>";
	include("lib/footer.inc");
?>
