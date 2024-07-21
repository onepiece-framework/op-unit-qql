<?php
/** op-unit-qql:/ci/QQL.php
 *
 * @created     2023-01-30
 * @version     1.0
 * @package     op-unit-qql
 * @author      Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright   Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP;

/* @var $ci UNIT\CI\CI_Config */
$ci = OP::Unit('CI')::Config();

//	Template
$method = 'Template';
$arg1   = 'foo';
$arg2   = 'bar';
$args   = ['ci.phtml',['arg1'=>$arg1, 'arg2'=>$arg2]];
$result = $arg1 . $arg2;
$ci->Set($method, $result, $args);

//	...
$path = 'ci/QQL.sqlite3';
$hash = OP()->Unit()->QQL()->Open( $path );
foreach( OP()->Unit()->QQL()->Get(' sqlite_sequence ', [], ['limit'=>-1]) as $record ){
	$sequence[$record['name']] = $record['seq'];
}

//	...
$method = 'Open';
$args   = $path;
$result = $hash;
$ci->Set($method, $result, $args);

//	...
$method = 'Close';
$args   = $hash;
$result =  null;
$ci->Set($method, $result, $args);

//	...
$method = 'Set';
$group_ai = $sequence['t_group'] +1;
$set = [
	'name' => 'group_'.$group_ai,
];
$args   = ['t_group', $set];
$result = $group_ai;
$ci->Set($method, $result, $args);

//	...
$method = 'Insert';
$user_ai   = $sequence['t_user'] +1;
$user_name = 'user_'.$user_ai;
$set = [
	'name'  => $user_name,
	'group' => $group_ai,
	'age'   => 1,
];
$args   = ['t_user', $set];
$result = $user_ai;
$ci->Set($method, $result, $args);

//	...
$method = 'Update';
$set = [
	'age' => 2,
];
$where = [
	'ai' => $user_ai,
];
$args   = ['t_user', $set, $where];
$result =  1;
$ci->Set($method, $result, $args);

//	...
$method = 'Get';
$args   = "t_user.ai = {$user_ai}";
$result = [
	'ai'        => $user_ai,
	'name'      => $user_name,
	'group'     => $group_ai,
	'age'       => 2,
	'timestamp' => gmdate(_OP_DATE_TIME_),
];
$ci->Set($method, $result, $args);

//	TABLE JOIN - Not specify field
$method = 'Get';
$qql    = " t_user.group + t_group.ai = 1 ";
$where  = [];
$option = [];
$args   = [$qql, $where, $option];
$result = [
	'ai'        =>  1,
	'name'      => 'ci',
	'group'     =>  1,
	'age'       =>  1,
	'timestamp' => null,
];
$ci->Set($method, $result, $args);

//	TABLE JOIN - Not specify field - Separate where
$method = 'Get';
$qql    = " t_user.group + t_group.ai ";
$where  = ' t_user.ai = 1 ';
$option = [];
$args   = [$qql, $where, $option];
$result = [
	'ai'        =>  1,
	'name'      => 'ci',
	'group'     =>  1,
	'age'       =>  1,
	'timestamp' => null,
];
$ci->Set($method, $result, $args);

//	TABLE JOIN - Specify field with alias name
$method = 'Get';
$qql    = " u.ai, u.name, g.name:group <- t_user:u.group + t_group:g.ai ";
$where  = ' u.ai = 1 ';
$option = [];
$args   = [$qql, $where, $option];
$result = [
	'ai'        =>  1,
	'name'      => 'user',
	'group'     => 'ci',
];
$ci->Set($method, $result, $args);

//	TABLE RIGHT JOIN
$method = 'Get';
$qql    = " t_user.group +> t_group.ai ";
$where  = ' t_user.ai = 1 ';
$option = [];
$args   = [$qql, $where, $option];
$result = [
	'ai'        =>  1,
	'name'      => 'ci',
	'group'     =>  1,
	'age'       =>  1,
	'timestamp' => null,
];
$ci->Set($method, $result, $args);

//	TABLE INNER JOIN
$method = 'Get';
$qql    = " t_user.group >+< t_group.ai ";
$option = [];
$args   = [$qql, $where, $option];
$result = [
	'ai'        =>  1,
	'name'      => 'ci',
	'group'     =>  1,
	'age'       =>  1,
	'timestamp' => null,
];
$ci->Set($method, $result, $args);

//	TABLE LEFT OUTER JOIN
$method = 'Get';
$qql    = " t_user.group <+< t_group.ai ";
$option = [];
$args   = [$qql, $where, $option];
$result = [
	'ai'        =>  1,
	'name'      => 'ci',
	'group'     =>  1,
	'age'       =>  1,
	'timestamp' => null,
];
$ci->Set($method, $result, $args);

//	TABLE RIGHT OUTER JOIN
$method = 'Get';
$qql    = " t_user.group >+> t_group.ai ";
$option = [];
$args   = [$qql, $where, $option];
$result = [
	'ai'        =>  1,
	'name'      => 'ci',
	'group'     =>  1,
	'age'       =>  1,
	'timestamp' => null,
];
$ci->Set($method, $result, $args);

//	...
$method = 'Display';
$args   = "t_user.ai = 1";
$result = '<div class="qql records">[{"ai":1,"name":"user","group":1,"age":1,"timestamp":"2024-07-15 00:00:00"}]</div>';
$ci->Set($method, $result, $args);

//	...
$method = '_Error';
$args   =  new \PDOException();
$result =  null;
$ci->Set($method, $result, $args);

//	...
$method = 'Error';
$args   =  null;
$result = '';
$ci->Set($method, $result, $args);

//	...
$method = 'Debug';
$args   =  null;
$result =  null;
$ci->Set($method, $result, $args);

//	...
$method = 'Quote';
$args   = 't_table:t.id';
$result = '"t_table" AS "t"."id"';
$ci->Set($method, $result, $args);

//	...
return $ci->Get();
