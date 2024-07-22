<?php
/** op-unit-qql:/include/quote_field.php
 *
 * @created    2024-07-22
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

/* @var $field string */

//	...
$field = trim($field);
$pos = strpos($field, '(');
$agg = substr($field, 0, $pos);
$quoted = self::Quote( substr($field, $pos+1, -1) );
return $agg.'('.$quoted.')';
