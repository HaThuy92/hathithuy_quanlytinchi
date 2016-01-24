<?php
require_once("admin.php");
$title=__("CCM Bảng điều khiển - Quản lý sinh viên");
$page = 1;
if(isset($_GET['page'])){
    $page=absint($_GET['page']);
}
$limit=get_option('student_per_page')?get_option('student_per_page'):15;
$offset=($page-1)*$limit;
$all_students=cm_get_students($offset,$limit);
require_once('template-loader.php');
?>