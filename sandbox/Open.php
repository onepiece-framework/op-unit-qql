<?php
/** op-unit-qql:/sandbox/Open.php
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
$path  = 'sandbox/QQL.sqlite3';
$hash  = OP()->Unit()->QQL()->Open($path);
$error = OP()->Unit()->QQL()->Error();
D($path, $hash, $error);
