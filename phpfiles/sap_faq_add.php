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

echo "
	<H2>SAP FAQ Addition</H2>
	<P>Question and answer can be any length.  HTML formatting can be
	used to add hyperlinks, images or pretty much anything else you
	can put on a webpage.  Please remember to close any HTML tags as
	these will affect the rest of the page.</P>
	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<B>Question:</B><BR>
	<TEXTAREA NAME=\"question\" COLS=\"50\" ROWS=\"2\">";
if ($action == "Preview") {
	echo "$question";
	}
echo "</TEXTAREA><BR><BR>
	<B>Answer:</B><BR>
	<TEXTAREA NAME=\"answer\" COLS=\"50\" ROWS=\"6\">";
if ($action == "Preview") {
	echo "$answer";
	}
echo "</TEXTAREA><BR><BR>
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Add\" NAME=\"action\">
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Preview\" NAME=\"action\">
	</FORM>
	";

if ((strlen($question) > 0) || (strlen($answer) > 0)) {
	if ((strlen($question) > 0) && (strlen($answer) > 0) && ($action == "Add")) {
		mysql_query("INSERT INTO sap_faqs (question,answer,date_added)
			VALUES ('$question','$answer',NOW())");
		echo "
			<P>Inserted Question: $question<BR>
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
