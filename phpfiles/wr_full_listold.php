<?PHP
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
mysql_select_db("lhucc_webdb");
if (strlen($req_uname) > 0){
	$name_cond = "AND req_uname LIKE '%$req_uname%'";
	}
if (strlen($cc_staff) > 0){
	$tech_cond = "AND cc_staff LIKE '%$cc_staff%'";
	}
if (strlen($building) > 0){
	$bldg_cond = "AND building LIKE '%$building%'";
	}
if (strlen($sortfield) > 0){
	$order_by = $sortfield;
	}
else {
	$order_by = "wr_id DESC";
	}
$wr_query = mysql_query("SELECT wr_id,wr_type,req_name,title,status,cc_staff,priority,ph_num,building,room_no FROM 
	workrequests WHERE status LIKE '%'
	$name_cond $tech_cond $bldg_cond AND add_date >= DATE_SUB(CURDATE(),INTERVAL 1 YEAR) ORDER BY $order_by");
echo "
	<H2>Work Request Queue</H2>
	<P>The following work requests have been promoted to the general queue.</P>
	";
echo "
	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<P>Show requests from user:
	<INPUT TYPE=\"TEXT\" NAME=\"req_uname\" SIZE=\"8\" MAXLENGTH=\"8\">
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Find\">
	</FORM></P>
	";
echo "
	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<P>Show requests for building:
	<INPUT TYPE=\"TEXT\" NAME=\"building\" SIZE=\"4\" MAXLENGTH=\"4\">
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Find\">
	</FORM></P>
	";
echo "
	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<P>Show requests for technician:
	<INPUT TYPE=\"TEXT\" NAME=\"cc_staff\" SIZE=\"40\" MAXLENGTH=\"40\">
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Find\">
	</FORM></P>
	";
$rows = mysql_num_rows($wr_query);
echo "<TABLE BORDER=1>
	<TR>
		<TD><FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		    <INPUT TYPE=\"hidden\" NAME=\"sortfield\" VALUE=\"wr_id\">
		    <INPUT TYPE=\"submit\" VALUE=\"ID\">
		    </FORM></TD>
		<TD><FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		    <INPUT TYPE=\"hidden\" NAME=\"sortfield\" VALUE=\"wr_type\">
		    <INPUT TYPE=\"submit\" VALUE=\"WR Type\">
		    </FORM></TD>
		<TD><FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		    <INPUT TYPE=\"hidden\" NAME=\"sortfield\" VALUE=\"req_name\">
		    <INPUT TYPE=\"submit\" VALUE=\"Requestor\">
		    </FORM></TD>
		<TD><FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		    <INPUT TYPE=\"hidden\" NAME=\"sortfield\" VALUE=\"title\">
		    <INPUT TYPE=\"submit\" VALUE=\"Title\">
		    </FORM></TD>
		<TD><FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		    <INPUT TYPE=\"hidden\" NAME=\"sortfield\" VALUE=\"ph_num\">
		    <INPUT TYPE=\"submit\" VALUE=\"Phone\">
		    </FORM></TD>
		<TD><FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		    <INPUT TYPE=\"hidden\" NAME=\"sortfield\" VALUE=\"building\">
		    <INPUT TYPE=\"submit\" VALUE=\"Location\">
		    </FORM></TD>
		<TD><FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		    <INPUT TYPE=\"hidden\" NAME=\"sortfield\" VALUE=\"status\">
		    <INPUT TYPE=\"submit\" VALUE=\"Status\">
		    </FORM></TD>
		<TD><FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		    <INPUT TYPE=\"hidden\" NAME=\"sortfield\" VALUE=\"priority\">
		    <INPUT TYPE=\"submit\" VALUE=\"Pri.\">
		    </FORM></TD>
		<TD><FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		    <INPUT TYPE=\"hidden\" NAME=\"sortfield\" VALUE=\"cc_staff\">
		    <INPUT TYPE=\"submit\" VALUE=\"Staff\">
		    </FORM></TD>
	</TR>";
while ($rows > 0):
	$wr_obj = mysql_fetch_object($wr_query);
	echo "
	<TR>
		<TD><A HREF=\"wr_disp.php?wr_id=$wr_obj->wr_id\">$wr_obj->wr_id</A></TD>
		<TD>$wr_obj->wr_type</TD>
		<TD>$wr_obj->req_name</TD>
		<TD>$wr_obj->title</TD>
		<TD>$wr_obj->ph_num</TD>
		<TD>$wr_obj->building $wr_obj->room_no</TD>
		<TD>$wr_obj->status</TD>
		<TD>$wr_obj->priority</TD>
		<TD>$wr_obj->cc_staff</TD>
	</TR>";
	--$rows;
	endwhile;
echo "</TABLE>";
$tot_query = mysql_query("SELECT COUNT(wr_id) FROM workrequests");
$sub_query = mysql_query("SELECT COUNT(wr_id) FROM workrequests WHERE status = 'Submitted'");
$app_query = mysql_query("SELECT COUNT(wr_id) FROM workrequests WHERE status = 'Approved'");
$ip_query = mysql_query("SELECT COUNT(wr_id) FROM workrequests WHERE status = 'Waiting' OR status ='Started'");
$fin_query = mysql_query("SELECT COUNT(wr_id) FROM workrequests WHERE status = 'Finished' OR status ='Cancelled'
	OR status = 'Closed'");
$tot_num = mysql_result($tot_query,0);
$sub_num = mysql_result($sub_query,0);
$app_num = mysql_result($app_query,0);
$ip_num = mysql_result($ip_query,0);
$fin_num = mysql_result($fin_query,0);
echo "
	<P>To date, $tot_num requests have been entered into the system.  Of those, $fin_num have been completed,
	$ip_num are in progress, $app_num are waiting on a technician, and $sub_num are waiting for approval.</P>
	";
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
