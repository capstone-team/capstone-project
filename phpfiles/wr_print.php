<?PHP
import_request_variables("gp");
$wrapper = <<<EOD
<html>
  <head>
    <title>LHUP IT Work Request</title>
    <style type="text/css">
      h3 {font-family: sans-serif}
      td {font-family: sans-serif}
      table {
	border-width: 2px 2px 2px 2px;
	border-spacing: 1px;
	border-style: solid solid solid solid;
	border-color: gray gray gray gray;
	border-collapse: separate;
	background-color: white;
      }
      table th {
	border-width: 1px 1px 1px 1px;
	padding: 1px 1px 1px 1px;
	border-style: solid solid solid solid;
	border-color: gray gray gray gray;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
      }
      table td {
	border-width: 1px 1px 1px 1px;
	padding: 1px 1px 1px 1px;
	border-style: solid solid solid solid;
	border-color: gray gray gray gray;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
      }
    </style>
  </head>
  <body onload="window.print(); window.close();">
CONTENTPLACEHOLDER
  </body>
</html>
EOD;

mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");

$wr_query = mysql_query("SELECT * FROM workrequests WHERE wr_id = $wr_id");
if (mysql_num_rows($wr_query) != 1) {
	$content .= <<<EOD
			<h2>Error!</h2>
                        <p>No such work request id.</p>
EOD;
	}
else {
	$wr_obj = mysql_fetch_object($wr_query);
       
$content .= <<<EOD
<center>
<h3>LHUP IT Work Request</h3>
<table border="2">
  <tr>
    <td width="50%">WR # $wr_obj->wr_id</td>
    <td>Prop # $wr_obj->lhu_prop_num</td>
  </tr>
  <tr>
    <td colspan="2">Title: $wr_obj->title</td>
  </tr>
  <tr>
    <td>Requestor: $wr_obj->req_name</td>
    <td>Username: $wr_obj->req_uname</td>
  </tr>
  <tr>
    <td>Location: $wr_obj->building $wr_obj->room_no</td>
    <td>Phone: $wr_obj->ph_num</td>
  </tr>
  <tr>
    <td>WR Type: $wr_obj->wr_type</td>
    <td>Status: $wr_obj->status</td>
  </tr>
  <tr>
    <td>Staff: $wr_obj->cc_staff</td>
    <td>Add Date: $wr_obj->add_date</td>
  </tr>
  <tr>
    <td>Staff: $wr_obj->cc_staff2</td>
    <td>Due Date: $wr_obj->due_date</td>
  </tr>
  <tr>
    <td>Staff: $wr_obj->cc_staff3</td>
    <td>Comp. Date: $wr_obj->cmpl_date</td>
  <tr>
    <td>Added by: $wr_obj->creator</td>
    <td>Priority: $wr_obj->priority</td>
  </tr>
  <tr>
    <td colspan="2">Description:<br>$wr_obj->descrip</td>
  </tr>
  <tr>
    <td colspan="2">IT Comments:<br>$wr_obj->cc_comments</td>
  </tr>
</table>
</center>

EOD;
	}

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>