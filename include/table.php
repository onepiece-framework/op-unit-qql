<?php
/** op-unit-qql:/include/table.php
 *
 * @created    2024-07-13
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

/* @var $qql   string */
/* @var $quote string */

//	...
$table = trim($qql);

//	t_user.group + t_group.id = 1
if( strpos($table, '+') ){
	return include(__DIR__.'/join.php');
}else
//	t_user:u
if( strpos($table, ':') ){
	return include(__DIR__.'/asTable.php');
}else
//	t_table.id = 1 --> t_table.id --> "t_table"
if( $pos = strpos($table, '.') ){
	$tbl = substr($table, 0, $pos);
	return $quote . trim($tbl) . $quote;
}

//	...
return $quote . $table . $quote;
