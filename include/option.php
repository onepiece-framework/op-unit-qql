<?php
/** op-unit-qql:/include/option.php
 *
 * @created    2024-07-13
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

//	...
$OPTION = '';

//	...
if( empty($option['limit']) ){
	$option['limit'] = 1;
}

//	...
if( 0 < $limit = $option['limit'] ){
	$OPTION = 'LIMIT ' . $limit;
}

//	...
return $OPTION;
