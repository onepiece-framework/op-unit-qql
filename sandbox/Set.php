<?php
/** op-unit-qql:/sandbox/Set.php
 *
 * @created    2024-07-15
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

//	...
include('Open.php');

//	...
$set = [
	'name'  => 'test',
	'group' => 1,
	'age'   => 1,
];
$ai = OP()->Unit()->QQL()->Set(' t_user ', $set);
D($ai);
