<?PHP
include("FCKeditor/fckeditor.php");
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
mysql_select_db("lhucc_webdb");

if ($action == "Delete") {
	mysql_query("DELETE FROM faqs WHERE faq_id = $faq_id");
	echo "FAQ #$faq_id has been deleted";
	}
else if ($action == "Update") {
	$faq_query = mysql_query("SELECT * FROM faqs WHERE faq_id = $faq_id");
	$faq_obj = mysql_fetch_object($faq_query);
	echo "
		<H2>FAQ Update</H2>
		<P>Question and answer can be any length.  HTML formatting can be
		used to add hyperlinks, images or pretty much anything else you
		can put on a webpage.  Please remember to close any HTML tags as
		these will affect the rest of the page.</P>
		<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		<B>Question:</B><BR>
		<TEXTAREA NAME=\"question\" COLS=\"50\" ROWS=\"2\">";
		echo stripslashes($faq_obj->question);
	echo "</TEXTAREA><BR><BR>
		<B>Answer:</B><BR>
		<!---<TEXTAREA NAME=\"answer\" COLS=\"50\" ROWS=\"6\">-->";
	        $aFCKeditor = new FCKeditor('answer') ;
        	$aFCKeditor->BasePath = 'FCKeditor/';
        	$aFCKeditor->Value = stripslashes($faq_obj->answer);
        	$aFCKeditor->Create() ;
		#echo "$faq_obj->answer";
	echo "<!---</TEXTAREA>--><BR><BR>
		<INPUT TYPE=\"HIDDEN\" VALUE=\"$faq_id\" NAME=\"faq_id\">
		<INPUT TYPE=\"SUBMIT\" VALUE=\"Apply Changes\" NAME=\"action\">
		<INPUT TYPE=\"SUBMIT\" VALUE=\"Preview\" NAME=\"action\">
		</FORM>
		";
	}
if ((strlen($question) > 0) || (strlen($answer) > 0)) {
	if ((strlen($question) > 0) && (strlen($answer) > 0) && ($action == "Apply Changes")) {
		mysql_query("UPDATE faqs SET question = '$question', answer = '$answer'
				WHERE faq_id = $faq_id");
		echo "
			<P>Updated Question: " . stripslashes($question) . "<BR>
			with Answer:<BR> " . stripslashes($answer) . "</P>
			";
		}
	else if ((strlen($question) > 0) && (strlen($answer) > 0) && ($action == "Preview")) {
		echo "
			<P><B>Preview:</B></P>
			<P>Question: " . stripslashes($question) . "<BR>
			Answer:<BR> " . stripslashes($answer) . "</P>
			";
		}
	else {
		echo "<BR><BR><B>Error: You must specify both a question
			and an answer</B>";
		}
	}
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
