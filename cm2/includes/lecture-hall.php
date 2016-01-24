<?php
function get_lhdata($lh){
	global $cmdb;
	return $cmdb->get_row($cmdb->prepare("SELECT * FROM $cmdb->lecture_hall WHERE lh_id=%d",$lh));
}
function setup_lhdata($lh){
	global $lhdata;
	$lhdata=$lh;
	return true;
}

function get_lh_id(){
	global $lhdata;
	return $lhdata->lh_id;
}
function get_lh_name(){
	global $lhdata;
	return $lhdata->name;
}
function get_lh_address(){
	global $lhdata;
	return $lhdata->address;
}
function lh_id(){
	echo get_lh_id();
}
function lh_name(){
	echo get_lh_name();
}
function lh_address(){
	echo get_lh_address();
}
?>