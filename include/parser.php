<?php
/** op-unit-qql:/include/parse.php
 *
 * @created    2024-07-14
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
/* @var $where array  */
/* @var $qql   string */

$qql = trim($qql);

//	...
$parse = [
	'TABLE'  => '',
	'FIELD'  => '*',
	'WHERE'  => '',
	'OPTION' => '',
];

//	Separate field
if( $pos = strpos($qql, '<-') ){
	$fld = substr($qql, 0, $pos);
	$qql = substr($qql, $pos+2);
	//	...
	$join = [];
	foreach( explode(',', $fld) as $field ){
		//	...
		$field = trim($field);
		//	...
		if( $pos = strpos($field, ' as ') ){
			$join[] = include(__DIR__.'/asField.php');
		}else
		if( $pos = strpos($field, '.') ){
			$join[] = include(__DIR__.'/field.php');
		}else{
			$parse['FIELDs'][] = $field;
			$join[] = $quote . $field . $quote;
		}
	}
	$parse['FIELD'] = join(', ', $join);
}

//	Find where condition
if( $po1 = strpos($qql, '=') ){
	//	Search target field.
	if( $pos = strrpos($qql, ':', -(strlen($qql)-$po1)) ){
		//	found
	}else{
		$pos = strrpos($qql, '.', -(strlen($qql)-$po1));
	}

	//	Not Found
	if( $pos === false ){
		OP()->Notice("QQL format error: `{$qql}`");
	}

	//	...
	$qql = ' '.$qql;
	$pos = strrpos($qql, ' ',  -(strlen($qql)-$pos));
	$where[] = substr($qql, $pos +1);
	$qql = trim( substr($qql, 0, $po1) );
}

//	...
$parse['TABLE'] = include(__DIR__.'/table.php');

//	...
if( $where ){
	//	...
	require_once(__DIR__.'/../function/parser_where.php');
	$parse['WHERE'] = parser_where($where, $quote);
}

//	...
unset($pos, $fld, $field);

//	...
return $parse;
