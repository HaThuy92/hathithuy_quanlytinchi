<?php
require_once('admin.php');
cm_reset_vars(array('action','delete_teachers','multi-delete','teacher'));
if(isset($_POST['multidelete'])){
    foreach((array)$delete_teachers as $teacher_id){
        delete_teacher($teacher_id);
        
    }
    cm_redirect(admin_url("teacher-manager.php"));
}
switch($action){
    case 'delete':
        delete_teacher($teacher_id);
        cm_redirect(admin_url("teacher-manager.php"));
    break;
    case 'edit':
        $editing=true;
        $usertype='teacher';
        set_admin_content('user-edit');
        if(false==$teacher=get_teacher_to_edit($teacher))
            cm_die("Giảng viên này không tồn tại");
        setup_userdata($teacher);
        $title=__("CCM Bảng điều khiển - Chỉnh sửa giảng viên: ".get_user_fullname());
        require_once('template-loader.php');
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
        $redirect=admin_url()."teacher.php?action=edit&teacher=$teacher";
        $cmdb->update($cmdb->users,$new_user_data,array("ID"=>$teacher,"type"=>"teacher"));
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
        $new_user_data['type']="teacher";
        $redirect=admin_url()."teacher-manager.php";
         $cmdb->insert($cmdb->users,$new_user_data);
        cm_redirect($redirect);
} 
?>