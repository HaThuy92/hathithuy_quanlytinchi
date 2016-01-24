<?php
require_once('admin.php');
cm_reset_vars(array('action','delete_lh','lh','redirect_to'));
if(isset($_POST['multidelete'])){
    foreach((array)$delete_lh as $lh){
        delete_lh($lh);
        
    }
    cm_redirect(admin_url("lecture-edit.php"));
}
switch($action){
    case 'delete':
        delete_lh($lh);
        cm_redirect(admin_url("lecture-edit.php"));
    break;
    case 'edit':
        $editing=true;
        $lh=get_lh_to_edit($lh);
		setup_lhdata($lh);
		$title=__("Chỉnh sửa giảng đường - ").get_lh_name();
        require_once('template-loader.php');
    break;
    case 'update':
        $new_lh_data['name']=strip_all_tags($_POST['lh_name']);
        $new_lh_data['address']=strip_all_tags($_POST['lh_address']);
        $redirect=admin_url("lecture-hall.php?action=edit&lh=$lh");
        $cmdb->update($cmdb->lecture_hall,$new_lh_data,array("lh_id"=>$lh));
        cm_redirect($redirect);
    break;
    case 'new':
        //$lh=0;
        $new_lh_data['name']=strip_all_tags($_POST['lh_name']);
        $new_lh_data['address']=strip_all_tags($_POST['lh_address']);
        $cmdb->insert($cmdb->lecture_hall,$new_lh_data);
        if($redirect_to)$redirect=urldecode($redirect_to);
        else $redirect=admin_url("lecture-edit.php");
        cm_redirect($redirect);
} 
?>