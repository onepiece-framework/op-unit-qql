<?php
/** op-unit-qql:/include/asTable.php
 *
 * @created    2024-07-16
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

/* @var $quote string */
/* @var $table string */
/* @var $parse array  */

//	...
$pos = strpos($table, ':');
$lef = trim( substr($table, 0, $pos) );
$rig = trim( substr($table, $pos +1) );

//	...
if( $pos = strpos($rig, '.') ){
	$rig = substr($rig, 0, $pos);
}

//	...
return $quote.$lef.$quote.' AS '.$quote.$rig.$quote;
