<?php
/** op-unit-qql:/sandbox/Insert.php
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
echo ' [ <a href="?table=t_user" >t_user</a>';
echo ' | <a href="?table=t_group">t_group</a> ] ';

//	...
if(!$table = OP()->Request('table') ){
	D('table is empty.');
	return;
}

//	...
if( $name = OP()->Request('name') ){
	$set['name'] = $name;
}
if( $group = OP()->Request('group') ){
	$set['group'] = $group;
}
if( $age = OP()->Request('age') ){
	$set['age'] = $age;
}

//	...
if( empty($set) ){
	include_once('Open.php');
	D( OP()->Unit()->QQL()->Get(" $table ") );
	OP()->Html('Update value is empty. ex: name, group, age');
	return;
}

//	...
include_once('Open.php');

//	...
D( OP()->Unit()->QQL()->Set($table, ['name'=>$name]) );
D( OP()->Unit()->QQL()->Get($table, [], ['limit'=>-1]) );
