<?php
/**	op-unit-qql:/include/DsnArray.php
 *
 * @created    2025-02-02
 * @license    Apache-2.0
 * @package    op-unit-qql
 * @copyright  Tomoaki Nagahara
 */

/**	Declare strict type
 *
 */
declare(strict_types=1);

/**	Namespace
 *
 */
namespace OP\UNIT\QQL;

/* @var $config array */

//	...
$driver  = $config['driver']  ?? $config['scheme']   ?? $config['prod'] ?? null;
$host    = $config['host']    ?? $config['hostname'] ?? null;
$dbname  = $config['dbname']  ?? $config['database'] ?? null;
$charset = $config['charset'] ?? 'utf8mb4';
$path    = $config['path']    ?? null;
$socket  = $config['socket']  ?? $config['unix_socket'] ?? null;

//	...
if( empty($config['username']) and isset($config['user']) ){
	$config['username'] = $config['user'];
}
if( empty($config['password']) and isset($config['pass']) ){
	$config['password'] = $config['pass'];
}

//	...
if( $host ){
	$host = "host={$host};";
}

//	...
if( $dbname ){
	$dbname = "dbname={$dbname};";
}

//	...
if( $socket ){
	$socket = "unix_socket={$socket}";
}

//	...
return "{$driver}:{$socket}{$host}{$dbname}{$path}charset={$charset}";
