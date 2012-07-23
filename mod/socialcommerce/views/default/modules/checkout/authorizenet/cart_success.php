<?php
	/*****************************************************************************\
	+-----------------------------------------------------------------------------+
	| Elgg Socialcommerce Plugin                                                  |
	| Copyright (c) 2009-20010 Cubet Technologies <socialcommerce@cubettech.com>  |
	| All rights reserved.                                                        |
	+-----------------------------------------------------------------------------+
	| PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT" |
	| FILE PROVIDED WITH THIS DISTRIBUTION. THE AGREEMENT TEXT IS ALSO AVAILABLE  |
	| AT THE FOLLOWING URL: http://socialcommerce.elgg.in/license.html            |
	|                                                                             |
	| THIS  AGREEMENT  EXPRESSES  THE  TERMS  AND CONDITIONS ON WHICH YOU MAY USE |
	| THIS  SOFTWARE   PROGRAM  AND   ASSOCIATED   DOCUMENTATION    THAT  CUBET   |
	| TECHNOLOGIES (hereinafter referred as "THE AUTHOR") IS FURNISHING OR MAKING |
	| AVAILABLE TO YOU WITH  THIS  AGREEMENT  (COLLECTIVELY,  THE  "SOFTWARE").   |
	| PLEASE   REVIEW   THE  TERMS  AND   CONDITIONS  OF  THIS  LICENSE AGREEMENT |
	| CAREFULLY   BEFORE   INSTALLING   OR  USING  THE  SOFTWARE.  BY INSTALLING, |
	| COPYING   OR   OTHERWISE   USING   THE   SOFTWARE,  YOU  AND  YOUR  COMPANY |
	| (COLLECTIVELY,  "YOU")  ARE  ACCEPTING  AND AGREEING  TO  THE TERMS OF THIS |
	| LICENSE   AGREEMENT.   IF  YOU    ARE  NOT  WILLING   TO  BE  BOUND BY THIS |
	| AGREEMENT, DO  NOT INSTALL OR USE THE SOFTWARE.  VARIOUS   COPYRIGHTS   AND |
	| OTHER   INTELLECTUAL   PROPERTY   RIGHTS    PROTECT   THE   SOFTWARE.  THIS |
	| AGREEMENT IS A LICENSE AGREEMENT THAT GIVES  YOU  LIMITED  RIGHTS   TO  USE |
	| THE  SOFTWARE   AND  NOT  AN  AGREEMENT  FOR SALE OR FOR  TRANSFER OF TITLE.|
	| THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY GRANTED BY THIS AGREEMENT.      |
	|                                                                             |
	+-----------------------------------------------------------------------------+
	\*****************************************************************************/
	
	/**
	 * Elgg checkout - Authorize.net - success page
	 * 
	 * @package Elgg SocialCommerce
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com
	 */ 
	 
	global $CONFIG;
	gatekeeper();
	// Get objects

		if(isset($_SESSION['CHECKOUT'])){
			$method = $_SESSION['CHECKOUT']['checkout_method'];
			// For checking the cart updating or not
			$cart_sucess_load =get_input('cart_sucess_load');

				$body = elgg_echo('cart:success:authorizecontent');
                $body .= "<br>".elgg_echo('approval:code')."".$_SESSION['approval_code'];
                $body .= "<br>".elgg_echo('transaction:id')."".$_SESSION['transaction_id'];
                $body .= "<br>".$_SESSION['responese_text'];
                
				$action = $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/{$_SESSION['user']->username}/all";
				$button = elgg_view('input/submit', array('name' => 'btn_submit', 'value' => elgg_echo('checkout:back:text')));
				$area2 = <<< AREA2
					<br>{$body}<br><br>
					<form action="$action" method="post">
						{$button}
					</form>
AREA2;

			echo $area2;
			unset($_SESSION['CHECKOUT']);
            unset($_SESSION['approval_code']);
            unset($_SESSION['transaction_id']);
            unset($_SESSION['responese_text']);
		}else{
			forward($CONFIG->wwwroot."pg/".$CONFIG->pluginname."/".$_SESSION['user']->username."/all");
		}
?>