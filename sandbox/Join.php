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
$record = OP()->Unit()->QQL()->Get(' t_user.ai as ai, t_user.name as name, t_group.name as group, age <- t_user.group + t_group.ai ', $where, $option);
D($record);
