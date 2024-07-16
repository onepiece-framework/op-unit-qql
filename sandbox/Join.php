<?php
/** op-unit-qql:/sandbox/Join.php
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
$option = [
	'limit' => -1
];
$where = [
//	'ai' => 2,
];
//	...
$qql = ' u.ai, u.name, g.name:group, age, u.timestamp <- t_user:u.group + t_group:g.ai ';
$record = OP()->Unit()->QQL()->Get($qql, $where, $option);
OP()->Html($qql);
D($record);
