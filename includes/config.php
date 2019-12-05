<?php


//mysql connection information

$hostname_contacts = "localhost";  
$database_contacts = "cl48-tfs"; //The name of the database
$username_contacts = "cl48-tfs"; //The username for the database
$password_contacts = "2lqx2lqx"; // The password for the database
$contacts = mysql_connect($hostname_contacts, $username_contacts, $password_contacts) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_contacts, $contacts);

//

?>