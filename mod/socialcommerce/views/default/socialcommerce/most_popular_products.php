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
 * Elgg view - most popular products
 * 
 * @package Elgg SocialCommerce
 * @author Cubet Technologies
 * @copyright Cubet Technologies 2009-2010
 * @link http://elgghub.com
 */ 
	 
global $CONFIG;
$most_rateds = get_purchased_orders('final_value','','object','rating','','',true,'','DESC',500,0);
if($most_rateds){
	$products_list = "";
	$i = 0;
	foreach ($most_rateds as $most_rated){
		if($i == 16){
			break;
		}
		$most_rated = get_entity($most_rated->guid);
		$product = get_entity($most_rated->product_guid);
		if($product){
				$product_path = $product->getURL();
				$mime = $product->mimetype;
				$product_img = elgg_view("{$CONFIG->pluginname}/image", array(
										'entity' => $product,
										'size' => 'medium',
										'display'=>'image'
									  )
								);
				if($i%8 == 0){
					$products_list .= "</tr><tr>";
				}
				$products_list .= <<<EOF
					<td>
						<div id="popular_products_list_{$product->guid}" class="popular_products_list">
							<a onmouseover="popular_products_list_mouseover_action($product->guid)" onmouseout="popular_products_list_mouseout_action($product->guid)" href="{$product_path}">
								$product_img
							</a>
						</div>
					</td>
EOF;
			$i++;
		}
	}
	$most_popular_text = elgg_echo('most:popular:products');
	echo $cart_body = <<<EOF
		<script>
			function popular_products_list_mouseover_action(product_guid){
				$("#popular_products_list_"+product_guid).fadeTo("fast", 1); 
				$("#popular_products_list_"+product_guid+" img").css("width","42px");
				$("#popular_products_list_"+product_guid+" img").css("border","1px solid #e89005");
				$("#popular_products_list_"+product_guid+" img").css("padding","1px");
			}
			function popular_products_list_mouseout_action(product_guid){
				$("#popular_products_list_"+product_guid).fadeTo("fast", 0.8); 
				$("#popular_products_list_"+product_guid+" img").css("width","45px");
				$("#popular_products_list_"+product_guid+" img").css("border","none");
				$("#popular_products_list_"+product_guid+" img").css("padding","0");
			}
		</script>
		<div class="index_box">
			<h2>{$most_popular_text}</h2>
			<div class="contentWrapper">
				<table class="popular_products_list_table">
					<tr>
						{$products_list}
					</tr>
				</table>
				<div style="clear:both;"></div>
			</div>
		</div>
EOF;
}
?>