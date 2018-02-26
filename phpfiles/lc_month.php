<?PHP
import_request_variables("gp");
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");
$month_query = mysql_query("SELECT * FROM leavecalendar WHERE leave_date > '$year-$month-01' AND 
	leave_date < DATE_ADD('$year-$month-01',INTERVAL 1 MONTH) ORDER BY leave_date");
echo "
	<H3>Staff on leave during $month-$year</H3>
	<UL>
	";
$rows = mysql_num_rows($month_query);
while ($rows > 0):
	$lc_object = mysql_fetch_object($month_query);
	echo "<LI>$lc_object->leave_date - $lc_object->person<BR>
		Comments: $lc_object->comments<BR></LI>";
	--$rows;
	endwhile;
echo "</UL>";
?>
	</td>
  </tr>
</table>
<br>
<table width="780" border="0">
  <tr>
    <td>
      <div align="center"> 
        <p><img src="bottom.gif" width="640" height="56"><br>
          <font size="1" face="ARIAL,HELVETICA"><b> <a href="http://www.lhup.edu/index.html"><font color="#EBEBEB">HOME</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/admissions/index.html"><font color="#EBEBEB">ADMISSIONS</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/academic/index.html"><font color="#EBEBEB">STUDENTS</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/alumni/index.html"><font color="#EBEBEB">ALUMNI</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/sports/index.htm"><font color="#EBEBEB">SPORTS</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/events/index.htm"><font color="#EBEBEB">EVENTS</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/site_index.htm"><font color="#EBEBEB">SITE 
          INDEX</font></a><br>
          Copyright 2002 Lock Haven University of PA - Site Design by Boise P. 
          Miller - LHUP Graphics by Scott Eldredge</b></font>
      </div>
    </td>
  </tr>
</table>
</body>
</html>
