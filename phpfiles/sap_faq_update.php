<HTML>
<HEAD>
<TITLE>SAP FAQ Addition</TITLE>
</HEAD>
<BODY BGCOLOR="E1E1E1">
<?PHP
foreach($_GET as $k => $v) $_GET[$k] = addslashes($v);
foreach($_POST as $k => $v) $_POST[$k] = addslashes($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = addslashes($v);
import_request_variables("gp");
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");

if ($action == "Delete") {
	mysql_query("DELETE FROM sap_faqs WHERE faq_id = $faq_id");
	echo "FAQ #$faq_id has been deleted";
	}
else if ($action == "Update") {
	$faq_query = mysql_query("SELECT * FROM sap_faqs WHERE faq_id = $faq_id");
	$faq_obj = mysql_fetch_object($faq_query);
	echo "
		<H2>SAP FAQ Update</H2>
		<P>Question and answer can be any length.  HTML formatting can be
		used to add hyperlinks, images or pretty much anything else you
		can put on a webpage.  Please remember to close any HTML tags as
		these will affect the rest of the page.</P>
		<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		<B>Question:</B><BR>
		<TEXTAREA NAME=\"question\" COLS=\"50\" ROWS=\"2\">";
		echo "$faq_obj->question";
	echo "</TEXTAREA><BR><BR>
		<B>Answer:</B><BR>
		<TEXTAREA NAME=\"answer\" COLS=\"50\" ROWS=\"6\">";
		echo "$faq_obj->answer";
	echo "</TEXTAREA><BR><BR>
		<INPUT TYPE=\"HIDDEN\" VALUE=\"$faq_id\" NAME=\"faq_id\">
		<INPUT TYPE=\"SUBMIT\" VALUE=\"Apply Changes\" NAME=\"action\">
		<INPUT TYPE=\"SUBMIT\" VALUE=\"Preview\" NAME=\"action\">
		</FORM>
		";
	}
if ((strlen($question) > 0) || (strlen($answer) > 0)) {
	if ((strlen($question) > 0) && (strlen($answer) > 0) && ($action == "Apply Changes")) {
		mysql_query("UPDATE sap_faqs SET question = '$question', answer = '$answer'
				WHERE faq_id = $faq_id");
		echo "
			<P>Updated Question: $question<BR>
			with Answer:<BR> $answer</P>
			";
		}
	else if ((strlen($question) > 0) && (strlen($answer) > 0) && ($action == "Preview")) {
		echo "
			<P><B>Preview:</B></P>
			<P>Question: $question<BR>
			Answer:<BR> $answer</P>
			";
		}
	else {
		echo "<BR><BR><B>Error: You must specify both a question
			and an answer</B>";
		}
	}
?>
</body>
</html>
