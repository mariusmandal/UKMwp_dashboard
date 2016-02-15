<?php
/* ****************************************************************
Omkring linje 12 i wp-admin/index.php skal require dashboard
 kommenteres ut, og påfølgende linje legges til:
-------------
/* Load WordPress dashboard API 
#require_once(ABSPATH . 'wp-admin/includes/dashboard.php');
require_once(ABSPATH . 'wp-content/plugins/UKMNorge/wp_dashboard.php');
-------------
*******************************************************************
*/
global $current_user;

update_user_option($current_user->ID, 'admin_color', 'light', true);

require_once('UKM/inc/twig-admin.inc.php');
require_once('UKM/monstring.class.php');
require_once(dirname(__FILE__).'/wp_dashboard_functions.php');

require(ABSPATH . 'wp-admin/admin-header.php');

/* SHORTCUTS */
$SHORTCUTS = array();
$SHORTCUTS = apply_filters('UKMWPDASH_shortcuts', $SHORTCUTS);

/* MESSAGES */
$MESSAGES = array();
$MESSAGES = apply_filters('UKMWPDASH_messages', $MESSAGES);
foreach($MESSAGES as $key => $MESSAGE) {
	if($MESSAGE['level'] == 'alert-error')
		$MESSAGES[$key]['level'] = 'alert-danger';
}

/* KALENDER */
$KALENDER = array();
$KALENDER = apply_filters('UKMWPDASH_calendar', $KALENDER);

/* STATISTIKK */
require_once('UKM/monstring.class.php');
$pl = new monstring( get_option('pl_id' ) );
$stat = $pl->statistikk();										  
$STATISTIKK = $stat->getTotal($pl->get('season'));

$TWIGdata = array('site_type' => get_option('site_type'),
				  'kontakter' => UKMWP_kontakter(),
				  'messages'  => $MESSAGES,
				  'block_pre_messages' => array(), // PUTT HTML her for å vise på topp av startsiden
				  'shortcuts' => $SHORTCUTS,
				  'kalender' => $KALENDER,
				  'statistikk' => $STATISTIKK,
				  'kommune' => $TWIG['statistikk_detaljert'],
				  );
/* NEWS */
$POST_QUERY = 'cat=-2,-74';
require_once(dirname(__FILE__).'/controller/news.controller.php');



$TWIGdata = apply_filters('UKMwp_dashboard_load_controllers', $TWIGdata);

echo TWIG('dashboard.twig.html', $TWIGdata, dirname(__FILE__));

require(ABSPATH . 'wp-admin/admin-footer.php');
die();