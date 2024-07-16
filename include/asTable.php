<?php
/** op-unit-qql:/include/asTable.php
 *
 * @created    2024-07-16
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
