<?php
/** op-unit-qql:/sandbox/Select.php
 *
 * @created    2024-07-14
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
$qql = ' t_user ';
$record = OP()->Unit()->QQL()->Get($qql, [], ['limit'=>-1]);
OP()->Html($qql);
D($record);

//	...
$qql = ' t_group ';
$record = OP()->Unit()->QQL()->Get($qql, [], ['limit'=>-1]);
OP()->Html($qql);
D($record);
