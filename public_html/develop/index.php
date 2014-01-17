<?
#
# Copyright (C) 2002 David Whittington
# Copyright (C) 2005 Steve Overton
#
# See the file "COPYING" for further information about the copyright
# and warranty status of this work.
#
# arch-tag: index.php
#
    include_once("lib/config.inc");
    include_once("lib/data.inc");

session_name("TOUCHE-$db_name");
session_start();
$_SESSION = array();

if($_SERVER['REQUEST_METHOD'] == 'GET') {

?>
<!DOCTYPE HTML PUBLIC "-//W3C/DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link rel="shortcut icon" href="images/favicon.ico" />
<script language="javascript">
    function set_focus() {
	if (document.f.user.value) {
	    document.f.password.focus();
	} else {
	document.f.user.focus();
	}
    }
    function check_input() {
    	if(document.f.user.value.length == 0 || document.f.password.value.length == 0)
	{
		alert("Please fill out all fields.");
		return false;
	}
	return true;
    }
</script>

<style>
<?php include_once("styles/css/bootstrap.css"); ?>
</style>

</head>
<body onLoad="set_focus()">

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
            <form class="form-inline" name="f" method="post" action="index.php">
                <div class="form-group">
                    <input type="text" class="form-control" name="user" size="30" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" size="30" placeholder="Password">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-default" name="submit" onclick="return check_input()">Sign in</button>
                </div>
                <?
                    if (isset($state) && $state == 1) {
                	echo "<center><b>";
                	echo "Login or Password Invalid</b></center>\n";
                    }
                    else if (isset($state) && $state == 2) {
                	echo "<center><b>";
                	echo "You are not yet logged in</b></center>\n";
                    }
                ?>
                </form>


		</div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <h3>Team Login page for: <?=$contest_name?></h3>
        </div>
        <div class="row">
            <h4><?=$contest_host?></h4>
        </div>  
    </div>

		<?php
		    if(isset($state) && $state == 1) {
			echo "<center><font color=#cc0000><b>";
			echo "Login or Password Invalid</b></font></center>\n";
		    } else if(isset($state) && $state == 2) {
			echo "<center><font color=#cc0000><b>";
			echo "You are not yet logged in</b></font></center>\n";
		    }

		?>



</body>
</html>
<?
}
else if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user = $_POST['user'];
    $password = $_POST['password'];
   
    if($password == $users[$user]['password']) {
	$_SESSION['contestant_user'] = $user;
	$_SESSION['contestant_pass'] = $password;
	$_SESSION['team_id'] = $users[$user]['team_id'];
	$_SESSION['team_name'] = $users[$user]['team_name'];
	header ("Location: main.php");
    }
    else {
	header ("Location: index.php?state=1");
    }
}

?>
