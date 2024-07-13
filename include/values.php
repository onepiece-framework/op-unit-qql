<?php
/** op-unit-qql:/include/values.php
 *
 * @created    2024-07-13
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

/* @var $fields array  */

//	...
$join = [];

//	...
foreach( $fields as $field ){
	$join[] = ':' . $field;
}

//	...
return join(', ', $join);
