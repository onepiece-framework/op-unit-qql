<?php
/** op-unit-qql:/include/DsnString.php
 *
 * @created    2024-07-15
 * @license    Apache-2.0
 * @package    op-unit-qql
 * @copyright  (C) 2024 Tomoaki Nagahara
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP\UNIT\QQL;

/* @var $dsn string */

//	...
$root = OP()->MetaPath('asset:/db/');
$path = $root . $dsn;

//	...
if(!file_exists($path) ){
	throw new \Exception("The database file does not exist: `$path`");
}

//	...
return 'sqlite:' . $path;
