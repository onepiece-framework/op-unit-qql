<?php
/** op-unit-qql:/include/quote.php
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
switch( self::$_PDOs[ self::$_hash ] -> getAttribute(\PDO::ATTR_DRIVER_NAME) ){

	case 'mysql':
		$quote = '`';
		break;

	case 'sqlite':
		$quote = '"';
		break;

	default:
}

//	...
return $quote ?? '';
