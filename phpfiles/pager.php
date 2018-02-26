<?PHP
import_request_variables("gp");
$auth_user = $_ENV['AUTH_USER'];
$my_name = substr($auth_user,8);
$mail_headers = "From: $my_name@lhup.edu\r\nReply-To: $my_name@lhup.edu\r\nReturn-Path: $my_name@lhup.edu";
mail("$ph_num", "Message From $my_name", "$message", "$mail_headers");
echo "The following has been sent:<BR><BR>
	$message";
?>