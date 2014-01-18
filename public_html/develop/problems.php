<?
#
# Copyright (C) 2003 David Whittington
# Copyright (C) 2003 Jonathan Geisler
# Copyright (C) 2005 Steve Overton
#
# See the file "COPYING" for further information about the copyright
# and warranty status of this work.
#
# arch-tag: judge/problems.php
#
    include_once("lib/header.inc");
    include_once("lib/config.inc");
    include_once("lib/data.inc");
    include_once("lib/session.inc");

echo " <div class=\"container\">";
echo " <div class=\"table-responsive\">";
echo " <table class=\"table\" align=\"left\" width=90%>";
echo "<tr bgcolor='#CCCCCC'><td colspan=5 align=center>\n";
echo "<h3>Problems Listing</h3></td></tr>\n";


//echo "<table width=400 align=center>\n";
echo "<tr><td><h4>Problem Name</h4></td>";
echo "<td align=center><h4>HTML</h4></td>";
//echo "<td bgcolor=$hd_bg_color2 align=center>PS</td>";
echo "<td align=center><h4>PDF</h4></td></tr>";
//echo "<tr><td bgcolor=$data_bg_color1>All problems</td>";
//echo "<td bgcolor=$data_bg_color1 align=center>";
//echo "<a href='$problem_url/problems.html'>HTML</td>";
//echo "<td bgcolor=$data_bg_color1 align=center>";
//echo "<a href='$problem_url/problems.ps'>PS</td>";
//echo "<td bgcolor=$data_bg_color1 align=center>";
//echo "<a href='$problem_url/problems.pdf'>PDF</td>";
//echo "</tr>";

$problem_counter = 1;
foreach ($problems as $problem) {
    echo "<tr><td>$problem_counter - $problem[name]</td>";
//    echo "<tr><td bgcolor=$data_bg_color1>$problem[id] - $problem[name]</td>";
    echo "<td align=center>";
    echo "<a href='$problem_url/$problem[loc]/$problem[name].html'>HTML</a></td>";
  //  echo "<td bgcolor=$data_bg_color1 align=center>";
  //  echo "<a href='$problem_url/$problem[loc]/problem.ps'>PS</a></td>";
    echo "<td align=center>";
    echo "<a href='$problem_url/$problem[loc]/$problem[name].pdf'>PDF</a></td>";
    echo "</tr>";
    $problem_counter++;
}
echo "</table>\n";
echo "</div>";

    include("lib/footer.inc");
?>

