<?php
/** op-unit-qql:/include/quote.php
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
