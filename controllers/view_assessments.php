<?php
if( !$_SESSION['valid'] ) 
	require_once('views/login.php');
else {
	require_once('views/nav.php');
	// get this user's inventory assessments
	$inventory = new InventoryAssessment;
	$inventory_assessments = $inventory->get_all_for_user($_SESSION['user_id']);
	// get this user's transect assessments
	$transect = new TransectAssessment;
	$transect_assessments = $transect->get_all_for_user($_SESSION['user_id']);
	require_once('views/view_assessments.php');
}
?>