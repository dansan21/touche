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
# arch-tag: admin/setup_problems.php
#
include_once("lib/admin_config.inc");
include_once("lib/data.inc");
include_once("lib/contest_info.inc");
include_once("lib/session.inc");
include_once("lib/header.inc");

$problem_dir =  __FILE__;
$problem_dir = str_replace("admin/setup_problems.php", "", $problem_dir) . "problems/";
//echo $problem_dir."<br/>";

if ($_GET)
{
	if(isset($_GET['problem_id']))
	{
		$problem_id = $_GET['problem_id'];
		if(!isset($_SESSION['edit_problem']))
		{
			$_SESSION['edit_problem'] = $problem_id;
		}
				
		if($problem_id != -1)
		{
			$sql = "select * from PROBLEMS WHERE PROBLEM_ID = '$problem_id'";
			$result = mysql_query($sql);
			if(!$result)
			{
				$error_msg = "Error: " . mysql_error();
				$error_msg .= "<br>SQL: $sql";
			}
			else
			{
				if(mysql_num_rows($result)==0)
				{
					$error_msg = "<br>No rows returned: SQL: $sql";
				}
				else
				{			
					$row = mysql_fetch_assoc($result);
					$edit_problem_name = $row['PROBLEM_NAME'];
					$edit_problem_short_name = $row['PROBLEM_SHORT_NAME'];
					$edit_problem_id = $row['PROBLEM_ID'];
					$edit_problem_loc = $row['PROBLEM_LOC'];
					$edit_problem_note = $row['PROBLEM_NOTE'];
				}
			}
		}
		$action = "Editing problem: $edit_problem_name";
	}
	else if(isset($_GET['remove_id']))
	{
		unset($_SESSION['edit_problem']);
		$remove_id = $_GET['remove_id'];
		//delete the problem 
		$sql="delete from PROBLEMS where PROBLEM_ID = $remove_id";
		$result = mysql_query($sql);
		if(!$result)
		{
			$error_msg = "Error: " . mysql_error();
			$error_msg .= "<br>SQL: $sql";
		}
		else
		{
			$error_msg = "Problem deleted successfully";
		}
	}
	else
	{
		unset($_SESSION['edit_problem']);
		
	}
}
else if($_POST)
{
	if($_POST['submit'])
	{
		//Error Checking
		//Echo "<pre>"; 
		//print_R($_FILES);
		if(!file_exists($problem_dir . $_POST['problem_loc']))
		{
			mkdir($problem_dir . $_POST['problem_loc']);
		}
		if(strlen($_POST['problem_name']) == 0)
		{
			$error_msg .= "You forget to set the problem name<br>\n";
		}
		if(strlen($_POST['problem_short_name']) == 0)
		{
			$error_msg .= "You forget to set the shortened problem name<br>\n";
		}
		else if(strlen($_POST['problem_loc']) == 0)
		{
			$error_msg .= "You forget to set the problem location<br>\n";
		}
		//---------------------------------------------------------------------------
		else if(preg_match("/ /", $_POST['problem_loc']))
		{
			$error_msg .= "There are no spaces allowed in problem name!<br>\n";
		}
		//---------------------------------------------------------------------------
		else if(!file_exists($problem_dir . $_POST['problem_loc']))
		{
			$error_msg .= "The location:" . $problem_dir . $_POST['problem_loc'];
			$error_msg .= " does not exist.";
		}
		//echo $_FILES['html_file']['tmp_name'] . "<br/>";
		//print "File lengths:" . strlen($_FILES['html_file']['tmp_name']) . strlen($_FILES['pdf_file']['tmp_name']);
		//process new file uploads if they exist
		if(($_POST['upload_html_id']) && strlen($_FILES['html_file']['tmp_name']) > 0)
		{
			$result = move_uploaded_file($_FILES['html_file']['tmp_name'], 
					$problem_dir . $_POST['problem_loc'] . "/" .  $_POST['problem_name'] . ".html");
			if(!$result)
			{
				$error_msg .= "Failed to upload html file";
			}
		}
		if(($_POST['upload_pdf_id']) && strlen($_FILES['pdf_file']['tmp_name']) > 0)
		{
			$result = move_uploaded_file($_FILES['pdf_file']['tmp_name'], 
					$problem_dir . $_POST['problem_loc'] . "/" .  $_POST['problem_name'] . ".pdf");
			if(!$result)
			{
				$error_msg .= "Failed to upload pdf file";
			}
		}
		else{			
			if(isset($_SESSION['edit_problem']))
			{
				$sql = "update PROBLEMS set PROBLEM_NAME = '" . $_POST['problem_name'] . "', ";
				$sql .= "PROBLEM_SHORT_NAME = '" . $_POST['problem_short_name'] . "',  ";
				$sql .= "PROBLEM_LOC = '" . $_POST['problem_loc'] . "',  ";
				$sql .= "PROBLEM_NOTE = '" . $_POST['problem_note'] . " ";
				$sql .= "' where PROBLEM_ID = " . $_SESSION['edit_problem'];
				$result = mysql_query($sql);
				if(!$result)
				{
					$error_msg = "Error: " . mysql_error();
					$error_msg .= "<br>SQL: $sql";
				}
				else
				{
					unset($_SESSION['edit_problem']);
					$error_msg = "Problem changed successfully";
				}
			}
			//--------------------------------------------------------------------------------------------------------
			else if($error_msg) {
				$error_msg .= "<h3>No Problem Created</h3>";
			}
			//--------------------------------------------------------------------------------------------------------
			else
			{		
				//adding a new problem
				$sql = "INSERT into PROBLEMS (PROBLEM_NAME, PROBLEM_SHORT_NAME, PROBLEM_LOC, PROBLEM_NOTE) ";
				$sql .= "values('" . $_POST['problem_name'] . "', '";
				$sql .= $_POST['problem_short_name'] . "', '";
				$sql .= $_POST['problem_loc'] . "', '";
				$sql .= $_POST['problem_note'] . "')";
				
				$result = mysql_query($sql);
				if($result)
				{
					$error_msg .= "Successful: New problem created";
				}
				else{
					$error_msg .= "Error:" . mysql_error();
					$error_msg .= "<br>SQL: $sql";
				}
			}
		}
	}
}
else
{
	if($_SERVER['REQUEST_METHOD'])
	{
		unset($_SESSION['edit_problem']);
	}
}
/*******************************************************
End of POST section
*******************************************************/




//build some http strings we'll need later

echo " <div class=\"container\">";
if(!$action)
{
	$action = "<h4>Add a new problem</h4>";
}
$cur_problems = "";
//get all the current categories
$sql = "select * from PROBLEMS ORDER by 'PROBLEM_ID'";
$result = mysql_query($sql);
if(mysql_num_rows($result) > 0) {
	//$cur_problems = "<font size=+1><a href=setup_problems.php>Add New Problem</a></font><br>";
	$cur_problems .= "<br><table class=\"table\">";
	$cur_problems .= "<tr><td><font size=+1><h3>Edit Current Problems</h3></font></td></tr>";

	while($row = mysql_fetch_assoc($result)){
		$cur_problems .= "<tr><td>" . $row['PROBLEM_NAME']; 
		$cur_problems .= " </td><td><font size=-1>";
		$cur_problems .= "<a href=setup_problems.php?problem_id=" . $row['PROBLEM_ID'] . ">Edit</a>";
		$cur_problems .= "</font></td><td><font size=-1>";
		$cur_problems .= "<a href=setup_problems.php?remove_id=" . $row['PROBLEM_ID'] . ">Delete</a>";
		$cur_problems .= "</font><br>\n";
		$cur_problems .= "</td></tr>";
	}
	$cur_problems .= "</table>";
}
else
{
	$cur_problems = "<tr>No current problems</tr>";
}

$http_html.="	  <tr bgcolor=\"$data_bg_color1\">";
$http_html.="		<td>Problem html: </td>";
if(file_exists("../problems/" . $edit_problem_loc . "/" . $edit_problem_name . ".html"))
{
	$prev_html_name = "<font color='green'>$edit_problem_name.html</font><br>";
}
else
{
	$prev_html_name = "<font color='red'>No file uploaded yet</font><br>";
}
$http_html.="		<td>";
$http_html.="		<input type=hidden name=upload_html_id value=$edit_problem_id>";
$http_html.= $prev_html_name;
$http_html.="		<input type=file name=html_file></input></td>";
$http_html.="	  </tr> ";


$http_pdf.="	  <tr bgcolor=\"$data_bg_color1\">";
$http_pdf.="		<td>Problem pdf: </td>";
if(file_exists("../problems/" . $edit_problem_loc . "/" . $edit_problem_name . ".pdf"))
{
	$prev_pdf_name = "<font color='green'>$edit_problem_name.pdf</font><br>";
}
else
{
	$prev_pdf_name = "<font color='red'>No file uploaded yet</font><br>";
}
$http_pdf.="		<td>";
$http_pdf.="		<input type=hidden name=upload_pdf_id value=$edit_problem_id>";
$http_pdf.= $prev_pdf_name;
$http_pdf.="		<input type=file name=pdf_file></input></td>";
$http_pdf.="	  </tr> ";


#--------------------------------------------------~~~~~~
//must be a http GET
	
	echo " <div class=\"container\">";
	echo " <div class=\"table-responsive\">";
	echo " <table class=\"table\">";
	echo " <tr>";
	echo $cur_problems;
	echo " </tr>";

	echo " <td>";
	echo " <form enctype='multipart/form-data' action=setup_problems.php method=post>";
	echo "	<table class=\"table\"> ";

	echo "	  <tr> ";
	echo "		<td colspan=2>";
	echo "				<h3>Add or Edit Problems</h3>";
	echo "		</td>";
	echo "	  </tr>";

	if($error_msg)
	{
		echo "<tr><td><b>$error_msg</b></td></tr>";
	}
	else
	{
		echo "<tr><td><b>&nbsp</b></td></tr>";
	}

	echo "	  <tr> ";
	echo "		<td colspan=2>";
	echo "		<b>$action</b></td>";
	echo "	  </tr> ";

		echo "	  <tr> ";
	echo "		<td>Problem name: </td>";
	echo "		<td><input type='text' name='problem_name' ";
	echo "			value = '$edit_problem_name'></td>";
	echo "	  </tr> ";
	echo "	  <tr> ";
	echo "		<td>Problem name shortened: </td>";
	echo "		<td><input type='text' name='problem_short_name' ";
	echo "			value = '$edit_problem_short_name'></td>";
	echo "	  </tr> ";
	echo "	  <tr> ";
	echo "		<td>Problem location: </td>";
	echo "		<td><input type='text' name='problem_loc' ";
	echo "			value = '$edit_problem_loc'></td>";
	echo "	  </tr> ";
	echo "	  <tr> ";
	echo "		<td>Problem notes: </td>";
	echo "		<td><textarea rows=5 name='problem_note'>$edit_problem_note</textarea></td>";
	echo "	  </tr> ";
	if($_SESSION['edit_problem'])
	{
		echo $http_html;
		echo $http_pdf;
	}
	echo "	<tr><td><input name=submit type=submit value='Submit'></td></tr>";
	echo "</form>";
	echo "</table>";
	echo "</table>";
	echo "</div>";
	echo "</div>";
	include("lib/footer.inc");
?>
