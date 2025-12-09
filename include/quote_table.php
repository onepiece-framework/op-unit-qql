<?php
/** op-unit-qql:/include/quote_table.php
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
$pos   = strpos($field, ':');
$table = trim( substr($field, 0, $pos) );
$field = trim( substr($field, $pos +1) );
$table = self::Quote( $table );
$field = self::Quote( $field );
return $table.' AS '.$field;
