<?php require_once('includes/config.php');
include('includes/sc-includes.php');


//Get Totals
record_set('user_totals',"SELECT log_user, COUNT(*) count, SUM(log_texts_used) AS count2 FROM logs GROUP BY log_user ORDER BY count DESC");
record_set('branch_totals',"SELECT branch_name, COUNT( * ) count, SUM(log_texts_used) AS count2 FROM logs LEFT JOIN branches ON logs.log_branch = branches.branch_id GROUP BY log_branch ORDER BY count DESC");
record_set('tot_sent',"SELECT sum(log_texts_used) AS credits, count(log_id) AS texts FROM logs");
record_set('delivery',"SELECT log_status, COUNT(*) count FROM logs GROUP BY log_status ORDER BY count DESC");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Panel</title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
  
  <div class="container">
  <div class="leftcolumn">
    <h2>Admin Panel</h2>
	<br/>
	<a href ="company.php">Company and Branch Information </a><em>- Click here to add and remove Branches from the system, and also to Edit the Company information including text allowance.</em>
	  <br/><br/> <a href ="users.php">Users </a><em>- Click here to add and edit users in the system.</em>
	  <br/>
	  <br/>
	<p>Total Messages send = <strong><?php echo $row_tot_sent['texts']; ?></strong>
	<br/>Total credits used = <strong><?php echo $row_tot_sent['credits']; ?></strong>
	</p>
	<br/>
	<h4>Messages Sent Per User</h4>
      <table width="60%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2">
            <?php display_msg(); ?></td>
        </tr>
        <tr>
          <th width="50%" style="padding-left:5px"><a href="#">Username</a></th>
		  <th width="25%"><a href="#">Messages Sent</a></th>
		  <th width="25%"><a href="#">Credits Used</a></th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px"><?php echo $row_user_totals['log_user'] ? $row_user_totals['log_user'] : $na; ?></td>
          <td align="center"><?php echo $row_user_totals['count']; ?></td>
		  <td align="center"><?php echo $row_user_totals['count2']; ?></td>
        </tr>
		
        <?php $row_count++; } while ($row_user_totals = mysql_fetch_assoc($user_totals)); ?>
      </table>
	  <br/>
	  
	<h4>Messages Sent Per Branch</h4>
      <table width="60%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2">
		</td>
        </tr>
        <tr>
          <th width="50%" style="padding-left:5px"><a href="#">Branch</a></th>
		  <th width="25%"><a href="#">Messages Sent</a></th>
		  <th width="25%"><a href="#">Credits Used</a></th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px"><?php echo $row_branch_totals['branch_name'] ? $row_branch_totals['branch_name'] : $na; ?></td>
          <td align="center"><?php echo $row_branch_totals['count']; ?></td>
		  <td align="center"><?php echo $row_branch_totals['count2']; ?></td>
        </tr>
		
        <?php $row_count++; } while ($row_branch_totals = mysql_fetch_assoc($branch_totals)); ?>
      </table>
	  <br/>
	  <h4>Delivery Status</h4>
      <table width="60%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2">
		</td>
        </tr>
        <tr>
          <th width="50%" style="padding-left:5px"><a href="#">Delivery Status</a></th>
		  <th width="50%"><a href="#">Occurrences</a></th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px"><?php echo $row_delivery['log_status'] ? $row_delivery['log_status'] : $na; ?></td>
          <td><?php echo $row_delivery['count']; ?></td>
        </tr>
		
        <?php $row_count++; } while ($row_delivery = mysql_fetch_assoc($delivery)); ?>
      </table>
	  <br/>
	</div>
  </div>
</body>
</html>
