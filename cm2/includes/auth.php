<?php
function validate_auth_cookie(){
    return validate_login_cookie();
}
function validate_login_cookie(){
    
    $cookie=get_login_cookie();
    $username=$cookie['username'];
    $password=$cookie['password'];
    $expiration=$cookie['expiration'];
    $expired = $expiration;
	// Quick check to see if an honest cookie has expired
	if ( $expired < time() ) {
		return false;
	}
    $userdata=get_userdatabyusername($username);
    $user_id=$userdata->ID;
    if($userdata->password==$password&&!empty($password)){
        return $user_id;
    }
    return false; 
}
function cm_check_login($username,$password){
    global $cmdb;
    $userdata=get_userdatabyusername($username);
    if($userdata->password==md5($password)&&!empty($password)){
        return $userdata->ID;
    }
    return false;
}
function cm_check_password($password,$userid=''){
    $userid=absint($userid);
    if(!$userid)$userid=get_user_id();
    $userdata=get_userdata($userid);
    if($userdata->password==md5($password)&&!empty($password)){
        return true;
    }
    return false;
    
}
function cm_login($username,$password){
    if($user_id=cm_check_login($username,$password)){
        set_login_cookie($user_id);
        return true;
    }
    return false;        
}
function cm_logon($username,$password,$remember){
    if($user_id=cm_check_login($username,$password)){
        set_login_cookie($user_id,$remember);
        return true;
    }
    return false; 
}
function cm_logout(){
    clear_login_cookie();    
}
function get_login_cookie(){
    if(empty($_COOKIE['LOGIN']))
        return false;
    $cookie=$_COOKIE['LOGIN'];
    $cookie_elements = explode('|', $cookie);
	if ( count($cookie_elements) != 3 )
		return false;
    return array('username'=>$cookie_elements[0],'password'=>$cookie_elements[1],'expiration'=>$cookie_elements[2]);
}
function set_login_cookie($user_id, $remember = false){
    if ( $remember ) {
		$expiration = $expire = time() +  1209600;
	} else {
		$expiration = time() +  172800;
        $expire = 0;
	}
    $login_cookie=generate_login_cookie($user_id,$expiration);
    setcookie('LOGIN',$login_cookie,$expire);
}
function clear_login_cookie(){
    setcookie('LOGIN','', time() - 31536000);
    setcookie('LOGIN','', time() - 31536000,"/cm/admin");
}
function generate_login_cookie($user_id,$expiration){
    $user=get_userdata($user_id);
    $cookie=$user->username.'|'.$user->password.'|'.$expiration;
    return $cookie;
    
}
function auth_redirect(){
    if($user_id=validate_login_cookie()){
        return;
    }
    $redirect=current_url();
    $login_url=get_option('siteurl').'/login.php?redirect_to='.urlencode($redirect);
    cm_redirect($login_url);
}
function current_url(){
	$url="http://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	return $url;
}
?>