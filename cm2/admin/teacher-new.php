<?php
require_once('admin.php');
$title="CCM Bảng điều khiển - Thêm giảng viên mới";
$usertype='teacher';
$new_teacher=array();
setup_userdata($new_teacher);
set_admin_content('user-edit');
require_once('template-loader.php');
?>