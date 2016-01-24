<?php
function get_facultydata($faculty_id){
   	global $cmdb;
	$faculty_id = absint($faculty_id);
	if ( $faculty_id == 0 )
		return false;
	if ( !$faculty = $cmdb->get_row($cmdb->prepare("SELECT * FROM $cmdb->faculties WHERE faculty_id = %d LIMIT 1", $faculty_id)) )
		return false;
	return $faculty;
}
function get_all_faculties(){
    global $cmdb;
    $faculties=$cmdb->get_results("SELECT * FROM $cmdb->faculties");
    return $faculties;
}
function get_faculty_name(){
    global $facultydata;
    return $facultydata->name;
}
function get_faculty_id(){
    global $facultydata;
    return $facultydata->faculty_id;
}
function get_faculty_desc($html=true){
    global $facultydata;
    $desc=$facultydata->description;
    if(!$html) $desc=htmlspecialchars($desc);
    return $desc;
}
function faculty_name(){
    echo get_faculty_name();
}
function faculty_id(){
    echo get_faculty_id();
}
function faculty_desc($html=true){
    echo get_faculty_desc($html);
}
function setup_facultydata($faculty){
	global $facultydata;
	$facultydata=$faculty;
}

?>