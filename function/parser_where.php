<?php
/** op-unit-qql:/include/parse_where.php
 *
 * @created    2024-07-21
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

/** Parse where
 *
 */
function parser_where( & $where, $quote)
{
	//	...
	$join = [];

	//	...
	foreach( $where as $field => $value ){
		//	Is array ? or assoc ?
		if( is_int($field) ){
			//	array
			require_once(__DIR__.'/../function/parser_where_value_string.php');
			list($field, $evalu, $value) = parser_where_value_string($value);
		}else{
			//	assoc
			$evalu = '=';
		}

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
		$join[] = "{$joint} {$evalu} :{$field}";

		//	...
		$alias[$field] = $value;
	}

	//	...
	$where = $alias;

	//	...
	return 'WHERE ' . join(' AND ', $join);
}
