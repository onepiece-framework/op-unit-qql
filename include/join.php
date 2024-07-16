<?php
/** op-unit-qql:/include/join.php
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

/* @var $quote string */
/* @var $table string */

//	...
$ON = [];
foreach( explode('+', $table) as $temp ){
	//	...
	$temp = trim($temp);

	//	t_table:t.id --> t_table:t , id
	list($tbl, $fld) = explode('.', $temp);

	//	t_table:t --> t_table , t
	if( $pos = strpos($tbl, ':') ){
		$als = substr($tbl, $pos +1);
		$tbl = substr($tbl, 0, $pos);
		//	"t_table" AS "t"
		$tbl = $quote . trim($tbl) . $quote . ' AS ' . $quote . trim($als) . $quote;
	}else{
		$tbl = $quote . trim($tbl) . $quote;
	}

	//	field
	$fld = $quote . trim($fld) . $quote;

	//	t_table:t , id --> "t_table:t"."id"
	$on = $quote . $als . $quote .'.'. $fld;

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
		$FROM .= ' LEFT JOIN ' . trim($tbl);
		$FROM .= ' ON ' . $ON[0] .' = '. $ON[1];
		//	Dispose joined table
		array_shift($ON);
	}
}
unset($temp, $tbl, $fld, $on, $ON);

//	...
return $FROM;
