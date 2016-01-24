<?php
function cm_exit($message){
	$header='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>CCM - ERROR</title></head><body>';
	$footer='</body></html>';
	exit($header."<p>".$message."</p>".$footer);
}
function cm_redirect($location, $status = 302) {
		header("Location: $location", true, $status);
        die;
}
function cm_die($message){
    cm_exit($message);
}
function load_all_options(){
	global $cmdb;
	$_all_options=$cmdb->get_results( "SELECT option_name, option_value FROM $cmdb->options" );
    foreach ( (array) $_all_options as $o )
			$alloptions[$o->option_name] = $o->option_value;
    return $alloptions;
}
function get_option($key,$default = false){
    $value=$default;
    $all_options=load_all_options();
    if(isset($all_options[$key]))
        $value=$all_options[$key];
    return maybe_unserialize($value);
}
function add_option($name,$value){
    global $cmdb;
    if(!$name) return;
    $value = maybe_serialize( $value );
    $cmdb->query( $cmdb->prepare( "INSERT INTO `$cmdb->options` (`option_name`, `option_value`) VALUES (%s, %s) ON DUPLICATE KEY UPDATE `option_name` = VALUES(`option_name`), `option_value` = VALUES(`option_value`)", $name, $value ) );
   	return;
}
function update_option($option_name,$newvalue){
    global $cmdb;
    if(!$option_name) return false;
    if(!get_option($option_name)){
        add_option($option_name,$newvalue);
        return true;
    }
    $newvalue = maybe_serialize( $newvalue );
    $cmdb->update($cmdb->options, array('option_value' => $newvalue), array('option_name' => $option_name) );
    if($cmdb->rows_affected==1)
        return true;
    return false;
}
/**
 * Unserialize value only if it was serialized.
 *
 * @since 1.0
 *
 * @param string $original Maybe unserialized original, if is needed.
 * @return mixed Unserialized data can be any type.
 */
function maybe_unserialize( $original ) {
	if ( is_serialized( $original ) ) // don't attempt to unserialize data that wasn't serialized going in
		return @unserialize( $original );
	return $original;
}
/**
 * Serialize data, if needed.
 *
 * @since 1.0
 *
 * @param mixed $data Data that might be serialized.
 * @return mixed A scalar data
 */
function maybe_serialize( $data ) {
	if ( is_array( $data ) || is_object( $data ) )
		return serialize( $data );

	if ( is_serialized( $data ) )
		return serialize( $data );

	return $data;
}
/**
 * Check value to find if it was serialized.
 *
 * If $data is not an string, then returned value will always be false.
 * Serialized data is always a string.
 *
 * @since 1.0
 *
 * @param mixed $data Value to check to see if was serialized.
 * @return bool False if not serialized and true if it was.
 */
function is_serialized( $data ) {
	// if it isn't a string, it isn't serialized
	if ( !is_string( $data ) )
		return false;
	$data = trim( $data );
	if ( 'N;' == $data )
		return true;
	if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
		return false;
	switch ( $badions[1] ) {
		case 'a' :
		case 'O' :
		case 's' :
			if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
				return true;
			break;
		case 'b' :
		case 'i' :
		case 'd' :
			if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
				return true;
			break;
	}
	return false;
}
function cm_clone( $object ) {
	static $can_clone;
	if ( !isset( $can_clone ) ) {
		$can_clone = version_compare( phpversion(), '5.0', '>=' );
	}
	return $can_clone ? clone( $object ) : $object;
}
function require_cm_db() {
	global $cmdb;
    require_once( DIR . INC . '/cm-db.php' );
}
function build_query( $data ) {
	return _http_build_query( $data, null, '&', '', false );
}
/**
 * Retrieve a modified URL query string.
 *
 * You can rebuild the URL and append a new query variable to the URL query by
 * using this function. You can also retrieve the full URL with query data.
 *
 * Adding a single key & value or an associative array. Setting a key value to
 * emptystring removes the key. Omitting oldquery_or_uri uses the $_SERVER
 * value.
 *
 * @since 1.5.0
 *
 * @param mixed $param1 Either newkey or an associative_array
 * @param mixed $param2 Either newvalue or oldquery or uri
 * @param mixed $param3 Optional. Old query or uri
 * @return string New URL query string.
 */
function add_query_arg() {
	$ret = '';
	if ( is_array( func_get_arg(0) ) ) {
		if ( @func_num_args() < 2 || false === @func_get_arg( 1 ) )
			$uri = $_SERVER['REQUEST_URI'];
		else
			$uri = @func_get_arg( 1 );
	} else {
		if ( @func_num_args() < 3 || false === @func_get_arg( 2 ) )
			$uri = $_SERVER['REQUEST_URI'];
		else
			$uri = @func_get_arg( 2 );
	}

	if ( $frag = strstr( $uri, '#' ) )
		$uri = substr( $uri, 0, -strlen( $frag ) );
	else
		$frag = '';

	if ( preg_match( '|^https?://|i', $uri, $matches ) ) {
		$protocol = $matches[0];
		$uri = substr( $uri, strlen( $protocol ) );
	} else {
		$protocol = '';
	}

	if ( strpos( $uri, '?' ) !== false ) {
		$parts = explode( '?', $uri, 2 );
		if ( 1 == count( $parts ) ) {
			$base = '?';
			$query = $parts[0];
		} else {
			$base = $parts[0] . '?';
			$query = $parts[1];
		}
	} elseif ( !empty( $protocol ) || strpos( $uri, '=' ) === false ) {
		$base = $uri . '?';
		$query = '';
	} else {
		$base = '';
		$query = $uri;
	}

	cm_parse_str( $query, $qs );
	$qs = urlencode_deep( $qs ); // this re-URL-encodes things that were already in the query string
	if ( is_array( func_get_arg( 0 ) ) ) {
		$kayvees = func_get_arg( 0 );
		$qs = array_merge( $qs, $kayvees );
	} else {
		$qs[func_get_arg( 0 )] = func_get_arg( 1 );
	}

	foreach ( (array) $qs as $k => $v ) {
		if ( $v === false )
			unset( $qs[$k] );
	}

	$ret = build_query( $qs );
	$ret = trim( $ret, '?' );
	$ret = preg_replace( '#=(&|$)#', '$1', $ret );
	$ret = $protocol . $base . $ret . $frag;
	$ret = rtrim( $ret, '?' );
	return $ret;
}
function cm_join($user,$course){
	global $cmdb;
	$user=absint($user);
	$course=absint($course);
	if($user&&$course){
		$data=array('user_id'=>$user,'course_id'=>$course);
		$cmdb->insert($cmdb->users_join,$data);
	}
}
function cm_unjoin($user=0,$course=0){
	global $cmdb;
	$user=absint($user);
	$course=absint($course);
	if($user&&$course){
		$cmdb->query($cmdb->prepare("DELETE FROM $cmdb->users_join WHERE user_id=%d AND course_id=%d",$user,$course));
	}elseif($user){
		$cmdb->query($cmdb->prepare("DELETE FROM $cmdb->users_join WHERE user_id=%d",$user));
	}elseif($course){
		$cmdb->query($cmdb->prepare("DELETE FROM $cmdb->users_join WHERE course_id=%d",$course));
	}
}
?>