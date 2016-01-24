<?php
global $current_admin_template;
if($current_admin_template==false){
    $current_admin_template='default';
}
define('ADMIN_TPLDIR',DIR.'admin/template/');
if(!is_dir(ADMIN_TPLDIR.$current_admin_template)){
    $current_admin_template='default';
        if(!is_dir(ADMIN_TPLDIR.$current_admin_template))
            cm_die('Default template is not exists');
}
define('ADMIN_TPL',ADMIN_TPLDIR.$current_admin_template.'/');
function admin_template_url(){
    echo get_admin_template_url();
}
function get_admin_template_url(){
    global $current_admin_template;
    $siteurl=get_option('siteurl');
    return $siteurl.'/admin/template/'.$current_admin_template.'/';
}
function class_alternate(){
	global $class_alternate;
	if(!isset($class_alternate))$class_alternate=true;
	if($class_alternate){
		echo ' class="alternate"';
		$class_alternate=false;
	}
	else $class_alternate=true;
}
function admin_load_content($file_content=""){
    global $current_admin_page;
	if(empty($current_admin_page))$current_admin_page=basename($_SERVER['PHP_SELF'], ".php");
    if(!$file_content){
		if($current_admin_page=="index")
			$file_content=ADMIN_TPL."home.php";
		else
			$file_content=ADMIN_TPL.$current_admin_page.".php";
		
	}
    if(file_exists($file_content)){
        require_once($file_content);
    }
}
require_once(ADMIN_TPL."index.php");
?>