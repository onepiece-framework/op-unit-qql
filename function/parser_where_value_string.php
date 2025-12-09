<?php
/** op-unit-qql:/include/parse_where_value_string.php
 *
 * @created    2024-07-21
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

/** parse where value of string
 *
 */
function parser_where_value_string(string $where) : array
{
	//	...
	$where = trim($where);

	//	...
	if(!$pos = strpos($where, ' ') ){
		OP()->Notice("QQL format error: `{$where}`");
		return [];
	}

	//	...
	$field = trim( substr($where, 0, $pos) );
	$where = trim( substr($where, $pos +1) );

	//	...
	if(!$pos = strpos($where, ' ') ){
		OP()->Notice("QQL format error: `{$where}`");
		return [];
	}

	//	...
	$evalu = trim( substr($where, 0, $pos) );
	$value = trim( substr($where, $pos +1) );

	//	...
	return [$field, $evalu, $value];
}
