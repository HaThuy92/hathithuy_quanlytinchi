<?php
function cm_reset_vars( $vars ) {
	for ( $i=0; $i<count( $vars ); $i += 1 ) {
		$var = $vars[$i];
		global $$var;

		if (!isset( $$var ) ) {
			if ( empty( $_POST["$var"] ) ) {
				if ( empty( $_GET["$var"] ) )
					$$var = '';
				else
					$$var = $_GET["$var"];
			} else {
				$$var = $_POST["$var"];
			}
		}
	}
}
function show_message($message) {
	echo "<p>$message</p>\n";
}
if(!function_exists('is_checked')){
	function is_checked($show_or_not) {
		if ($show_or_not == 1) return 'checked';
		else return '';
	}
}
if(!function_exists('is_selected')){
	function is_selected($show_or_not) {
		if ($show_or_not == 1) return 'selected';
		else return '';
	}
}
function set_admin_content($page){
    global $current_admin_page;
    $current_admin_page=$page;
}

?>