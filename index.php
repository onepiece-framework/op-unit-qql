<?php
/** op-unit-qql:/index.php
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

/** Include
 *
 */
require_once(__DIR__.'/QQL.class.php');

//	For CI
if( Env::isCI() ){
	//	...
	$file = 'QQL.sqlite3';
	$path = OP()->MetaPath("asset:/db/ci/{$file}");
	//	...
	if(!file_exists( $path ) ){
		copy(__DIR__.'/'.$file, $path);
	}
}
