<?php
require_once('includes/config.php');
include('includes/sc-includes.php');

if (isset($_GET['status'])){
$mobile = '0' . substr($_GET['msisdn'], -10);
$date = $_GET['delivered_date'];



mysql_query("INSERT INTO delivery (delivery_msg_id, delivery_deliv_date, delivery_status, delivery_number) VALUES

(
	'".$_GET['id']."',
	'".$_GET['delivered_date']."',
	'".$_GET['status']."',
	'".$mobile."'
)

");

mysql_query("UPDATE logs SET 
		log_status = '".$_GET['status']."'
	WHERE log_number = $mobile && ($date - log_time) < 172800
	");

if ($_GET['status'] == 'FAILED') {
record_set('text',"SELECT log_ref, log_user, log_time, user_email FROM logs INNER JOIN users ON user_name = log_user WHERE $mobile = log_number && ($date - log_time) < 172800");
mail($row_text['user_email'], 'Text Message Alert', 'A Text Message sent to '.$mobile.' on '.date('d/m/Y \a\t g:i a' , $row_text['log_time']).', with the reference: '.$row_text['log_ref'].', has failed. Please re-check the number or see the messaging history for more information.', 
	"From: ".$company_name." <alert@".$company_domain.">  \n" .
	"MIME-Version: 1.0\n" .
	"Content-type: text/html; charset=iso-8859-1");
}
}
?>