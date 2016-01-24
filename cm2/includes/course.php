<?php
function get_selected_courses(){
    $student=get_username();
    $courses=get_option($student."_selected_courses");
    if(!$courses)$courses=array();
    return $courses;
}
function get_all_courses(){
	global $cmdb;
	$all_courses=$cmdb->get_results("SELECT * FROM $cmdb->courses");
	return $all_courses;
}
function get_coursedata($course_id){
    global $cmdb;
	return $cmdb->get_row($cmdb->prepare("SELECT * FROM $cmdb->courses WHERE ID=%d",$course_id));
}
function get_courses_by_userid($user_id=0){
	global $cmdb;
	if(empty($user_id))
		$user_id=get_user_id();
	$courses=$cmdb->get_results($cmdb->prepare("SELECT $cmdb->courses.* from $cmdb->courses join $cmdb->users_join on $cmdb->courses.ID=$cmdb->users_join.course_id where user_id=%d",$user_id));
	return $courses;
}
function setup_coursedata($course){
    global $coursedata;
    if(is_numeric($course))$course=get_coursedata($course);
    $coursedata=$course;
    //$faculty=get_facultydata(get_course_facultyid());
    //setup_facultydata($faculty);
}
function get_course_id(){
    global $coursedata;
    return $coursedata->ID;
}
function course_id(){
    echo get_course_id();
}
function get_course_facultyid(){
    global $coursedata;
    return $coursedata->faculty_id;
}
function course_facultyid(){
    echo get_course_facultyid();
}
function get_course_ccid(){
    global $coursedata;
    return $coursedata->cc_id;
}
function course_ccid(){
    echo get_course_ccid();
}
function get_course_name(){
    global $coursedata;
    return $coursedata->name;
}
function course_name(){
    echo get_course_name();
}
function get_course_desc(){
    global $coursedata;
    return $coursedata->description;
}
function course_desc(){
    echo get_course_desc();
}
function get_course_max(){
    global $coursedata;
    return $coursedata->max_student;
}
function course_max(){
    echo get_course_max();
}
function get_course_credit(){
    global $coursedata;
    return $coursedata->num_credit;
}
function course_credit(){
    echo get_course_credit();
}
function get_course_open(){
    global $coursedata;
    return $coursedata->join_open;
}
function course_open(){
    echo get_course_open();
}
function get_course_close(){
    global $coursedata;
    return $coursedata->join_close;
}
function course_close(){
    echo get_course_close();
}
function get_course_num_students($course=''){
    global $cmdb;
    if($course=='')$course=get_course_id();
    return $cmdb->get_var($cmdb->prepare("SELECT count(*) FROM $cmdb->courses join $cmdb->users_join on $cmdb->courses.ID=$cmdb->users_join.course_id
                                        join $cmdb->users on $cmdb->users_join.user_id=$cmdb->users.ID
                                        Where $cmdb->users.type='student' AND $cmdb->courses.ID=%d
        ",$course));
}
function course_num_students($course='',$link=false){
    if($course=='')$course=get_course_id();
    if($link){
        $before='<a href="'.admin_url("course.php?action=view-students&course=".$course).'"'.' title="'.__("Danh sách sinh viên của khóa học này").'">';
        $after='</a>';
    }
    echo $before . get_course_num_students($course) . $after;
}
function _fill_course(&$course){
    global $cmdb;
    if(!$course->ID) return;
    //$course_users=
    //$course->users=$course_users;
    $course_learn=$cmdb->get_results($cmdb->prepare("SELECT * FROM $cmdb->learning JOIN $cmdb->lecture_hall ON $cmdb->lecture_hall.lh_id=$cmdb->learning.lh_id WHERE $cmdb->learning.course_id=%d",$course->ID));
    print_r($course_learn);
}
?>