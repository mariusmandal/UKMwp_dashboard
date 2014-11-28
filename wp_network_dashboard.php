<?php
/* ****************************************************************
Omkring linje 14 i wp-admin/network/index.php skal require dashboard
 kommenteres ut, og påfølgende linje legges til:
-------------
/* Load WordPress dashboard API 
#require_once(ABSPATH . 'wp-admin/includes/dashboard.php');
require_once(ABSPATH . 'wp-content/plugins/UKMNorge/wp_network_dashboard.php');
-------------
*******************************************************************
*/

require_once('UKM/inc/twig-admin.inc.php');
require_once('UKM/monstring.class.php');
require_once(dirname(__FILE__).'/wp_dashboard_functions.php');

require(ABSPATH . 'wp-admin/admin-header.php');

$TWIGdata = array();
$TWIGdata['plugin_path'] = plugin_dir_url( __FILE__ ).'/';
$TWIGdata['base_path'] = 'http://'. UKM_HOSTNAME .'/';

error_reporting(E_ALL);
ini_set('display_errors',true);


require_once('controller/network/innhold_tema.controller.php');
require_once('controller/network/innhold_sites.controller.php');
require_once('controller/network/support.controller.php');

/*
	$MESSAGES = array();
$MESSAGES = apply_filters('UKMWPDASH_messages', $MESSAGES);

foreach($MESSAGES as $key => $MESSAGE) {
	if($MESSAGE['level'] == 'alert-error')
		$MESSAGES[$key]['level'] = 'alert-danger';
}
*/

#require_once(dirname(__FILE__).'/controller/news.controller.php');

echo TWIG('network/dashboard.twig.html', $TWIGdata, dirname(__FILE__));


require(ABSPATH . 'wp-admin/admin-footer.php');
die();