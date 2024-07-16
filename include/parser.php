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
if( $pos = strpos($qql, '=') ){
	$evl = substr($qql, $pos-1, 2);
	$val = substr($qql, $pos+1);
	$qql = substr($qql, 0, $pos-1);

	//	Search target field.
	if( $pos = strrpos($qql, ':') ){
		//	found
	}else if( $pos = strrpos($qql, '.') ){
		//	found
	}
	if( $pos ){
		$field = substr($qql, $pos +1);
		$field = trim($field);
		$where[$field] = trim($val);
		$evalu[$field] = trim($evl);
	}
}

//	...
$parse['TABLE'] = include(__DIR__.'/table.php');

//	...
if( $where ){
	$join = [];
	foreach( $where as $field => $value ){
		//	...
		$field = trim($field);
		//	...
		if( strpos($field, '.') ){
			$temp  = explode('.', $field);
			$field = $temp[0].'_'.$temp[1];
			$joint = $quote.$temp[0].$quote.'.'.$quote.$temp[1].$quote;
		}else{
			$joint = $quote.$field.$quote;
		}
		//	...
		$veval  = $evalu[$field] ?? '=';
		//	...
		$join[] = "{$joint} {$veval} :{$field}";
		//	...
		$alias[$field] = $value;
	}
	//	...
	$parse['WHERE'] = 'WHERE ' . join(' AND ', $join);
	//	...
	$where = $alias;
}

//	...
unset($pos, $fld, $field, $evl, $val, $evalu, $alias, $temp, $joint, $alias);

//	...
return $parse;
