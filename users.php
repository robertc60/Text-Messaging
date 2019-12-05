<?php require_once('includes/config.php'); 
include('includes/sc-includes.php');
$pagetitle = 'Users';

//restrict access
if (!$user_admin) {
redirect('You do not have permission to access that page.',"email.php"); die;
}
//

$update = isset($_GET['id']) ? 1 : 0;
$add = isset($_GET['add']) ? 1 : 0;
$del = isset($_GET['del']) ? 1 : 0;


if (!$update && !$add) {
record_set('users',"SELECT * FROM users LEFT JOIN branches ON branch_id = user_branch ORDER BY user_email ASC");
}

//DELETE user
if ($del) {
mysql_query("DELETE FROM users WHERE user_id = ".$_GET['id']."");

	set_msg('User Deleted');
	header('Location: users.php'); die;
}
//

if ($update) {
record_set('userp',"SELECT * FROM users LEFT JOIN branches ON branch_id = user_branch WHERE user_id = ".$_GET['id']."");
}

$password = $row_userp['user_password'];

if ($_POST['password']) {
$password = $_POST['password'];
}

record_set('branchinfo',"SELECT * FROM branches");

//ADD user
if ($add && $_POST['user_email']) {
$password = crypt($password);

mysql_query("INSERT INTO users (user_name, user_email, user_branch, user_admin, user_password) VALUES

(
	'".$_POST['user_name']."',
	'".trim($_POST['user_email'])."',
	'".$_POST['user_branch']."',
	'".$_POST['user_admin']."',
	'".$password."'
)

");
set_msg('User Added');
header('Location: users.php'); die;
}
//


//UPDATE user
if ($_POST['user_email'] && $update) {
$password = crypt($password);

	mysql_query("UPDATE users SET 
		user_name = '".$_POST['user_name']."',
		user_email = '".trim($_POST['user_email'])."', 
		user_branch = '".$_POST['user_branch']."',
		user_admin = '".$_POST['user_admin']."',
		user_password = '".trim($password)."' 
	WHERE user_id = ".$_GET['id']."
	");
	
	set_msg('User Updated');
	if ($row_userp['user_id'] == $userid) {
	$_SESSION['user'] = $_POST['email'];
	}
	
	
	header('Location: users.php'); die;
}
//

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Users</title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
  <div class="leftcolumn">
    <h2>Users</h2>
    <?php display_msg(); ?>
 <a href="users.php?add"><br />
    <strong>Add User</strong> </a><br />
    <br />

<?php if (!$add && !$update) { ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td scope="row"><strong>Name</strong></td>
        <td><strong>Email</strong></td>
        <td><strong>Branch</strong></td>
        <td><strong>Access</strong></td>
		<td>&nbsp;</td>
      </tr>



<?php $row_count = 1; do { ?>
      <tr <?php if ($row_count%2) { ?>bgcolor="#E9E9E9"<?php } ?>>
	  	<td scope="row" style="padding-left:5px"><?php echo $row_users['user_name']; ?></td>
        <td><?php echo $row_users['user_email']; ?></td>
        <td><?php echo $row_users['branch_name']; ?></td>
		<td><?php if ($row_users['user_admin'] == 1 ){ echo 'Admin';}?></td>
        <td><a href="users.php?id=<?php echo $row_users['user_id']; ?>">Edit</a> <?php if ($userid != $row_users['user_id']) { ?>- <a onclick="javascript:return confirm('Are you sure?')" href="users.php?del&id=<?php echo $row_users['user_id']; ?>">Delete</a><?php } ?></td>
      </tr>
<?php $row_count++; } while ($row_users = mysql_fetch_assoc($users)); ?>

    </table>
    <br />
<?php } ?>


<?php if ($update || $add) { ?>
    <form id="form1" name="form1" method="post" action="">
	  <p>Name
        <br />
        <input name="user_name" type="text" id="user_name" value="<?php echo $row_userp['user_name']; ?>" size="35" />
      </p><br/>
	  <p>Email
        <br />
        <input name="user_email" type="text" id="user_email" value="<?php echo $row_userp['user_email']; ?>" class="required validate-email" size="35" />
      </p>
	  <br/>
	  <p>Branch<br />
	  <select id="user_branch" name="user_branch">
		<?php do { ?>
				<option value="<?php echo $row_branchinfo['branch_id']; ?>" <?php selected ($row_branchinfo[branch_id],$row_userp['user_branch']); ?> >
		<?php echo $row_branchinfo['branch_name']; ?></option>
		<?php } while ($row_branchinfo = mysql_fetch_assoc($branchinfo)); ?>
		</select>
	  
	  
      <p><br />
	  <p>Access Level<br />
	  <select id="user_admin" name="user_admin">
					  <option value="0" <?php selected($row_userp['user_admin'],0);?>>Standard User</option>
					  <option value="1" <?php selected($row_userp['user_admin'],1);?>>Administrator</option>
					  </select>
      <p><br />
        Password (please re-enter if editing)<br />
        <input name="password" type="password" id="password" />
          <br />
          </p>
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
