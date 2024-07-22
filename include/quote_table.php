<?php
/** op-unit-qql:/include/quote_table.php
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
$pos   = strpos($field, ':');
$table = trim( substr($field, 0, $pos) );
$field = trim( substr($field, $pos +1) );
$table = self::Quote( $table );
$field = self::Quote( $field );
return $table.' AS '.$field;
