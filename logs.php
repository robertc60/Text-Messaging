<?php require_once('includes/config.php');
include('includes/sc-includes.php');

//Search
if (isset($_GET['s'])){
$swhere = "WHERE ($like_where)";
record_set('logs',"SELECT * FROM logs $swhere ORDER BY log_time DESC LIMIT 0, 100");
}

//Branch sort
if (isset($_GET['branch'])){
if ($_GET['branch'] == 0){
$bran = 0;
record_set('logs',"SELECT * FROM logs ORDER BY log_time DESC LIMIT 0, 100");
}
else {
$bran = $_GET['branch'];
record_set('logs',"SELECT * FROM logs WHERE log_branch = $bran ORDER BY log_time DESC LIMIT 0, 100");
}
}

//User Sort
if (isset($_GET['user'])){
if ($_GET['user'] == '0'){
record_set('logs',"SELECT * FROM logs ORDER BY log_time DESC LIMIT 0, 100");
}
else{
$use = $_GET['user'];
record_set('logs',"SELECT * FROM logs WHERE log_user = '$use' ORDER BY log_time DESC LIMIT 0, 100");
}
}

//Default Value
if (!isset($_GET['user']) && !isset($_GET['branch']) && !isset($_GET['s'])){
record_set('logs',"SELECT * FROM logs ORDER BY log_time DESC LIMIT 0, 100");
}

//Get user list
record_set('user_list',"SELECT * FROM users WHERE user_admin != 1 ORDER BY user_name ");
record_set('branch_list',"SELECT * FROM branches");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/JavaScript">
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_setTextOfTextfield(objName,x,newText) { //v3.0
  var obj = MM_findObj(objName); if (obj) obj.value = newText;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Logs</title>
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
	<div class="searchbox">
	<form id="form4" name="form4" method="GET" action="logs.php" enctype="multipart/form-data">
      <input name="s" type="text" id="s" onfocus="MM_setTextOfTextfield('s','','')" value="Search" size="15" />
        <input type="submit" name="Submit_search" value="Go" />
  </form>
  </div>
    <h2>Messaging Logs</h2>
	<br/>
	<p>
	<div class="leftsort"><form id="form1" name="form1" method="GET" action="logs.php" enctype="multipart/form-data">
	Sort By Branch
	<select id="branch" name="branch">
			<option value="0" <?php selected($_GET['branch'],0);?>>Display All</option>
		<?php do { ?>
				<option value="<?php echo $row_branch_list['branch_id']; ?>" <?php selected ($row_branch_list['branch_id'],$_GET['branch']); ?>>
	<?php echo $row_branch_list['branch_name']; ?></option>
	<?php } while ($row_branch_list = mysql_fetch_assoc($branch_list)); ?>
		</select>

<input type="submit" name="Submit" value="Change Branch"/>
</form>
</div>
<div class="rightsort">
<form id="form2" name="form2" method="GET" action="logs.php" enctype="multipart/form-data">
Sort by User
<select id="user" name="user">
			<option value="0">Select a User...</option>
		<?php do { ?>
				<option value="<?php echo $row_user_list['user_name']; ?>" <?php selected ($row_user_list['user_name'],$_GET['user']); ?>>
<?php echo $row_user_list['user_name']; ?></option>
	<?php } while ($row_user_list = mysql_fetch_assoc($user_list)); ?>
		</select>
<input type="submit" name="Submit2" value="Change User"/>
</form>
</div>
</p>
<br />
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="5" align="right">
 </td>
        </tr>
        <tr>
          <td colspan="4">
            <?php display_msg(); ?></td>
        </tr>
        <tr>
          <th width="15%" style="padding-left:5px"><a href="#">Name/Ref</a></th>
		  <th width="15%"><a href="#">Number</a></th>
		  <th width="34%"><a href="#">Message</a></th>
          <th width="24%"><a href="#">Date/Time</a></th>
		  <th width="10%"> <a href="#">User</a></th>
		  <th width="2%"></th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px"><?php echo $row_logs['log_ref'] ? $row_logs['log_ref'] : $na; ?></td>
          <td><?php echo $row_logs['log_number']; ?></td>
		  <td><?php echo $row_logs['log_message']; ?></td>
		  <td><?php echo $row_logs['log_time'] ? date('d/m/Y \a\t g:i a' , $row_logs['log_time']) : ' '; ?></td>
		  <td><?php echo $row_logs['log_user']; ?></td>
		  <td><?php 
		  switch ($row_logs['log_status']) {
			case "DELIVERED":
				echo '<img src="includes/green.png">';
				break;
			case "FAILED":
				echo '<img src="includes/red.png">';
				break;
			default:
				echo '<img src="includes/blue.png">';
			
		  }
		  ?>
		  </td>
        </tr>
		
        <?php $row_count++; } while ($row_logs = mysql_fetch_assoc($logs)); ?>
      </table>
	</div>
  </div>
</body>
</html>
