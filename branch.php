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

if ($update) {
record_set('branch_info',"SELECT * FROM branches WHERE branch_id = ".$_GET['id']."");
}


//ADD Company
if ($add && $_POST['branch_name']) {

mysql_query("INSERT INTO branches (branch_name, branch_phone) VALUES

(
	'".$_POST['branch_name']."',
	'".$_POST['branch_phone']."'
)

");
set_msg('Branch Added');
header('Location: company.php'); die;
}
//


//UPDATE Company
if ($_POST['branch_name'] && $update) {


	mysql_query("UPDATE branches SET 
		branch_name = '".$_POST['branch_name']."',
		branch_phone = '".$_POST['branch_phone']."'
	WHERE branch_id = ".$_GET['id']."
	");
	
	set_msg('Branch Updated');
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
    <h2>Branch Information</h2>
    <?php display_msg(); ?>

<?php if ($update || $add) { ?>
    <form id="form1" name="form1" method="post" action="">
	  <p>Branch Name
        <br />
        <input name="branch_name" type="text" id="branch_name" value="<?php echo $row_branch_info['branch_name']; ?>" class="required" size="35" />
      </p><br/>
	  <p>Branch Phone
        <br />
        <input name="branch_phone" type="text" id="branch_phone" value="<?php echo $row_branch_info['branch_phone']; ?>" class="required" size="35" />
      </p>
	  <br/>
        <input name="Submit2" type="submit" id="Submit2" value="Submit" /> 
      </p>
    </form>
	

<script type="text/javascript">
	var valid2 = new Validation('form1', {useTitles:true});
</script>

<?php } ?>

    
    
  </div>
 </div>
 
</body>
</html>
