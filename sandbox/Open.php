<?php
/** op-unit-qql:/sandbox/Open.php
 *
 * @created    2024-07-13
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

/* @var $QQL \OP\UNIT\QQL */
$QQL   = OP()->Unit('QQL');
$path  = 'sandbox/QQL.sqlite3';
$hash  = $QQL -> Open($path);
$error = $QQL -> Error();
D($path, $hash, $error);

//	...
return $QQL;
