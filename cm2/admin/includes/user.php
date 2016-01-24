<?php

function get_student_to_edit($id)
{
    $student = get_userdata($id);
    if ($student->type != 'student')
        return false;
    return $student;
}
function get_teacher_to_edit($id)
{
    $teacher = get_userdata($id);
    if ($teacher->type != 'teacher')
        return false;
    return $teacher;
}
function delete_user($id)
{
    global $cmdb;
    return $cmdb->query($cmdb->prepare("DELETE FROM $cmdb->users WHERE ID=%d", $id));
}
function delete_student($id)
{
    $student = get_userdata($id);
    if ($student->type != 'student')
        return false;
    delete_user($id);
}
function delete_teacher($id)
{
    $teacher = get_userdata($id);
    if ($teacher->type != 'teacher')
        return false;
    delete_user($id);
}
function _get_students($offset = 0, $limit = 0, $key = '', $field = '')
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
        $limit = "LIMIT"+ $offset+ $limit;
        $limit = esc_sql($limit);
    } else
        $limit = '';
    $all_teachers = $cmdb->get_results("SELECT * from $cmdb->users join $cmdb->faculties on $cmdb->users.faculty_id=$cmdb->faculties.faculty_id where type='student' $search $limit");
    return $all_teachers;
}
function cm_get_students($offset = 0, $limit = 0, $key = "", $fields = array())
{

    global $cmdb;
    if (!$key && isset($_GET['s']))
        $key = $_GET['s'];
    if (!$fields)
        $fields = array("$cmdb->users.full_name", "$cmdb->users.address", "$cmdb->users.code",
            "$cmdb->users.birthday", "$cmdb->faculties.name");
    foreach ($fields as $field)
    {
        if ($all_teachers = _get_students($offset , $limit , $key, $field))
            break;
    }
    return $all_teachers;

}
function _get_teachers($offset = 0, $limit = 0, $key = "", $field = 'full_name')
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
    //echo $search;
    if ($offset || $limit)
    {
        $limit = "LIMIT $offset,$limit";
        $limit = esc_sql($limit);
    } else
        $limit = '';

    $all_teachers = $cmdb->get_results("SELECT * from $cmdb->users join $cmdb->faculties on $cmdb->users.faculty_id=$cmdb->faculties.faculty_id where type='teacher' $search $limit");
    //print_r($all_teachers);
    return $all_teachers;
}
function cm_get_teachers($offset = 0, $limit = 0, $key = "", $fields = array())
{
    global $cmdb;
    if (!$key && isset($_GET['s']))
        $key = $_GET['s'];
    if (!$fields)
        $fields = array("$cmdb->users.full_name", "$cmdb->users.address", "$cmdb->users.code",
            "$cmdb->users.birthday", "$cmdb->faculties.name");
    foreach ($fields as $field)
    {
        if ($all_teachers = _get_teachers($offset, $limit, $key, $field))
            break;
    }
    return $all_teachers;

}
function _get_num_student()
{
    return count(cm_get_students());
}
function _get_num_teacher()
{
    return count(cm_get_teachers());
}
function edit_student_link()
{
    return admin_url() . "student.php?action=edit&student=" . get_user_id();
}
function editstudentlink()
{
    echo edit_student_link();
}
function delete_student_link()
{
    return admin_url() . "student.php?action=delete&student=" . get_user_id();
}
function deletestudentlink()
{
    echo delete_student_link();
}
function edit_teacher_link()
{
    return admin_url() . "teacher.php?action=edit&teacher=" . get_user_id();
}
function editteacherlink()
{
    echo edit_teacher_link();
}
function delete_teacher_link()
{
    return admin_url() . "teacher.php?action=delete&teacher=" . get_user_id();
}
function deleteteacherlink()
{
    echo delete_teacher_link();
}
function _mkuser($user_data)
{
    if (!is_array($user_data))
        return false;
    _fill_user($user_data);
    $user_object = object;
    foreach ($user_data as $field => $value)
    {
        $user_object->$field = $value;
    }
    return $user_object;
}
function teacher_pagelink()
{
    global $page, $limit;
    $total_teacher = _get_num_teacher();
    $total_page = ceil($total_teacher / $limit);
    $add_args='';
    if (isset($_GET["s"]))
    {
        $add_args = array('s' => urlencode($_GET["s"]));
    }
    $link_template = array('base' => 'teacher-manager.php%_%',
        // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
        'format' => '?page=%#%', // ?page=%#% : %#% is replaced by the page number
        'total' => $total_page, 'current' => $page, 'add_args' => $add_args, );

    echo paginate_links($link_template);
}
function student_pagelink()
{
    global $page, $limit;
    $total_teacher = _get_num_student();
    $total_page = ceil($total_teacher / $limit);
    $add_args='';
    if (isset($_GET["s"]))
    {
        $add_args = array('s' => urlencode($_GET["s"]));
    }
    $link_template = array('base' => 'student-manager.php%_%',
        // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
        'format' => '?page=%#%', // ?page=%#% : %#% is replaced by the page number
        'total' => $total_page, 'current' => $page, 'add_args' => $add_args, );
    echo paginate_links($link_template);
}
function student_list_select($current, $input_name, $input_id)
{
    echo "<select name=\"$input_name\" id=\"$input_id\">";
    $all_students = _get_students();
    foreach ($all_students as $student)
    {
        setup_userdata($student);
        echo '<option ' . is_selected(get_user_id() == $current) . ' value="' .
            get_user_id() . '">' . get_user_fullname() . '</option>';
    }
    echo "</select>";
}

function teacher_list_select($current, $input_name = 'teacher', $input_id =
    'teacher')
{
    echo "<select name=\"$input_name\" id=\"$input_id\">";
    $all_teachers = _get_teachers();
    foreach ($all_teachers as $teacher)
    {
        setup_userdata($teacher);
        echo '<option ' . is_selected(get_user_id() == $current) . ' value="' .
            get_user_id() . '">' . get_user_fullname() . '</option>';
    }
    echo "</select>";
}

?>