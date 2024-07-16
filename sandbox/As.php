<?php
/** op-unit-qql:/sandbox/Get.php
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
$qql = " t_user:u ";
$record = OP()->Unit()->QQL()->Get($qql);
OP()->Html($qql);
D($record);

//	...
$qql = " t_user:u.ai = 1 ";
$record = OP()->Unit()->QQL()->Get($qql);
OP()->Html($qql);
D($record);

//	...
$qql = " name <- t_user:u.ai = 1 ";
$record = OP()->Unit()->QQL()->Get($qql);
OP()->Html($qql);
OP()->Html($record);

//	...
$qql = " t_user:u.group + t_group:g.ai = 1";
$record = OP()->Unit()->QQL()->Get($qql);
OP()->Html($qql);
D($record);

//	...
$qql = " u.ai:ai, u.name:name, g.name:group, u.timestamp:t <- t_user:u.group + t_group:g.ai = 1";
$record = OP()->Unit()->QQL()->Get($qql, [], ['limit'=>-1]);
OP()->Html($qql);
D($record);
