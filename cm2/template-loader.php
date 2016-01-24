<?php
if(is_profile()&&$template=get_profile_template()){
    include($template);
    return;
}else if(is_course()&&$template=get_course_template()){
    include($template);
    return;
}
include(TEMPLATEPATH.'/index.php')
?>