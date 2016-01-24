<?php

define( 'DIR', dirname(__FILE__) . '/' );
if ( file_exists( DIR . 'cm-config.php') ) {
	require_once( DIR . 'cm-config.php' );

} else{
    echo "ERROR: Config file is missing";
}
?>