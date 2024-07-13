<?php
/** op-unit-qql:/include/set.php
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


/* @var $quote string */
/* @var $set   array  */

//	...
$join = [];

//	...
foreach( array_keys($set) as $key ){
	$join[] = "{$quote}{$key}{$quote} = :{$key}";
}

//	...
return join(', ', $join);
