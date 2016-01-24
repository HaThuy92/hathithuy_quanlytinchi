<?php
require_once('admin.php');
cm_reset_vars(array('action','delete_students','multi-delete','student','student_course'));
if($_POST['multidelete']){
    foreach((array)$delete_students as $student){
        delete_student($student);
        
    }
    cm_redirect(admin_url("student-manager.php"));
}
switch($action){
    case 'delete':
        delete_student($student);
        cm_redirect(admin_url("student-manager.php"));
    break;
    case 'edit':
        $editing=true;
        $usertype='student';
        set_admin_content('user-edit');
        $student=get_student_to_edit($student);
		setup_userdata($student);

    break;
    case 'update':
        $new_user_data=$_POST;
        $user_new_pass=$new_user_data['password'];
        _fill_user($new_user_data);
        if(empty($user_new_pass)){
            unset($new_user_data['password']);
        }else{
            $new_user_data['password']=md5($user_new_pass);
        }
        $redirect=admin_url()."student.php?action=edit&student=$student";
        $cmdb->update($cmdb->users,$new_user_data,array("ID"=>$student,"type"=>"student"));
        cm_redirect($redirect);
    break;
    case 'new':
        $new_user_data=$_POST;
        $user_new_pass=$new_user_data['password'];
        _fill_user($new_user_data);
        if(empty($user_new_pass)){
            $message="Mật khẩu không được để trống";
        }else{
            $new_user_data['password']=md5($user_new_pass);
        }
        $new_user_data['type']="student";
        $redirect=admin_url()."student-manager.php";
        //print_r($new_user_data);
         $cmdb->insert($cmdb->users,$new_user_data);
        cm_redirect($redirect);
        break;
    case 'addcourse':
        cm_join($student,$student_course);
        $redirect=admin_url()."student.php?action=edit&student=$student";
        cm_redirect($redirect);
        break;
    case 'rmcourse':
        cm_unjoin($student,$student_course);
        $redirect=admin_url()."student.php?action=edit&student=$student";
        cm_redirect($redirect);
        break;
        
}
        require_once('template-loader.php');
?>