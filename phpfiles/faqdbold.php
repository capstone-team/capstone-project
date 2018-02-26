<?PHP
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
mysql_select_db("lhucc_webdb");
echo "
	<H2>Frequently Asked Questions Database</H2>
	<P>Please type your search string below. All terms are included in the search.</P>
	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<INPUT TYPE=\"TEXT\" NAME=\"searchstring\" SIZE=\"60\"><BR>
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Search\">
	</FORM>
	<BR><A HREF=\"$PHP_SELF?searchstring=%\">See all FAQ's</A>
	";
if (strlen($searchstring) > 0) {
	$keywords = preg_split ("/[\s,]+/", "$searchstring");
	$query_string = "SELECT faq_id,question,answer FROM faqs WHERE";
	$first = 1;
	foreach ($keywords as $keyword) {
		if ($first == 0) {
			$query_string .= " AND";
			}
		$first = 0;
		$query_string .= " (question LIKE '%$keyword%' OR answer LIKE '%$keyword%')";
		}
	//echo $query_string;
	$faq_query = mysql_query($query_string);
	$rows = mysql_num_rows($faq_query);
	echo "
		<HR>
		You searched for: <B>$searchstring</B>, which matched $rows questions.<BR><BR>
		";
	while ($rows > 0):
		$faq_obj = mysql_fetch_object($faq_query);
		echo "
			<P><form action=faq_update.php method=post>
			<input type=hidden name=faq_id value=\"$faq_obj->faq_id\">
			<input type=submit name=action value=Delete>
			<input type=submit name=action value=Update>
			$faq_obj->question</form></P>
			";
		--$rows;
		endwhile;
	}
echo "
	<P><A HREF=\"faq_add.php\">Add New FAQ</A></P>
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
