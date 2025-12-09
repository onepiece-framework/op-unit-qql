<?php
/** op-unit-qql:/sandbox/Get.php
 *
 * @created    2024-07-15
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

//	...
include('Open.php');

//	...
if( $table = OP()->Request('table') ){
	$qql = $table;
}else{
	D('Empty table.');
	return;
}

//	...
if(!$field = OP()->Request('field') ){
	D('Empty field.');
}else
if(!$value = OP()->Request('value') ){
	D('Empty value.');
}else{
	//	...
	$qql = " {$table}.{$field} = {$value} ";
}

//	...
$record = OP()->Unit()->QQL()->Get($qql, [], ['limit'=>-1]);
D($record);
