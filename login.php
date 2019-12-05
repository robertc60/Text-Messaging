<?php require_once('includes/config.php'); 
include('includes/functions.php');
session_start();
if (isset($_SESSION['user'])) {
header('Location: email.php');
}

$pagetitle = Login;

if ($_POST['email']  && $_POST['password']) {
record_set('logincheck',"SELECT * FROM users WHERE user_email = '".addslashes($_POST['email'])."'");


$pass = $row_logincheck['user_password'];
if(crypt($_POST['password'],$pass) == $pass)
{
$_SESSION['start'] = time(); // taking now logged in time
$_SESSION['expire'] = $_SESSION['start'] + (36000) ; // ending a session in 10 Hours from the starting time
$_SESSION['user'] = addslashes($_POST['email']);
	$redirect = 'email.php';
	header(sprintf('Location: %s', $redirect)); die;
}

else{
redirect('Incorrect Username or Password' . $_SESSION['user'],"login.php");
}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?></title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="logincontainer">
<img  src="includes/logo.png">
	<br/>
  <h1><?php echo $Company_name; ?></h1>
      <?php display_msg(); ?>
  <form id="form1" name="form1" method="post" action="">
 Enter your Email address and Password to log in to the messaging client.
	<br/>
	<br/>

Email Address <br />
    <input name="email" type="text" size="39" class="required validate-email" title="You must enter your email address." />
    <br />
    <br />
    Password<br />
<input type="password" name="password" class="required" size="39"  title="Please enter your password." />
    <br />
    <br />
    <input type="submit" name="Submit" value="Login" />
    <a href="password.php">Forgotten your password?</a>
	<br/>
	</form>
	<br/>
	<a href="http://www.roswellit.com"><p style="text-align:center">© <?php echo date("Y"); ?> Roswell IT Services. All Rights Reserved.</p></a>
					<script type="text/javascript">
						var valid2 = new Validation('form1', {useTitles:true});
					</script>
</div>
</body>
</html>