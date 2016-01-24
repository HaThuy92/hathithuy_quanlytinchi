<?php
if(!defined('DIR')){
	die;
}
//$action=$_REQUEST['action'];
define('INC', 'includes');
if ( !defined('CM_LANG_DIR') ) {

    define('CM_LANG_DIR', DIR . INC . '/languages'); // no leading slash, no trailing slash, full path, not relative to DIR
	
}
define('DATA_DIR',DIR.'data');
require_once (DIR . INC . '/php-capabilities.php');
require_once (DIR . INC . '/functions.php');
require_once (DIR . INC . '/classes.php');
require_cm_db();
$cmdb->set_prefix($table_prefix);
require_once (DIR . INC . '/cache.php');
cm_cache_init();
require_once (DIR . INC . '/formatting.php');
require_once (DIR . INC . '/user.php');
require_once (DIR . INC . '/auth.php');
require_once (DIR . INC . '/link.php');
require_once (DIR . INC . '/faculty.php');
require_once (DIR . INC . '/course.php');
require_once (DIR . INC . '/lecture-hall.php');
require_once (DIR . INC . '/template.php');
define('TEMPLATEPATH', get_template_directory());
//echo get_template_directory_uri();
include_once(DIR . INC . '/pomo/mo.php');
require_once (DIR . INC . '/languages.php');
require_once (DIR . INC . '/init.php');
?>