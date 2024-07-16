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
$group = OP()->Request('group');
$user  = OP()->Request('user');
$age   = OP()->Request('age');
if(!$user ){
	D('Empty user.');
	return;
}

//	Search
if( $record = OP()->Unit()->QQL()->Get(" t_user.name = {$user} ") ){
	//	...
	D('Already exist.', $record);
	//	...
	if(!$age ){
		D('Empty age.');
		return;
	}
	//	...
	$set = [];
	$set['age'] = $age;
	if( $group ){
		$set['group'] = OP()->Unit()->QQL()->Get(" ai <- t_group.name = {$group} ");
	}
	$number = OP()->Unit()->QQL()->Set(" t_user.name = {$user} ", $set);
	$record = OP()->Unit()->QQL()->Get(" t_user.name = {$user} ");
	D('Update', $number, $age, $record);
}else{
	// New insert record.
	D("New insert record", $user, $group);
	if(!$group ){
		D('Empty group.');
		return;
	}
	//	...
	if(!$ai = OP()->Unit()->QQL()->Get(" ai <- t_group.name = {$group} ") ){
		$ai = OP()->Unit()->QQL()->Set('t_group', ['name'=>$group]);
	}
	D("{$ai} ← t_group.name = {$group} ");
	//	...
	$set = [
		'name'  => $user,
		'group' => $ai,
	];
	$ai = OP()->Unit()->QQL()->Set("t_user", $set);
	D('New insert ID', $ai);
}
