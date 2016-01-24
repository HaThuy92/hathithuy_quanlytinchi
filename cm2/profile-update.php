<?php
require('cm-load.php');
auth_redirect();
$new_user_data=$_POST;
$user_new_pass=$new_user_data['newpass'];
$user_new_pass_retype=$new_user_data['newpass_retype'];
$user_current_password=$new_user_data['password'];
_fill_user($new_user_data);
unset($new_user_data['password']);
if(cm_check_password($user_current_password)){
    if(!empty($user_new_pass)){
        if($user_new_pass==$user_new_pass_retype){
            $new_user_data['password']=md5($user_new_pass);
        }
        else
            $message="Mật khẩu mới ở hai ô phải giống nhau";
    }
        
    $cmdb->update($cmdb->users,$new_user_data,array("ID"=>get_user_id(),"type"=>"student"));
    $message="Thông tin của bạn đã được thay đổi thành công";
        
}else{
    $message="Mật khẩu hiện tại không đúng";
}
cm_redirect(site_url()."/?cm=profile&action=edit&message=".urlencode($message));
?>