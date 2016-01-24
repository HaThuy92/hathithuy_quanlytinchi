<?php
require_once('admin.php');
$title="CCM Bảng điều khiển - Thêm sinh viên mới";
$usertype='student';
$new_student=array();
setup_userdata($new_student);
set_admin_content('user-edit');
require_once('template-loader.php');
?>