<?php

function get_template_directory() {
	$template = get_template();
	$tpl_root = DATA_DIR . '/templates';
	$template_dir = "$tpl_root/$template";
    return $template_dir;
}
function get_template_url() {
	$template = get_template();
	$tpl_root_uri = site_url('data/templates');
	$template_dir_uri = "$tpl_root_uri/$template";

	return $template_dir_uri;
}
function get_header() {
    load_template(get_template_directory().'/header.php');
}


function get_footer() {
	load_template(get_template_directory().'/footer.php');
}

function get_sidebar( $name = null ) {
	load_template(get_template_directory().'/sidebar.php');
}
function template_url(){
    echo get_template_url();
}
function get_template() {
	return get_option('template');
}
function load_template($tpl_file){
    global $editing,$message,$cmdb;
    if(!$message)$message=$_GET['message'];
    require_once($tpl_file);
}
function is_profile(){
    global $editing;
    if($_GET['action']=='edit')
    $editing=true;
    return ($_GET['cm']=='profile');
}
function get_profile_template(){
    return get_template_directory().'/profile.php';
}

function is_course(){
    return ($_GET['cm']=='courses-list' || $_GET['cm']=='joined-courses');
}
function get_course_template(){
    return get_template_directory().'/course.php';
}
?>