<?php
/** op-unit-qql:/QQL.class.php
 *
 * @created    2024-07-12
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
namespace OP\UNIT;

/** use
 *
 */
use OP\IF_UNIT;
use OP\OP_CORE;
use OP\OP_CI;
use OP\IF_QQL;

/** QQL
 *
 * @created    2024-07-12
 * @version    1.0
 * @package    op-unit-qql
 * @author     Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright  Tomoaki Nagahara All right reserved.
 */
class QQL implements IF_UNIT, IF_QQL
{
	/** use
	 *
	 */
	use OP_CORE, OP_CI;

	/** Database resource pool.
	 *
	 * <pre>
	 * self::$_PDOs[ self::$_hash ] = new \PDO();
	 * </pre>
	 *
	 * @created    2024-07-13
	 * @var        array
	 */
	static $_PDOs;

	/** Current select database hash.
	 *
	 * <pre>
	 * self::$_hash = md5($dsn);
	 * </pre>
	 *
	 * @created    2024-07-13
	 * @var        string
	 */
	static $_hash;

	/** Stock database type.
	 *
	 * <pre>
	 * self::$_type[ self::$_hash ] = 'mysql';
	 * </pre>
	 *
	 * @created    2024-07-13
	 * @var        array
	 */
	static $_type;

	/** Open database resource.
	 *
	 * @created    2024-07-13
	 * @param      string     $dsn
	 * @return     string
	 */
	static public function Open(string $dsn='') : string
	{
		//	...
		if( empty($dsn) ){
			$dsn = OP()->Config('database');
		}

		//	Convert to DSN from string.
		if( is_string($dsn) ){
			$dsn = include(__DIR__.'/include/DsnString.php');
		}

		//	Convert to DSN from array.
		if( is_array($dsn) ){
			$dsn = include(__DIR__.'/include/DsnArray.php');
		}

		//	...
		if( $pos  = strpos($dsn, ':') ){
			$type = substr($dsn, 0, $pos);
		}

		//	...
		self::$_hash = substr(md5($dsn), 0, 10);
		self::$_type [ self::$_hash ] = $type;

		//	...
		if( isset( self::$_PDOs[ self::$_hash ] ) ){
			return self::$_hash;
		}

		//	...
		try{
			self::$_PDOs[ self::$_hash ] = new \PDO($dsn);
			self::$_PDOs[ self::$_hash ] -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}catch( \PDOException $e ){
			OP()->Notice( $e->getMessage() );
		}

		//	...
		return self::$_hash;
	}

	/** Close database resource.
	 *
	 * @created    2024-07-13
	 * @param      string     $hash
	 * @return     boolean
	 */
	static public function Close(string $hash='')
	{

	}
}
