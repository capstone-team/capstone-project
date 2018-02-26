<?PHP
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
//mysql_connect("lhuweb","hitman","pw4hitman");
//mysql_select_db("lhucc_webdb");
$mysqli = new mysqli("151.161.128.40", "hitman", "pw4hitman", "lhucc_webdb");
echo $mysqli->connect_error;

echo "
	<H3>Administrative Site</H3>
	<UL>
		This section of the Computing Center Website is restricted
		to Computing Center Staff Only.
	</UL>
	<H3>Page LHUCC Staff via Cell Phone</H3>
	<UL>
		<a href=\"sendmessage.php\">Click here</a> to send a message to a
		staff member's cell phone.
	</UL>
	";

echo "
	</UL>
	<H3>Current News and Advisories</H3>
	<UL>
	";

//$currmsg_query = mysql_query("SELECT * FROM messages ORDER BY post_date DESC");
$result = $mysqli->query("SELECT * FROM messages ORDER BY post_date DESC");
$rows = min(5,mysqli_num_rows($result));
while ($rows != 0):
	$currmsg_obj = mysqli_fetch_object($result);
	echo "
		<LI>$currmsg_obj->message_data<BR>
		Posted by: $currmsg_obj->poster_name at $currmsg_obj->post_date
		</LI>
		";
	--$rows;
	endwhile;
echo "
	</UL>
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
