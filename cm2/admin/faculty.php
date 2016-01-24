<?php
require_once('admin.php');
cm_reset_vars(array('action','delete_faculties','faculty','redirect_to'));
if(isset($_POST['multidelete'])){
    foreach((array)$delete_faculties as $faculty){
        delete_faculty($faculty);
        
    }
    cm_redirect(admin_url("faculty-edit.php"));
}
switch($action){
    case 'delete':
        delete_faculty($faculty);
        cm_redirect(admin_url("faculty-edit.php"));
    break;
    case 'edit':
        $editing=true;
        $faculty=get_faculty_to_edit($faculty);
		setup_facultydata($faculty);
		$title=__("Chỉnh sửa khoa - ").get_faculty_name();
        require_once('template-loader.php');
    break;
    case 'update':
        $new_faculty_data['name']=$_POST['faculty_name'];
        $new_faculty_data['description']=$_POST['faculty_desc'];
        $redirect=admin_url("faculty.php?action=edit&faculty=$faculty");
        $cmdb->update($cmdb->faculties,$new_faculty_data,array("faculty_id"=>$faculty));
        cm_redirect($redirect);
    break;
    case 'new':
        //$faculty=0;
        $new_faculty_data['name']=$_POST['faculty_name'];
        $new_faculty_dat['description']=$_POST['faculty_desc'];
        $cmdb->insert($cmdb->faculties,$new_faculty_data);
        if($redirect_to)$redirect=urldecode($redirect_to);
        else $redirect=admin_url("faculty-edit.php");
        cm_redirect($redirect);
} 
?>