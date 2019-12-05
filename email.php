    <?php
    require_once('includes/config.php');
    include('includes/sc-includes.php');
    session_start();

    if (($total_sent % $texts_allowance) == 0 && (isset($total_sent))){
     $to = "jim.craig@roswellit.com";
     $sub = "$company_name $texts_allowance Credits, Usage Warning";
     $messg = "$company_name have used up their allocated $texts_allowance text credits.\r\nTotal credits used: $total_sent";
     $from = "admin@$company_domain";
     $headers = "From:" . $from;
     mail($to,$sub,$messg,$headers);
     }

    if ($_POST['Number']) {
    //SEND EMAIL
    $number =  $_POST['Number'];
    $phoneNumbers = array();
    $phoneNumbers = explode("," , $number);
    $textNumbers = array();

    foreach ($phoneNumbers as $value ) {
        $refactor = 44 . ltrim($value, '0');
        $textNumbers[] = $refactor;
    }
    foreach ($textNumbers as $val){
        if (strlen($val) % 12 == 0 && is_numeric($val)){
            $emailNumbers = array();
            foreach ($textNumbers as $value){
                $emailNumber = "$value@textmarketer.biz";
                $emailNumbers[] = $emailNumber;
            }
            $message = $_POST['Message'];
            $msg = $message . ' ' . $_POST['Signature'] . '##';
            $emailfrom = "mobile@$company_domain";
            $name = "$company_name";
            $subject = $_POST['Reference'].' - '.$username;
            $ref =  $_POST['Reference'];
            $chars = ceil(strlen($message)+ 39);

            if ($chars <= 160) {
                $texts = 1;
            }
            elseif ($chars > 160 && $chars <= 306) {
                $texts = 2;
            }
            elseif ($chars > 306 && $chars <= 459) {
                $texts = 3;
            }

            mysql_query("INSERT INTO logs (log_message, log_number, log_ref, log_user, log_branch, log_time, log_texts_used) VALUES 
    
            (
                '".$message."',
                '".$number."',
                '".$ref."',
                '".$username."',
                '".$userbranchid."',
                '".time()."',
                '".$texts."'
            )
    
                ");
    foreach ($emailNumbers as $value){
        mail($value, $subject, $msg,
            "From: $name <$emailfrom>  \n" .
            "MIME-Version: 1.0\n" .
            "Content-type: text/html; charset=iso-8859-1");}
    redirect('Your message has been sent.',"email.php");
        }
        else{
            redirect("there is and issue with number $val", "email.php");
        }
    }


    //END SEND EMAIL
    }
    ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $company_name; ?></title>
    <script src="includes/lib/prototype.js" type="text/javascript"></script>
    <script src="includes/src/effects.js" type="text/javascript"></script>
    <script src="includes/validation.js" type="text/javascript"></script>
    <script src="includes/src/scriptaculous.js" type="text/javascript"></script>
    <link href="includes/style.css" rel="stylesheet" type="text/css" />
    <link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
    var maxLength=<?php echo (459 - $sig_chars);?>;
    var minLength=<?php echo $sig_chars;?>;
    function charLimit(el) {
        if (el.value.length > maxLength) return false;
        return true;
    }
    function characterCount(el) {
        var charCount = document.getElementById('charCount');
        var msgCount = document.getElementById('msgCount');
        if (el.value.length > maxLength) el.value = el.value.substring(0,maxLength);
        if (charCount) charCount.innerHTML = minLength + el.value.length;
        if (el.value.length <= 121) msgCount.innerHTML = 1;
        if (el.value.length >= 122 && el.value.length <= 267) msgCount.innerHTML = 2;
        if (el.value.length >= 268) msgCount.innerHTML = 3;

        return true;
    }
    </script>
    </head>

    <body>
    <div class="logincontainer">
        <?php if ($user_admin) {
        echo '<a href="admin.php" target="_blank"><img src="includes/logo.png"></a>';
        }
        else{
        echo '<img src="includes/logo.png">';
        }?>

        <br/>
      <h1>Messaging Client</h1>
        <?php display_msg(); ?>
      <br/>


      <form id="form1" name="form1" method="post" action="">Welcome <Strong><?php echo $username; ?></strong>. Please enter a Mobile number and message to send a text direct to a phone.<br />

           <br />
           <label>Number</label>
           <input name="Number" type="text" class="required validate-alphanum1" size="39"  />
           <br />
           <label>Name/Reference</label>
           <input name="Reference" type="text" class="required" size="39"  />
           <br />
           <label>Message</label>
           <textarea name="Message" rows="4" class="required" cols="30" onKeyPress="return charLimit(this)" onKeyUp="return characterCount(this)"></textarea>
           <br />
           <p><strong><span id="charCount"><?php echo $sig_chars;?></span> / 459 [<span id="msgCount">1</span> Text(s)]</strong><span style = "float:right">Credits <strong><?php echo $total_sent; ?> / <?php echo $texts_allowance; ?></strong></span></p>
           <label>Signature</label>
           <input name="Signature" type="text" class="required" size="39" readonly="readonly" value="<?php echo $signature;?>"/>
           <br/>
           <br/>
           <input type="submit" name="Submit" value="Send Text" />
           <a href="email.php"></a>  </p>
      </form>

      <script type="text/javascript">
                            var valid2 = new Validation('form1', {useTitles:true});
                        </script>
                        <br/>
                        <span style = "float:left"><a href = "logs.php" target="_blank">Check Messaging History</a></span>
                        <span style = "float:right"><a href = "logout.php">Log out.</a></span>
                        <br/>
                        <br/>
                        <a href="http://www.roswellit.com" target="_blank"><p style="text-align:center">© <?php echo date("Y"); ?> Roswell IT Services. All Rights Reserved.</p></a>
    </div>
    </body>
    </html>