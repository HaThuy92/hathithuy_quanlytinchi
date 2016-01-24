<?php
require("cm-load.php");
auth_redirect();
$student=get_username();
$selected_courses=get_selected_courses();
if($course=$_GET['select']){
    if(!in_array($course,$selected_courses))
        $selected_courses[]=$course;
    update_option($student."_selected_courses",$selected_courses);
}elseif($course=$_GET['unselect']){
    foreach($selected_courses as $k => $v){
        if($course==$v) unset($selected_courses[$k]);
    }
    update_option($student."_selected_courses",$selected_courses);
}
if($_POST['join-course']){
    $course_ids=$_POST['courses'];
    if(is_array($course_ids)){
        foreach($course_ids as $course_id){
            cm_join(get_user_id(),$course_id);
        }
        update_option($student."_selected_courses",'');//clear
        $message="Các khóa học bạn chọn đã được đăng ký thành công";
    }else{
        $message="Chưa có khóa học nào được chọn";
    }
}
cm_redirect(site_url()."/?cm=courses-list&message=".urlencode($message))
?>