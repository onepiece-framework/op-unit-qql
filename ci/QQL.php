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
return $ci->Get();
