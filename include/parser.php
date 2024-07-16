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
			$join[] = include(__DIR__.'/as.php');
		}else{
			$parse['FIELDs'][] = $field;
			$join[] = $quote . $field . $quote;
		}
	}
	$parse['FIELD'] = join(', ', $join);
}

//	Find where condition
if( $pos = strpos($qql, '= ') ){
	$evl = substr($qql, $pos-1, 2);
	$val = substr($qql, $pos+1);
	$qql = substr($qql, 0, $pos-1);
	//	Separate table and field
	if( $pos   = strpos($qql, '.') ){
		$table = substr($qql, 0, $pos);
		$field = substr($qql, $pos+1);
		//	...
		$table = trim($table);
		$field = trim($field);
		//	...
		$where[$field] = trim($val);
		$evalu[$field] = trim($evl);
	}
}else{
	$table = trim($qql);
}

//	...
$parse['TABLE'] = include(__DIR__.'/table.php');

/* @var $get bool */
if( empty($get) ){
	//	...
}else
if( $where ){
	$join = [];
	foreach( $where as $field => $value ){
		$value  = $evalu[$field] ?? '=';
		$join[] = "{$quote}{$field}{$quote} {$value} :{$field}";
	}
	$parse['WHERE'] = 'WHERE ' . join(' AND ', $join);
}

//	...
return $parse;
