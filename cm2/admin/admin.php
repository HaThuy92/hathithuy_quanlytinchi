<?php
if ( !defined('CM_ADMIN') )
	define('CM_ADMIN', TRUE);

if ( defined('DIR') )
	require_once(DIR . 'cm-load.php');
else
	require_once('../cm-load.php');
require_once(DIR . 'admin/includes/admin.php');
auth_redirect();
if(!is_administrator())
	cm_die("Bạn không đủ quyền để truy cập trang này");
 ?>