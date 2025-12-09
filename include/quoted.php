<?php
/** op-unit-qql:/include/quoted.php
 *
 * @created    2024-07-22
 * @license    Apache-2.0
 * @package    op-unit-qql
 * @copyright  (C) 2024 Tomoaki Nagahara
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP\UNIT\QQL;

/* @var $field string */

//	...
$quote = require(__DIR__.'/quote.php');

//	...
if( $pos = strpos($field, '.') ){
	$table = trim( substr($field, 0, $pos) );
	$field = trim( substr($field, $pos +1) );
	return $quote.$table.$quote.'.'.$quote.$field.$quote;
}else{
	return $quote.$field.$quote;
}
