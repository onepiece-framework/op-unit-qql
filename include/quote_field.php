<?php
/** op-unit-qql:/include/quote_field.php
 *
 * @created    2024-07-22
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

/* @var $field string */

//	...
$field = trim($field);
$pos = strpos($field, '(');
$agg = substr($field, 0, $pos);
$quoted = self::Quote( substr($field, $pos+1, -1) );
return $agg.'('.$quoted.')';
