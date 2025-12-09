<?php
/** op-unit-qql:/include/join.php
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

/* @var $quote string */
/* @var $table string */

//	...
$ON = [];
$JOIN = $LEFT = $RIGHT = null;
foreach( explode('+', $table) as $temp ){
	//	...
	$temp = trim($temp);

	//	...
	$JOIN = include(__DIR__.'/join_calc.php');

	//	t_table:t.id --> t_table:t , id
	list($tbl, $fld) = explode('.', $temp);

	//	t_table:t --> t_table , t
	if( $pos = strpos($tbl, ':') ){
		$als = substr($tbl, $pos +1);
		$tbl = substr($tbl, 0, $pos);
		//	"t_table" AS "t"
		$als = $quote . trim($als) . $quote;
		$tbl = $quote . trim($tbl) . $quote . ' AS ' . $als;
	}else{
		$tbl = $quote . trim($tbl) . $quote;
		$als = $tbl;
	}

	//	field
	$fld = $quote . trim($fld) . $quote;

	//	"t"."id"
	$on = $als .'.'. $fld;

	//	...
	if(!$ON ){
		//	1st table
		$FROM = $tbl;
		//	Stack 1st table
		$ON[] = $on;
	}else{
		//	Stack next join
		$ON[]  = $on;
		//	JOIN
		$FROM .= " {$JOIN} JOIN " . trim($tbl);
		$FROM .= ' ON ' . $ON[0] .' = '. $ON[1];
		//	Dispose joined table
		array_shift($ON);
	}
}
unset($temp, $tbl, $fld, $on, $ON, $JOIN, $LEFT, $RIGHT);

//	...
return $FROM;
