<?php
function cm(){
    if(is_administrator()){
        cm_redirect(admin_url());
    }
}
cm_get_current_user();
?>