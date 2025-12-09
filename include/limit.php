<?php
/** op-unit-qql:/include/limit.php
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

/* @var $option array  */

if( $limit = $option['limit'] ?? null ){
	$LIMIT = 'LIMIT ' . $limit;
}

//	...
return $LIMIT ?? '';
