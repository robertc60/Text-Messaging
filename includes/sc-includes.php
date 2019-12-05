<?php

//   Copyright 2012 Roswell-IT.co.uk
//
//   Licensed under the Apache License, Version 2.0 (the "License");
//   you may not use this file except in compliance with the License.
//   You may obtain a copy of the License at
//
//       http://www.apache.org/licenses/LICENSE-2.0
//
//   Unless required by applicable law or agreed to in writing, software
//   distributed under the License is distributed on an "AS IS" BASIS,
//   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//   See the License for the specific language governing permissions and
//   limitations under the License.

include('includes/functions.php');
$now = time();
session_start();
if (!isset($_SESSION['user']) OR $now > $_SESSION['expire']) {
session_destroy();
header('Location: login.php');
}

//GET USER INFORMATION
record_set('userinfo',"SELECT * FROM users LEFT JOIN branches ON branch_id = user_branch WHERE user_email = '".$_SESSION['user']."'");
record_set('companyinfo',"SELECT * FROM company");

$userid = $row_userinfo['user_id'];
$username = $row_userinfo['user_name'];
$useremail = $row_userinfo['user_email'];
$user_admin = $row_userinfo['user_admin'] == 1 ? 1 : 0;
$userbranch = $row_userinfo['branch_name'];
$userbranchid = $row_userinfo['user_branch'];

//company information
$company_name = $row_companyinfo['company_name'];
$company_domain = $row_companyinfo['company_domain'];
$texts_allowance = $row_companyinfo['company_allowance'];
$branchno = $row_userinfo['branch_phone'];

$signature = $company_name . ' - ' . $branchno;
$sig_chars = ceil(strlen($signature));

//Total Texts Sent
$total_sent = 0;
record_set('total_texts',"SELECT SUM(log_texts_used) as tot_texts FROM logs WHERE MONTH( FROM_UNIXTIME( logs.log_time ) ) = Month( NOW( ) )");
$total_sent = $row_total_texts['tot_texts'];

//not applicable
$na = '<span style="color:#333333">No results found</span>';
//

//search array
$like_where_array = array();
$like_where_array[] = 'log_message';
$like_where_array[] = 'log_number';
$like_where_array[] = 'log_ref';
$like_where_array[] = 'log_user';

$i = 1;
foreach ($like_where_array as $key => $value) {

$and = '';
if ($i > 1) {
$and = 'OR';
}
$like_where .= "$and $value LIKE '%".$_GET[s]."%' ";
$i++;
}


?>