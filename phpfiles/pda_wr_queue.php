<html>
<head>
<title>LHUP Computing Center</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>


<?PHP
foreach($_GET as $k => $v) $_GET[$k] = addslashes($v);
foreach($_POST as $k => $v) $_POST[$k] = addslashes($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = addslashes($v);
import_request_variables("gp");
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");
$wr_query = mysql_query("SELECT wr_id,req_name,title,status,cc_staff,priority,ph_num,building,room_no FROM 
	workrequests WHERE (status = 'Approved' OR status = 'Started' OR status = 'Waiting') 
	ORDER BY priority,add_date,status");
echo "
	<H2>Work Request Queue</H2>
	<P>The following work requests have been promoted to the general queue.</P>
	";
$rows = mysql_num_rows($wr_query);
echo "<BR><BR>";
while ($rows > 0):
	$wr_obj = mysql_fetch_object($wr_query);
	echo "
		<A HREF=\"pda_wr_disp.php?wr_id=$wr_obj->wr_id\">$wr_obj->wr_id --
		$wr_obj->req_name --
		$wr_obj->title --
		$wr_obj->ph_num --
		$wr_obj->building $wr_obj->room_no --
		$wr_obj->status --
		$wr_obj->priority --
		$wr_obj->cc_staff</A>
	<HR>";
	--$rows;
	endwhile;
?>

</body>
</html>
