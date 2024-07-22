<?php
/** op-unit-qql:/include/option_page.php
 *
 * @created    2024-07-23
 * @version    1.0
 * @package    op-unit-qql
 * @author     Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP\UNIT\QQL;

/* @var $option array  */

//	limit
if( empty($option['limit']) ){
	//	NG
	OP()->Notice("This limit number is not a positive integer. `{$option['limit']}`");
	$option['limit'] = 1;
}

//	1 or -1
if( $option['limit'] <= 1 ){
	//	Convert
	$option['limit'] = 10;
}

//	page
if( $page = $option['page'] ){
	//	Check page number.
	if( is_int($page) and $page >= 1 ){
		$option['offset'] = ($page-1) * $option['limit'];
	}else{
		OP()->Notice("This page number is not a positive integer. `{$page}`");
	}
}
