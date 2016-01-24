<?php
require_once("admin.php");
$title="CCM - Bảng điều khiển >> Quản lý môn học";
$page = 1;
if(isset($_GET['page'])){
    $page=absint($_GET['page']);
}
$limit=get_option('course_per_page')?get_option('course_per_page'):15;
$offset=($page-1)*$limit;
$all_courses=cm_get_courses($offset,$limit);

require_once("template-loader.php");
?>