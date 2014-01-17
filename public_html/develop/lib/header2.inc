<?
#
# Copyright (C) 2002, 2003 David Whittington
# Copyright (C) 2003 Jonathan Geisler
# Copyright (C) 2005 Victor Replogle
# Copyright (C) 2005 Steve Overton
#
# See the file "COPYING" for further information about the copyright
# and warranty status of this work.
#
# arch-tag: lib/header.inc
#
    include_once ("lib/session.inc");
    include_once ("lib/config.inc");
    include_once ("lib/data.inc");

?>

<!DOCTYPE HTML PUBLIC "-//W3C/DTD HTML 4.0 Transitional//EN">
<html>
<body bgcolor="<?=$page_bg_color?>" link="0000cc" alink="000066" vlink="0000cc">
<table width="90%" align="center" cellpadding="1" cellspacing="0" border="0" bgcolor="#000000">
	<tr><td>
		<table width="100%" cellpadding="5" cellspacing="0" border="0">
			<tr bgcolor="<?=$title_bg_color?>">	
				<td>
                <!-- Beautification hack. 2006-09-25 -sb -->
                <img src="images/favicon.ico">

  				<font color="#ffffff">
  				<b><?=$contest_name?></b> - <small><?=$contest_host?></small>
  				</font>
				</td>
				<td align="right">
 					 <font color="#ffffff">
 					 <b><?=$team_name?></b>
 					 </font>
				</td>
			</tr>
			</tr>
			<tr>
				<td bgcolor="#ffffff" colspan="2">
