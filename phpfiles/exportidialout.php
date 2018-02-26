<?PHP
Header("Content-type: text/csv"); 
header('Content-Disposition: attachment; filename="idialout.csv"');

mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");

$query = mysql_query("select username, instance, npa, nxx, ext from idialoutphone order by npa, nxx, ext");
echo <<<END
UserID,GroupNo,GroupName,ContactName,PhoneDisplay,Extension,CallPriority\n
END;
$rows = mysql_num_rows($query);
while ($rows > 0):
	$id_obj = mysql_fetch_object($query);
	echo <<<END
administrator,60,Employees,$id_obj->username - $id_obj->instance,91$id_obj->npa$id_obj->nxx$id_obj->ext,91$id_obj->npa$id_obj->nxx$id_obj->ext,0\n
END;
	--$rows;
	endwhile;
?> 
