<?php
function _make_url_clickable_cb($matches) {
	$url = $matches[2];

	$url = esc_url($url);
	if ( empty($url) )
		return $matches[0];

	return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>";
}

/**
 * Callback to convert URL match to HTML A element.
 *
 * This function was backported from 2.5.0 to 2.3.2. Regex callback for {@link
 * make_clickable()}.
 *
 * @since 2.3.2
 * @access private
 *
 * @param array $matches Single Regex Match.
 * @return string HTML A element with URL address.
 */
function _make_web_ftp_clickable_cb($matches) {
	$ret = '';
	$dest = $matches[2];
	$dest = 'http://' . $dest;
	$dest = esc_url($dest);
	if ( empty($dest) )
		return $matches[0];

	// removed trailing [.,;:)] from URL
	if ( in_array( substr($dest, -1), array('.', ',', ';', ':', ')') ) === true ) {
		$ret = substr($dest, -1);
		$dest = substr($dest, 0, strlen($dest)-1);
	}
	return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>$ret";
}

/**
 * Callback to convert email address match to HTML A element.
 *
 * This function was backported from 2.5.0 to 2.3.2. Regex callback for {@link
 * make_clickable()}.
 *
 * @since 2.3.2
 * @access private
 *
 * @param array $matches Single Regex Match.
 * @return string HTML A element with email address.
 */
function _make_email_clickable_cb($matches) {
	$email = $matches[2] . '@' . $matches[3];
	return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
}
function make_clickable($ret) {
	$ret = ' ' . $ret;
	// in testing, using arrays here was found to be faster
	$ret = preg_replace_callback('#(?<=[\s>])(\()?([\w]+?://(?:[\w\\x80-\\xff\#$%&~/=?@\[\](+-]|[.,;:](?![\s<]|(\))?([\s]|$))|(?(1)\)(?![\s<.,;:]|$)|\)))+)#is', '_make_url_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]+)#is', '_make_web_ftp_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', '_make_email_clickable_cb', $ret);
	// this one is not in an array because we need it to run last, for cleanup of accidental links within links
	$ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
	$ret = trim($ret);
	return $ret;
}
function _strip_all_tags($string, $remove_breaks = false) {
	$string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
	$string = strip_tags($string);

	if ( $remove_breaks )
		$string = preg_replace('/[\r\n\t ]+/', ' ', $string);

	return trim($string);
}
function strip_all_tags($string, $remove_breaks = false) {
	return _strip_all_tags($string, $remove_breaks);
}
function sanitize_user( $username, $strict = false ) {
	$username = _strip_all_tags($username);
	// Kill octets
	$username = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $username);
	$username = preg_replace('/&.+?;/', '', $username); // Kill entities

	// If strict, reduce to ASCII for max portability.
	if ( $strict )
		$username = preg_replace('|[^a-z0-9 _.\-@]|i', '', $username);

	// Consolidate contiguous whitespace
	$username = preg_replace('|\s+|', ' ', $username);
	return $username;
}
function esc_sql( $sql ) {
	global $cmdb;
	return $cmdb->escape( $sql );
}
function absint( $maybeint ) {
	return abs( intval( $maybeint ) );
}

/**
 * Navigates through an array and removes slashes from the values.
 *
 * If an array is passed, the array_map() function causes a callback to pass the
 * value back to the function. The slashes from this value will removed.
 *
 * @since 2.0.0
 *
 * @param array|string $value The array or string to be striped.
 * @return array|string Stripped array (or string in the callback).
 */
function stripslashes_deep($value) {
	$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
	return $value;
}
/**
 * Parses a string into variables to be stored in an array.
 *
 * Uses {@link http://www.php.net/parse_str parse_str()} and stripslashes if
 * {@link http://www.php.net/magic_quotes magic_quotes_gpc} is on.
 *
 *
 * @param string $string The string to be parsed.
 * @param array $array Variables will be stored in this array.
 */
function cm_parse_str( $string, &$array ) {
	parse_str( $string, $array );
	if ( get_magic_quotes_gpc() )
		$array = stripslashes_deep( $array );
}

/**
 * Merge user defined arguments into defaults array.
 *
 * This function is used to allow for both string or array
 * to be merged into another array.
 *
 *
 * @param string|array $args Value to merge with $defaults
 * @param array $defaults Array that serves as the defaults.
 * @return array Merged user defined values with defaults.
 */
function cm_parse_args( $args, $defaults = '' ) {
	if ( is_object( $args ) )
		$r = get_object_vars( $args );
	elseif ( is_array( $args ) )
		$r =& $args;
	else
		cm_parse_str( $args, $r );

	if ( is_array( $defaults ) )
		return array_merge( $defaults, $r );
	return $r;
}
function urlencode_deep($value) {
	$value = is_array($value) ? array_map('urlencode_deep', $value) : urlencode($value);
	return $value;
}
function esc_url( $url, $protocols = null ) {
	return clean_url( $url, $protocols, 'display' );
}
function clean_url( $url, $protocols = null, $context = 'display' ) {
	$original_url = $url;

	if ('' == $url) return $url;
	$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	$strip = array('%0d', '%0a', '%0D', '%0A');
    
	$url = _deep_replace($strip, $url);
    
	$url = str_replace(';//', '://', $url);
	/* If the URL doesn't appear to contain a scheme, we
	 * presume it needs http:// appended (unless a relative
	 * link starting with / or a php file).
	 */
	if ( strpos($url, ':') === false &&
		substr( $url, 0, 1 ) != '/' && substr( $url, 0, 1 ) != '#' && !preg_match('/^[a-z0-9-]+?\.php/i', $url) )
		$url = 'http://' . $url;

	// Replace ampersands and single quotes only when displaying.
	if ( 'display' == $context ) {
		$url = preg_replace('/&([^#])(?![a-z]{2,8};)/', '&#038;$1', $url);
		$url = str_replace( "'", '&#039;', $url );
	}


	return $url;
}
function _deep_replace($search, $subject){
	$found = true;
	while($found) {
		$found = false;
		foreach( (array) $search as $val ) {
			while(strpos($subject, $val) !== false) {
				$found = true;
				$subject = str_replace($val, '', $subject);
			}
		}
	}

	return $subject;
}
function remove_accents($string) {
	$trans = array(
		'à'=>'a','á'=>'a','?'=>'a','?'=>'a','?'=>'a',
		'ã'=>'a','?'=>'a','?'=>'a','?'=>'a','?'=>'a','?'=>'a',
		'â'=>'a','?'=>'a','?'=>'a','?'=>'a','?'=>'a','?'=>'a',
		'À'=>'a','Á'=>'a','?'=>'a','?'=>'a','?'=>'a',
		'Ã'=>'a','?'=>'a','?'=>'a','?'=>'a','?'=>'a','?'=>'a',
		'Â'=>'a','?'=>'a','?'=>'a','?'=>'a','?'=>'a','?'=>'a',    
		'ð'=>'d','Ð'=>'d',
		'è'=>'e','é'=>'e','?'=>'e','?'=>'e','?'=>'e',
		'ê'=>'e','?'=>'e','?'=>'e','?'=>'e','?'=>'e','?'=>'e',
		'È'=>'e','É'=>'e','?'=>'e','?'=>'e','?'=>'e',
		'Ê'=>'e','?'=>'e','?'=>'e','?'=>'e','?'=>'e','?'=>'e',
		'?'=>'i','í'=>'i','?'=>'i','?'=>'i','?'=>'i',
		'?'=>'i','Í'=>'i','?'=>'i','?'=>'i','?'=>'i',
		'?'=>'o','ó'=>'o','?'=>'o','?'=>'o','?'=>'o',
		'ô'=>'o','?'=>'o','?'=>'o','?'=>'o','?'=>'o','?'=>'o',
		'õ'=>'o','?'=>'o','?'=>'o','?'=>'o','?'=>'o','?'=>'o',
		'?'=>'o','Ó'=>'o','?'=>'o','?'=>'o','?'=>'o',
		'Ô'=>'o','?'=>'o','?'=>'o','?'=>'o','?'=>'o','?'=>'o',
		'Õ'=>'o','?'=>'o','?'=>'o','?'=>'o','?'=>'o','?'=>'o',
		'ù'=>'u','ú'=>'u','?'=>'u','?'=>'u','?'=>'u',
		'ý'=>'u','?'=>'u','?'=>'u','?'=>'u','?'=>'u','?'=>'u',
		'Ù'=>'u','Ú'=>'u','?'=>'u','?'=>'u','?'=>'u',
		'Ý'=>'u','?'=>'u','?'=>'u','?'=>'u','?'=>'u','?'=>'u',
		'?'=>'y','?'=>'y','?'=>'y','?'=>'y','?'=>'y',
		'Y'=>'y','?'=>'y','?'=>'y','?'=>'y','?'=>'y','?'=>'y'
	);
	return strtr($string, $trans);
}
?>