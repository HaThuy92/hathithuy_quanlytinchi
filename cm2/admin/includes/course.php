<?php
function _get_num_course(){
	return count(cm_get_courses());
}
function _get_courses($offset = 0, $limit = 0, $key = '', $field = '')
{
    global $cmdb;
    $search = "";
    if ($key)
    {
        $key = strip_tags($key);
        //$key=remove_accents($key);
        $key = str_replace(" ", '%', $key);
        $key = esc_sql($key);
        $search = " AND ($field LIKE '%$key%')";
    }
    if ($offset || $limit)
    {
        $limit = "LIMIT $offset,$limit";
        $limit = esc_sql($limit);
    } else
        $limit = '';
    $all_courses = $cmdb->get_results("SELECT * from $cmdb->courses Where 1 $search $limit");
    return $all_courses;
}
function cm_get_courses($offset = 0, $limit = 0, $key = "", $fields = array()){
    if (!$key &&isset( $_GET['s']))
        $key = $_GET['s'];
    if (!$fields)
        $fields = array("name");
    foreach ($fields as $field)
    {
        if ($all_courses = _get_courses($offset, $limit , $key, $field))
            break;
    }
    return $all_courses;
}
function get_course_to_edit($course_id){
    global $cmdb;
    $course=get_coursedata($course_id);
    //_fill_course($course);
    return $course;
}
function _get_course_users($course_id,$user_type,$offset=0,$limit=0){
    global $cmdb;
    $offset=absint($offset);
    $limit=absint($limit);
    if($limit)$limits="LIMIT $offset,$limit";
    $users=$cmdb->get_results($cmdb->prepare(
        "SELECT * FROM $cmdb->users_join join $cmdb->users on $cmdb->users_join.user_id=$cmdb->users.ID
            Where $cmdb->users.type=%s AND $cmdb->users_join.course_id=%d $limit",$user_type,$course_id));
    return $users;
}
function _get_course_students($course_id,$offset,$limit){
    return _get_course_users($course_id,'student',$offset,$limit);
}
function _get_course_teachers($course_id){
    return _get_course_users($course_id,'teacher');
}
function delete_course($course){
	global $cmdb;
    cm_unjoin(0,$course);
	return $cmdb->query($cmdb->prepare("DELETE FROM $cmdb->courses WHERE ID=%d",$course));
}
function course_pagelink(){
    global $page,$limit;
    $total_couses=_get_num_course();
    $total_page=ceil($total_couses/$limit);
    $add_args='';
	if (isset($_GET["s"]))
    {
        $add_args = array('s' => urlencode($_GET["s"]));
    }
    $link_template=array(
        'base' => 'course-edit.php%_%', // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
		'format' => '?page=%#%', // ?page=%#% : %#% is replaced by the page number
		'total' => $total_page,
		'current' => $page,
		'add_args' => $add_args,
    );
    echo paginate_links($link_template);
}
function edit_course_link(){
    $url=admin_url("course.php?action=edit&course=".get_course_id());
    return $url;
}
function editcourselink(){
    echo edit_course_link();
}
function delete_course_link(){
    $url=admin_url("course.php?action=delete&course=".get_course_id());
    return $url;
}
function deletecourselink(){
    echo delete_course_link();
}
function course_list_select($current=0, $input_name, $input_id)
{
    echo "<select name=\"$input_name\" id=\"$input_id\">";
    $all_courses = _get_courses();
    foreach ($all_courses as $course)
    {
        setup_coursedata($course);
        echo '<option ' . is_selected(get_course_id() == $current) . ' value="' .
            get_course_id() . '">' . get_course_name() . '</option>';
    }
    echo "</select>";
}
//(`ID`, `faculty_id`, `cc_id`, `name`, `description`, `max_student`, `num_credit`, `join_open`, `join_close`)
function strip_course_data(&$course){
    $course_fields=array('ID', 'faculty_id', 'cc_id', 'name', 'description', 'max_student', 'num_credit', 'join_open', 'join_close');
    foreach((array) array_keys($course) as $course_field){
        if(!in_array($course_field,$course_fields))
            unset($course[$course_field]);
    }
}
?>