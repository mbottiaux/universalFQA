<?php
if( !$_SESSION['valid'] ) 
	require_once('../views/login.php');
else {
	require_once('../views/nav.php');
	require_once('../views/view_account.php');
}
?>