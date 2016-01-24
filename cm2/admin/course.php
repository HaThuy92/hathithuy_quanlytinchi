<?php
require_once('admin.php');
cm_reset_vars(array('action','delete_courses','course','page'));
if(isset($_POST['multidelete'])){
    foreach((array)$delete_courses as $course){
        delete_course($course);  
    }cm_redirect(admin_url("course-edit.php"));
    
}
switch($action){
    case 'delete':
        delete_course($course);
        cm_redirect(admin_url("course-edit.php"));
    case 'view-students':
        set_admin_content('course-members');
        $page=absint($page);
        if(!$page)$page=1;
        $limit=get_option('student_per_page')?get_option('student_per_page'):15;
        $offset=($page-1)*$limit;
        setup_coursedata($course);
        $all_students=_get_course_students($course,$offset,$limit);
        $all_teachers=_get_course_teachers($course);
        break;
    case 'edit':
        $editing=true;
        $course_teachers=_get_course_teachers($course);
        $course_teacher=$course_teachers[0];
        $course=get_course_to_edit($course);
        setup_coursedata($course);
        break;
    case 'update':
        $new_course_data=$new_course=$_POST;
        $new_teacher['user_id']=$new_course_data['course_teacher'];
        strip_course_data($new_course_data);
        $cmdb->update($cmdb->courses,$new_course_data,array('ID'=>$course)); 
        if(!$cmdb->update($cmdb->users_join,$new_teacher,array('course_id'=>$course)))
            $cmdb->insert($cmdb->users_join,array('user_id'=>$new_course['course_teacher'],'course_id'=>$course));
        cm_redirect(admin_url("course.php?action=edit&course=".$course));
    case 'new':
        $new_course_data=$_POST;
        $course_teacher['user_id']=$new_course_data['course_teacher'];
        strip_course_data($new_course_data);
        $cmdb->insert($cmdb->courses,$new_course_data);
        $course_id=$cmdb->get_var("select ID from $cmdb->courses order by ID DESC limit 1");
        $course_teacher['course_id']=$course_id;
        $cmdb->insert($cmdb->users_join,$course_teacher);
        cm_redirect(admin_url("course-edit.php"));
        break;
}
require_once('template-loader.php');
