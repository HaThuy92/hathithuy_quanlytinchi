<?php
require_once("admin.php");
$title=__("CCM Bảng điều khiển - Quản lý giảng viên");
$page = 1;
if(isset($_GET['page'])){
    $page=absint($_GET['page']);
}
$limit=get_option('teacher_per_page')?get_option('teacher_per_page'):15;
$offset=($page-1)*$limit;
$all_teachers=cm_get_teachers($offset,$limit,$page);
require_once("template-loader.php");
?>