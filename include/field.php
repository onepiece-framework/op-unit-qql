<?php
/** op-unit-qql:/include/field.php
 *
 * @created    2024-07-15
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

/* @var $quote string  */
/* @var $field string  */
/* @var $pos   integer */
/* @var $parse array   */

//	t.id --> t , id
if( $pos = strpos($field, '.') ){
	$tbl = trim( substr($field, 0, $pos) );
	$fld = trim( substr($field, $pos +1) );
}

//	t.id:id
if(!$pos = strpos($fld, ':') ){
	return $quote . $tbl . $quote .'.'. $quote . $fld . $quote;
}

//	t , id:id
$tbl = $quote . $tbl . $quote;
$als = $quote . trim( substr($fld, $pos +1) ) . $quote;
$fld = $quote . trim( substr($fld, 0, $pos) ) . $quote;
return $tbl.'.'.$fld.' AS '.$als;
