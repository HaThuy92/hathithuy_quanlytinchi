<?php
function _fill_user(&$user){
    $userfields=array('ID', 'faculty_id', 'username', 'password', 'full_name', 'code', 'type', 'birthday', 'gender', 'email', 'address'); 
    foreach((array) array_keys($user) as $user_field){
        if(!in_array($user_field,$userfields))
            unset($user[$user_field]);
    }
}
function set_current_user($id) {
	return cm_set_current_user($id);
}
function cm_set_current_user($id) {
	global $current_user;
	if ( $current_user!=null && ($id == $current_user->ID) )
		return $current_user;
	$current_user = get_userdata($id);
	setup_userdata($current_user);
	return $current_user;
}
function cm_get_current_user(){
    global $current_user;
    get_currentuserinfo();
    return $current_user;
}
function is_user_logged_in() {
	$user = cm_get_current_user();
	if ( $user==null)
		return false;

	return true;
}
function get_currentuserinfo() {
	global $current_user;
	if ( ! empty($current_user) )
		return;

	if ( ! $user = validate_auth_cookie() ) {
		cm_set_current_user(0);
		return false;	
	}

	cm_set_current_user($user);
}
function setup_userdata($user){
    global $userdata;
	$userdata=$user;
    if($userdata!=null) {
        $faculty = get_facultydata($user->faculty_id);
        setup_facultydata($faculty);
    }
}
function get_user_by($field, $value) {
	global $cmdb;

	switch ($field) {
		case 'id':
			return get_userdata($value);
			break;
		case 'code':
			$field = 'code';
			break;
		case 'email':
			$field = 'email';
			break;
		case 'username':
			$field = 'username';
			break;
		default:
			return false;
	}
	if ( !$user = $cmdb->get_row( $cmdb->prepare("SELECT * FROM $cmdb->users WHERE $field = %s", $value) ) )
		return false;
	return $user;
}

function get_userdata( $user_id ) {
	global $cmdb;
	$user_id = absint($user_id);
	if ( $user_id == 0 )
		return false;
	if ( !$user = $cmdb->get_row($cmdb->prepare("SELECT * FROM $cmdb->users WHERE ID = %d LIMIT 1", $user_id)) )
		return false;
	return $user;
}
function get_userdatabyusername($username){
    return get_user_by('username',$username);
}
function get_userdatabycode($code){
    return get_user_by('code',$code);
}
/**
 * Check if current user is administrator
 */
function is_administrator(){
    $user = cm_get_current_user();
	if ( $user->type == 'admin' || $user->type == 'administrator')
		return true;
	return false;
}
//user infomation 'ID', 'faculty_id', 'username', 'password', 'full_name', 'code', 'type', 'birthday', 'gender', 'email', 'address'
function get_user_id(){
	global $userdata;
	return $userdata->ID;
}
function user_id(){
	echo get_user_id();
}
function get_user_facultyid(){
	global $userdata;
	return $userdata->faculty_id;
}
function user_facultyid(){
    echo get_user_facultyid();
}
function get_username(){
    global $userdata;
    return $userdata->username;
}
function username(){
    echo get_username();
}
function get_user_fullname(){
    global $userdata;
    return $userdata->full_name;
}
function user_fullname(){
    echo get_user_fullname();
}
function get_user_code(){
    global $userdata;
    return $userdata->code;
}
function user_code(){
    echo get_user_code();
}
function get_user_type(){
    global $userdata;
    return $userdata->type;
}
function user_type(){
    echo get_user_type();
}
function get_user_birthday(){
    global $userdata;
    return $userdata->birthday;
}
function user_birthday(){
    echo get_user_birthday();
}
function get_user_gender(){
    global $userdata;
    return $userdata->gender;
}
function user_gender($convert=true){
    $gender=get_user_gender();
    if($convert){
        $gender=$gender?__("nam"):__("n?");
    }
    return $gender;
}
function get_user_email(){
    global $userdata;
    return $userdata->email;
}
function user_email(){
    echo get_user_email();
}
function get_user_address(){
    global $userdata;
    return $userdata->address;
}
function user_address(){
    echo get_user_address();
}
?>