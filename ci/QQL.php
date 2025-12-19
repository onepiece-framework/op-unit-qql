<?php
/**	op-unit-qql:/ci/QQL.php
 *
 * @created     2023-01-30
 * @license     Apache-2.0
 * @package     op-unit-qql
 * @copyright   (C) 2023 Tomoaki Nagahara
 */

/**	Declare strict
 *
 */
declare(strict_types=1);

/**	Namespace
 *
 */
namespace OP;

//	For CI
if( OP()->isCI() ){
	//	...
	$file = 'QQL.sqlite3';
	$path = OP()->Path("asset:/db/ci/{$file}");
	//	...
	if(!file_exists( $path ) ){
		if(!file_exists($dir = OP()->Path("asset:/db"   ))){ mkdir($dir); }
		if(!file_exists($dir = OP()->Path("asset:/db/ci"))){ mkdir($dir); }
		copy(OP()->Path("asset:/unit/qql/{$file}"), $path);
	}
}

//	Get PHP version
$php = PHP_MAJOR_VERSION.PHP_MINOR_VERSION;

/* @var $ci UNIT\CI\CI_Config */
$ci = OP::Unit('CI')::Config();

//	Template
$method = 'Template';
$arg1   = 'foo';
$arg2   = 'bar';
$args   = ['ci.phtml',['arg1'=>$arg1, 'arg2'=>$arg2]];
$result = $arg1 . $arg2;
$ci->Set($method, $result, $args);

/* @var $qql \OP\UNIT\QQL */
$qql = OP()->Unit('QQL');

//	...
$path = 'ci/QQL.sqlite3';
$hash = $qql->Open( $path );
foreach($qql->Get(' sqlite_sequence ', [], ['limit'=>-1]) as $record){
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
	'ai'        => $php == 80 ? "$user_ai"   : $user_ai,
	'name'      => $php == 80 ? "$user_name" : $user_name,
	'group'     => $php == 80 ? "$group_ai"  : $group_ai,
	'age'       => $php == 80 ? "2"          : 2,
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
	'ai'        => $php == 80 ?  "1" : 1,
	'name'      => 'OP',
	'group'     => $php == 80 ?  "1" : 1,
	'age'       => $php == 80 ?  "1" : 1,
	'timestamp' => '2024-07-15 00:00:00',
];
$ci->Set($method, $result, $args);

//	TABLE JOIN - Not specify field - Separate where
$method = 'Get';
$qql    = " t_user.group + t_group.ai ";
$where  = ' t_user.ai = 1 ';
$option = [];
$args   = [$qql, $where, $option];
//	$result = [];
$ci->Set($method, $result, $args);

//	TABLE JOIN - Specify field with alias name
$method = 'Get';
$qql    = " u.ai, u.name, g.name:group <- t_user:u.group + t_group:g.ai ";
$where  = ' u.ai = 1 ';
$option = [];
$args   = [$qql, $where, $option];
$result = [
	'ai'        => $php == 80 ? "1" : 1,
	'name'      => 'CI',
	'group'     => 'OP',
];
$ci->Set($method, $result, $args);

//	TABLE RIGHT JOIN
$method = 'Get';
$qql    = " t_user.group +> t_group.ai ";
$where  = ' t_user.ai = 1 ';
$option = [];
$args   = [$qql, $where, $option];
$result = [
	'ai'        => $php == 80 ? "1" : 1,
	'name'      => 'OP',
	'group'     => $php == 80 ? "1" : 1,
	'age'       => $php == 80 ? "1" : 1,
	'timestamp' => '2024-07-15 00:00:00',
];
$ci->Set($method, $result, $args);

//	TABLE INNER JOIN
$method = 'Get';
$qql    = " t_user.group >+< t_group.ai ";
$option = [];
$args   = [$qql, $where, $option];
//	$result = [];
$ci->Set($method, $result, $args);

//	TABLE LEFT OUTER JOIN
$method = 'Get';
$qql    = " t_user.group <+< t_group.ai ";
$option = [];
$args   = [$qql, $where, $option];
//	$result = [];
$ci->Set($method, $result, $args);

//	TABLE RIGHT OUTER JOIN
$method = 'Get';
$qql    = " t_user.group >+> t_group.ai ";
$option = [];
$args   = [$qql, $where, $option];
//	$result = [];
$ci->Set($method, $result, $args);

//	GROUP BY
$method = 'Get';
$where  = [];
$option = [
	'group' => 'group',
];
$args   = [' count(*) <- t_user ', $where, $option];
$result = ['count("*")' => ($php == 80) ? "1" : 1 ];
$ci->Set($method, $result, $args);

//	...
$method = 'Display';
$args   = "t_user.ai = 1";
if( $php == 80 ){
	$result = '<div class="qql records">[{"ai":"1","name":"CI","group":"1","age":"1","timestamp":"2024-07-25 09:00:00"}]</div>';
}else{
	$result = '<div class="qql records">[{"ai":1,"name":"CI","group":1,"age":1,"timestamp":"2024-07-25 09:00:00"}]</div>';
}
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
