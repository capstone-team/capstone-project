<html>
<head>
<title>SAP Frequently Asked Questions</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#E1E1E1">
<?PHP
foreach($_GET as $k => $v) $_GET[$k] = addslashes($v);
foreach($_POST as $k => $v) $_POST[$k] = addslashes($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = addslashes($v);
import_request_variables("gp");
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");
echo "
	<H2>SAP Frequently Asked Questions Database</H2>
	<P>Please type your search string below. All terms are included in the search.</P>
	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<INPUT TYPE=\"TEXT\" NAME=\"searchstring\" SIZE=\"60\"><BR>
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Search\">
	</FORM>
	<BR><A HREF=\"$PHP_SELF?searchstring=%\">See all FAQ's</A>
	";
if (strlen($searchstring) > 0) {
	$keywords = preg_split ("/[\s,]+/", "$searchstring");
	$query_string = "SELECT faq_id,question,answer FROM sap_faqs WHERE";
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
			<P><form action=sap_faq_update.php method=post>
			<input type=hidden name=faq_id value=\"$faq_obj->faq_id\">
			<input type=submit name=action value=Delete>
			<input type=submit name=action value=Update>
			$faq_obj->question</form></P>
			";
		--$rows;
		endwhile;
	}
echo "
	<P><A HREF=\"sap_faq_add.php\">Add New FAQ</A></P>
	";
?>
</body>
</html>
