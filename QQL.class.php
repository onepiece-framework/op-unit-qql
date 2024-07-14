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

	/** Set data to database
	 *
	 * @created    2024-07-13
	 * @param      string     $table
	 * @param      array      $set
	 * @param      array      $where
	 * @param      array      $option
	 * @return     int
	 */
	static public function Set(string $table, array $set, array $where=[], array $option=[]) : int
	{
		//	...
		if( empty($table) ){
			OP()->Notice("table name is empty");
			return 0;
		}

		//	...
		if( empty($set) ){
			OP()->Notice("SET is empty");
			return 0;
		}

		//	...
		if( $where ){
			return self::Update($table, $set, $where, $option);
		}else{
			return self::Insert($table, $set);
		}
	}

	/** Insert
	 *
	 * @created    2024-07-13
	 * @param      string     $table
	 * @param      array      $set
	 * @return     int        $ai is auto increment id
	 */
	static public function Insert(string $qql, array $set)
	{
		//	...
		$fields = array_keys($set);
		$quote  = include(__DIR__.'/include/quote.php' );
		$TABLE  = include(__DIR__.'/include/table.php' );
		$FIELDS = include(__DIR__.'/include/fields.php');
		$VALUES = include(__DIR__.'/include/values.php');
		unset($fields, $quote);

		try{
			//	...
			$sql  = "INSERT INTO {$TABLE} ($FIELDS) VALUES ($VALUES)";
			$stmt = self::$_PDOs[ self::$_hash ] -> prepare($sql);
			$stmt->execute($set);

			//	...
			return (int)self::$_PDOs[ self::$_hash ] -> lastInsertId();

		}catch( \PDOException $e ){
			//	...
			self::_Error($e);
			//	...
			return false;
		}
	}

	/** Update
	 *
	 * @created    2024-07-14
	 * @param      string     $table
	 * @param      array      $set
	 * @param      array      $where
	 * @param      array      $option
	 * @return     int        $number of update record
	 */
	static public function Update(string $qql, array $set, array $where=[], array $option=[])
	{
		//	...
		$quote = include(__DIR__.'/include/quote.php');
		$TABLE = include(__DIR__.'/include/table.php');
		$SET   = include(__DIR__.'/include/set.php'  );
		$WHERE = include(__DIR__.'/include/where.php');
		$LIMIT = include(__DIR__.'/include/limit.php');
		unset($quote);

		//	...
		$sql = "UPDATE {$TABLE} SET {$SET} WHERE {$WHERE} {$LIMIT}";

		try{
			//	...
			$stmt = self::$_PDOs[ self::$_hash ] -> prepare($sql);
			$stmt -> execute( array_merge_recursive( $set, $where ) );
			//	...
			return $stmt -> rowCount();

		}catch( \PDOException $e ){
			//	...
			self::_Error($e);
			//	...
			return false;
		}
	}

	/** Select
	 *
	 * @created    2024-07-14
	 * @param      string     $qql
	 * @param      array      $where
	 * @param      array      $option
	 * @return     array      $record
	 */
	static public function Get(string $qql, array $where=[], array $option=[]) : array
	{
		//	...
		$quote  = include(__DIR__.'/include/quote.php' );
		$parsed = include(__DIR__.'/include/parser.php');
		$OPTION = include(__DIR__.'/include/option.php');

		//	...
		$sql = "SELECT {$parsed['FIELD']} FROM {$parsed['TABLE']} {$parsed['WHERE']} {$OPTION}";

		//	...
		$stmt = self::$_PDOs[ self::$_hash ] -> prepare($sql);
		$stmt -> execute( $where );

		//	...
		if( $option['limit'] == 1 ){
			return $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
		}else{
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

		//	for Eclipse notice.
		if( 0 ){ D($quote); }
	}

	/** Stack errors
	 *
	 * @created    2024-07-13
	 * @var        array
	 */
	static $_errors;

	/** Stack errors
	 *
	 * @created    2024-07-13
	 */
	static private function _Error()
	{
		//	...
		$error = self::$_PDOs[ self::$_hash ]->errorInfo();

		//	...
		if( $error[2] ){
			self::$_errors[] = "SQLSTATE: {$error[0]} - [$error[1]] $error[2]";
		}
	}

	/** Return stacked errors
	 *
	 * @created    2024-07-13
	 * @return     array
	 */
	static public function Error() : string
	{
		return empty(self::$_errors) ? '': array_shift( self::$_errors );
	}
}
