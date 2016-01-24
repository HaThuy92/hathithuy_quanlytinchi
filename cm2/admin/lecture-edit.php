<?php
require_once("admin.php");
$title=__("CCM Bảng điều khiển - Quản giảng đường");
$page = 1;
if(isset($_GET['page'])){
    $page=absint($_GET['page']);
}
$limit=get_option('lh_per_page')?get_option('lh_per_page'):15;
$offset=($page-1)*$limit;
$total_lh=_get_num_lh();
$total_page=$total_lh/$limit+1;
$all_lh=_get_lh($offset,$limit);
require_once("template-loader.php");
?>