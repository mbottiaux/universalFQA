<?php 
session_start(); 
require('../fqa_config.php');
if( !$_SESSION['valid'] ) {
	header( "Location: ../login.php" );
	exit;
} 
$connection = mysql_connect($db_server, $db_username, $db_password);
if (!$connection) 
	die('Not connected : ' . mysql_error());
$db_selected = mysql_select_db($db_database);
if (!$db_selected) 
	die ('Database error: ' . mysql_error());

// get parameters
$id = mysql_real_escape_string($_GET["id"]);

// delete the taxa
$sql = "DELETE FROM customized_taxa WHERE id='$id'";
mysql_query($sql);
?>