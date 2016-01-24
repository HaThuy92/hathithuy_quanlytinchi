<?php
require_once("admin.php");
$title=__("CCM Bảng điều khiển - Quản lý khoa");
$page = 1;
if(isset($_GET['page'])){
    $page=abs($_GET['page']);
}
$limit=get_option('faculty_per_page')?get_option('faculty_per_page'):15;
$offset=($page-1)*$limit;
$total_faculty=_get_num_faculty();
$total_page=$total_faculty/$limit+1;
$all_faculties=_get_faculties($offset,$limit);
require_once("template-loader.php");
?>