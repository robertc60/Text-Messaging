<?php require_once('includes/config.php'); 
include('includes/functions.php');
$pagetitle = "Password Request";
session_start();


if ($_POST['email']) {
record_set('passwordcheck',"SELECT * FROM users WHERE user_email = '".$_POST['email']."'");

if ($totalRows_passwordcheck==1) { 

//SEND EMAIL WITH PASSWORD
$emailfrom = "admin@the-furnishing-service.co.uk";
$name = "The Furnishing Service";
$subject = "Password Reset";
$message = "User " . $row_passwordcheck['user_email'] . " has requested a password reset for the Text to Email Messaging Service. ";
$emailto = "support@roswellit.com";

mail($emailto, $subject, $message, 
	"From: $name <$emailfrom>\n" .
	"MIME-Version: 1.0\n" .
	"Content-type: text/html; charset=iso-8859-1") .
redirect('Your password reset request been sent.',"login.php");
//END SEND EMAIL
}

if ($totalRows_passwordcheck < 1) {
set_msg('That email address was not found in the database.');
header('Location: password.php'); die;
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
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="logincontainer">
 <img  src="includes/logo.png">
	<br/>
  <h1>The Furnishing Service</h1>

    <?php display_msg(); ?>

  <form id="form1" name="form1" method="post" action="">Enter your email address below and Roswell will reset your password and it will be sent to you asap. <br />
       <br />
       <input name="email" class="required validate-email" type="text" size="35" title="You must enter your email address." />
       <br />
	   <br/>
       <input type="submit" name="Submit" value="Send Request" />
       <a href="password.php"></a>  </p>
     <p>&nbsp;</p>
     <p><a href="login.php">Go back    </a></p>
  </form>
					<script type="text/javascript">
						var valid2 = new Validation('form1', {useTitles:true});
					</script>
</div>
</body>
</html>