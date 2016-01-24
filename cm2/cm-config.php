<?php
/** The name of the database for CCM */
define('DB_NAME', 'cm2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('SAVEQUERIES', true);

$table_prefix  = '';


define ('CMLANG', 'en');




if ( !defined('DIR') )
	define('DIR', dirname(__FILE__) . '/');


require_once(DIR . 'cm-common.php');
?>