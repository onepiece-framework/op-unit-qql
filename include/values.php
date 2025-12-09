<?php
/** op-unit-qql:/include/values.php
 *
 * @created    2024-07-13
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

/* @var $fields array  */

//	...
$join = [];

//	...
foreach( $fields as $field ){
	$join[] = ':' . $field;
}

//	...
return join(', ', $join);
