<?php
/** op-unit-qql:/sandbox/Update.php
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

//	...
if(!$table = OP()->Request('table') ){
	D('table is empty.');
	return;
}

//	...
if(!$ai = (int)OP()->Request('ai') ){
	D('ai is empty.');
	return;
}

//	...
if(!$name = OP()->Request('name') ){
	D('name is empty.');
	return;
}

//	...
include('Open.php');

//	...
$set = [
	'name' => $name,
];

//	...
$where = [
	'ai' => $ai,
];

//	...
$ai = OP()->Unit()->QQL()->Set($table, $set, $where);
D($ai);
