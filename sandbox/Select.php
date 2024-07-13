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
$option = [
//	'limit' => 10
];
$where = [
//	'ai' => 2,
];
$record = OP()->Unit()->QQL()->Get(' ai, name <- t_user ', $where, $option);
D($record);
