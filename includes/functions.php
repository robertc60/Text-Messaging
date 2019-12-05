<?php

//SET SUCCESS NOTICES
	$_SESSION['msg'] = '';
function set_msg($msga) 	{
	$_SESSION['msg'] = $msga;
}

function display_msg() {
if (!empty($_SESSION['msg'])) {
	echo "<span class='notices'>$_SESSION[msg]</span>";
	unset($_SESSION['msg']);
}
}

if (!isset($_SESSION['msg'])) {
$dis = 'none';
}

if (isset($_SESSION['msg'])) {
$dis = 'block';
}
//

//show/hide div based on url
function showdiv($dp,$get) {

if ($dp==$get) {
	echo 'block';
} else {
	echo 'none';
}

}
//

//checkbox
function checked($par,$value) {

	if ($par==$value) {
	echo ' checked="checked" ';
	}

}
//

//selected
function selected($par,$value) {

	if ($par==$value) {
	echo ' selected="selected" ';
	}

}
//

//redirect to page & message
function redirect($smsg,$red) {

	set_msg($smsg);
	header('Location: '.$red); die;

}
//


//url/link
function url($url) {

$urlb = strtolower(addslashes($url));
$urlb = str_replace(" ","-",$urlb);
$urlb = str_replace("/","-",$urlb);
$urlb = ereg_replace("[^A-Za-z0-9\-]", "",$urlb);
return $urlb;

}
//

//randomstring
$rand = strtolower(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
//

//function - insert
function insert($post) {

$post = addslashes($_POST[$post]);
return $post;
}
//

//add image
function add_image($field,$dir,$pwidth) {

   if($_FILES[$field] && $_FILES[$field]['size'] > 0){

	global $rand;
	global $ori_name;
	global $picture;
	global $filename;

	$ori_name = $_FILES[$field]['name'];
	$ori_name = $rand;
	$tmp_name = $_FILES[$field]['tmp_name'];
	$src = imagecreatefromjpeg($tmp_name);
	list($width,$height)=getimagesize($tmp_name);
	$newwidth = $pwidth;
	$newheight=($height/$width)*$pwidth;
	$tmp=imagecreatetruecolor($newwidth,$newheight);
	imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
	$filename = $dir.$ori_name.".jpg";
	imagejpeg($tmp,$filename,100);
	$picture = $ori_name.".jpg";

	}

}
//

//file upload
function file_upload($folder,$field) {

	$uploaddir = $folder;  //set this to where your files should be uploaded.  Default is same directory as script.
	$filename = $_FILES[$field]['name'];
	$uploadfile = $uploaddir . $_FILES[$field]['name'];
	move_uploaded_file($_FILES[$field]['tmp_name'], $uploadfile);
	$file = $filename;
	chmod($uploadfile,0777);

return $file;

}
//

//general recordset
function record_set($name,$query) {

global $contacts;
global ${"query_$name"};
global ${"$name"};
global ${"row_$name"};
global ${"totalRows_$name"};

	${"query_$name"} = "$query";
	${"$name"} = mysql_query(${"query_$name"},$contacts) or die(mysql_error());
	${"row_$name"} = mysql_fetch_assoc(${"$name"});
	${"totalRows_$name"} = mysql_num_rows(${"$name"});

}
//

//display a select dropdown list
function select_list($id,$rs,$matcha,$matchb,$v,$display) {

	global ${"query_$rs"};
	global ${"$rs"};
	global ${"row_$rs"};
	global ${"totalRows_$rs"};
	
	echo "<select id='$id' name='$id'>\n<option value=''>Select from below:</option>\n";
	
	do { 

		$se = "";
		if (${"row_$rs"}[$matcha] == $matchb) $se = "selected='selected'";
		echo "<option $se value='".${"row_$rs"}[$v]."'>".${"row_$rs"}[$display]."</option>\n";

	} while (${"row_$rs"} = mysql_fetch_assoc(${"$rs"})); 
	
	echo "</select>";

}
//

// get user IP
function getUserIP() 
{ 
 $ip; 
 if (getenv("HTTP_CLIENT_IP")) 
 $ip = getenv("HTTP_CLIENT_IP"); 
 else if(getenv("HTTP_X_FORWARDED_FOR")) 
 $ip = getenv("HTTP_X_FORWARDED_FOR"); 
 else if(getenv("REMOTE_ADDR")) 
 $ip = getenv("REMOTE_ADDR"); 
 else 
 $ip = "UNKNOWN";
 return $ip; 

 }
//


// Date Picker
function date_picker($name, $value, $startyear=NULL, $endyear=NULL)
{
	$valueday = date('d', $value);
	$valuemonth = date('n', $value);
	$valueyear = date('Y', $value);
	

    if($startyear==NULL) $startyear = date("Y")-90;
    if($endyear==NULL) $endyear=date("Y")+50; 

	$months=array('','January','February','March','April','May',
    'June','July','August', 'September','October','November','December');
    
    // Day dropdown
    $html="<select name=\"".$name."day\">";
    for($i=1;$i<=31;$i++)
    {
       $html.="<option value='$i'";
	   if ($i==$valueday) {
		$html.= ' selected="selected" ';
		}
	   $html.= ">$i</option>";
    }
    $html.="</select> ";
	

    // Month dropdown
    $html.="<select name=\"".$name."month\">";

	
    for($i=1;$i<=12;$i++)
    {
       $html.="<option value='$i'"; 
		if ($i==$valuemonth) {
		$html.= ' selected="selected" ';
		}
	   $html.=">$months[$i]</option>";
    }
    $html.="</select> ";
   

    // Year dropdown
    $html.="<select name=\"".$name."year\">";

    for($i=$startyear;$i<=$endyear;$i++)
    {      
      $html.="<option value='$i'";
	  if ($i==$valueyear) {
		$html.= ' selected="selected" ';
		}
	  $html.=">$i</option>";
    }
    $html.="</select> ";
	
    return $html;
}

function update_history($type, $value, $ref, $user, $parent)
{
mysql_query("INSERT INTO history (history_date, history_type, history_ref, history_pageid, history_user, history_parentid) VALUES 

	(
		'".time()."',
		'".$type."',
		'".$ref."',
		'".$value."',
		'".$user."',
		'".$parent."'
	)

	");
}

?>