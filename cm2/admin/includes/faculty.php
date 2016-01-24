<?php
function _get_faculties($offset,$limit){
    global $cmdb;
    $all_faculties=$cmdb->get_results($cmdb->prepare("SELECT * from $cmdb->faculties LIMIT %d,%d",$offset,$limit));
    return $all_faculties;
}
function get_faculty_to_edit($faculty_id){
    global $cmdb;
    $faculty=$cmdb->get_row($cmdb->prepare("SELECT * from $cmdb->faculties WHERE faculty_id=%d LIMIT 1",$faculty_id));
    return $faculty;
}
function _get_num_faculty(){
    global $cmdb;
    $faculties=$cmdb->get_row("SELECT count( ID ) AS num_faculty FROM $cmdb->faculties");
    return $faculties;
}
function delete_faculty($faculty_id){
    global $cmdb;
    return $cmdb->query($cmdb->prepare("DELETE FROM $cmdb->faculties WHERE faculty_id=%d",$faculty_id));
}


function edit_faculty_link(){
    return admin_url("faculty.php?action=edit&faculty=".get_faculty_id());
    
}
function delete_faculty_link(){
    return admin_url("faculty.php?action=delete&faculty=".get_faculty_id());
    
}
function editfacultylink(){
    echo edit_faculty_link();
}
function deletefacultylink(){
    echo delete_faculty_link();
}
?>