<?php require_once('includes/config.php'); 
include('includes/sc-includes.php');
$pagetitle = 'Loading';

if (isset($_SESSION['user'])) {
header('Location: email.php');
}
?>