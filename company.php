<?php require_once('includes/config.php'); 
include('includes/sc-includes.php');
$pagetitle = 'Company Information';

//restrict access
if (!$user_admin) {
redirect('You do not have permission to access that page.',"email.php"); die;
}
//

$update = isset($_GET['id']) ? 1 : 0;
$add = isset($_GET['add']) ? 1 : 0;
$del = isset($_GET['del']) ? 1 : 0;


if (!$update && !$add) {
record_set('company_info',"SELECT * FROM company");
record_set('branch_info',"SELECT * FROM branches");
}

//DELETE branch
if ($del) {
mysql_query("DELETE FROM branches WHERE branch_id = ".$_GET['id']."");

	set_msg('Branch Deleted');
	header('Location: company.php'); die;
}
//

//Update Company
if ($update) {
record_set('company_info',"SELECT * FROM company WHERE company_id = ".$_GET['id']."");
}


//ADD Company
if ($add && $_POST['company_name']) {

mysql_query("INSERT INTO company (company_name, company_domain, company_allowance) VALUES

(
	'".$_POST['company_name']."',
	'".$_POST['company_domain']."',
	'".$_POST['company_allowance']."'
)

");
set_msg('Company Added');
header('Location: company.php'); die;
}
//


//UPDATE Company
if ($_POST['company_name'] && $update) {


	mysql_query("UPDATE company SET 
		company_name = '".$_POST['company_name']."',
		company_domain = '".$_POST['company_domain']."', 
		company_allowance = '".$_POST['company_allowance']."'
	WHERE company_id = ".$_GET['id']."
	");
	
	set_msg('Company Updated');
	header('Location: company.php'); die;
}
//



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle;?></title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
  <div class="leftcolumn">
    <h2>Company Information</h2>
    <?php display_msg(); ?>
 <?php if (!$row_company_info['company_name']) { ?><a href="company.php?add"><br />
    <strong>Add Company</strong> </a><br />
	<?php } ?>
    <br />

<?php if (!$add && !$update && $row_company_info['company_name']) { ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td scope="row"><strong>Name</strong></td>
        <td><strong>Domain</strong></td>
        <td><strong>Text Allowance</strong></td>
		<td>&nbsp;</td>
      </tr>



<?php $row_count = 1; do { ?>
      <tr <?php if ($row_count%2) { ?>bgcolor="#E9E9E9"<?php } ?>>
	  	<td scope="row" style="padding-left:5px"><?php echo $row_company_info['company_name']; ?></td>
        <td><?php echo $row_company_info['company_domain']; ?></td>
        <td><?php echo $row_company_info['company_allowance']; ?></td>
        <td><a href="company.php?id=<?php echo $row_company_info['company_id']; ?>">Edit</a></td>
      </tr>
<?php $row_count++; } while ($row_company_info = mysql_fetch_assoc($company_info)); ?>

    </table>
    <br />
<?php } ?>
	
<?php if (!$add && !$update && $row_branch_info['branch_name']) { ?>
    <table width="60%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td scope="row"><strong>Branch Name</strong></td>
        <td><strong>Branch Phone</strong></td>
		<td>&nbsp;</td>
      </tr>



<?php $row_count = 1; do { ?>
      <tr <?php if ($row_count%2) { ?>bgcolor="#E9E9E9"<?php } ?>>
	  	<td scope="row" style="padding-left:5px"><?php echo $row_branch_info['branch_name']; ?></td>
        <td><?php echo $row_branch_info['branch_phone']; ?></td>
        <td><a href="branch.php?id=<?php echo $row_branch_info['branch_id']; ?>">Edit</a> - <a onclick="javascript:return confirm('Are you sure?')" href="company.php?del&id=<?php echo $row_branch_info['branch_id']; ?>">Delete</a></td>
      </tr>
<?php $row_count++; } while ($row_branch_info = mysql_fetch_assoc($branch_info)); ?>

    </table>
<?php } ?>

<a href="branch.php?add"><br />
    <strong>Add Branch</strong> </a><br />

<?php if ($update || $add) { ?>
    <form id="form1" name="form1" method="post" action="">
	  <p>Company Name
        <br />
        <input name="company_name" type="text" id="company_name" value="<?php echo $row_company_info['company_name']; ?>" class="required" size="35" />
      </p><br/>
	  <p>Domain
        <br />
        <input name="company_domain" type="text" id="company_domain" value="<?php echo $row_company_info['company_domain']; ?>" class="required" size="35" />
      </p>
	  <br/>
	  <p>Text Allowance<br />
	   <br />
        <input name="company_allowance" type="text" id="company_allowance" value="<?php echo $row_company_info['company_allowance']; ?>" class="required" size="35" />
      </p>
	  <br/>
      <p>
	  <br/>
        <input name="Submit2" type="submit" id="Submit2" value="Submit" /> 
      </p>
    </form>
<script type="text/javascript">
	var valid2 = new Validation('form1', {useTitles:true});
</script>

<?php } ?>

    
    <br/>
	<a href="admin.php">Back to the Admin Panel</a>
  </div>
 </div>
 
</body>
</html>
