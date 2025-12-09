<?php
/** op-unit-qql:/include/where.php
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

/* @var $quote string */
/* @var $where array  */

//	...
$join = [];

//	...
foreach( array_keys($where) as $key ){
	$join[] = "{$quote}{$key}{$quote} = :{$key}";
}

//	...
return join(', ', $join);
