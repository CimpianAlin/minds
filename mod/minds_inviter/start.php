<?php
/**
 * Minds Inviter
 *
 * @package Minds
 * @author Mark Harding
 *
 */

function minds_inviter_init(){
	
	//set a global
	global $INVITE_SERVICES;
										
	elgg_extend_view('css/elgg','minds_inviter/css');
	
	elgg_register_page_handler('invite', 'minds_inviter_page_handler');
	
	//register gmail
	minds_inviter_register_service('gmail');
	
	if (elgg_is_logged_in()) {
		$params = array(
			'name' => 'invite',
			'text' => elgg_echo('friends:invite'),
			'href' => "invite",
			'contexts' => array('friends'),
		);
		elgg_register_menu_item('page', $params);
	}
}

/**
 * @param array $page
 */
function minds_inviter_page_handler($page)
{
	$base = elgg_get_plugins_path() . 'minds_inviter/pages/minds_inviter';
	
	switch ($page[0]) {
			case 'networks':
				require_once "$base/index.php";
				break;
			case 'handler':
				set_input('provider', $page[1]);
				require_once "$base/handler.php";
				break;
			default:
				require_once "$base/index.php";
				break;
		}
	return true;
}

/**
 * Register a service handler
 */
function minds_inviter_register_service($name){
	global $INVITE_SERVICES;
	
	$INVITE_SERVICES[] = $name;
	
	return true;
}
/**
 * Retrieve service handlers
 */
function minds_inviter_retrieve_services(){
	global $INVITE_SERVICES;
	
	return $INVITE_SERVICES;
} 
 
elgg_register_event_handler('init','system','minds_inviter_init');		

?>
