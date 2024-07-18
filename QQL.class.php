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

	/** Stack request for debug.
	 *
	 * @var array
	 */
	static $_request;

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
	static public function Set(string $qql, array $set, array $where=[], array $option=[])
	{
		//	...
		if( empty($qql) ){
			OP()->Notice("table name is empty");
			return 0;
		}

		//	...
		if( empty($set) ){
			OP()->Notice("SET is empty");
			return 0;
		}

		//	...
		if( strpos($qql, '=') ){
			$quote  = include(__DIR__.'/include/quote.php' );
			$parsed = include(__DIR__.'/include/parser.php');
			$qql = trim($parsed['TABLE'], $quote);
			unset($quote);
		}

		//	...
		if( $where ){
			return self::Update($qql, $set, $where, $option);
		}else{
			return self::Insert($qql, $set);
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
	static public function Get(string $qql, $where=null, $option=null, int $limit=1)
	{
		//	For developer
		$origin = [
			'qql'    => $qql,
			'where'  => $where,
			'option' => $option,
			'limit'  => $limit,
		];

		//	Convert to array from string.
		if( is_string($where) ){
			$where = [$where];
		}

		//	...
		if( empty($option['limit']) ){
			$option['limit'] = $limit;
		}

		//	...
		$get    = true;
		$quote  = include(__DIR__.'/include/quote.php' );
		$parsed = include(__DIR__.'/include/parser.php');
		$OPTION = include(__DIR__.'/include/option.php');

		//	...
		$sql = "SELECT {$parsed['FIELD']} FROM {$parsed['TABLE']} {$parsed['WHERE']} {$OPTION}";

		//	...
		if( OP()->Env()->isAdmin() ){
			//	...
			self::$_request[] = [
				'origin' => $origin,
				'qql'    => $qql,
				'where'  => $where,
				'option' => $option,
				'limit'  => $limit,
				'parsed' => $parsed,
				'OPTION' => $OPTION,
				'sql'    => $sql,
			];
		}

		//	...
		try{

		//	...
		$stmt = self::$_PDOs[ self::$_hash ] -> prepare($sql);
		$stmt -> execute( $where );
		$records = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		//	...
		if( $option['limit'] == 1 ){
			//	...
			$records = $records[0] ?? [];

			//	...
			if( count($parsed['FIELDs'] ?? []) === 1 ){
				$records = $records[ $parsed['FIELDs'][0] ] ?? null;
			}
		}

		}catch( \PDOException $e ){
			self::_Error($e);
		}

		//	...
		unset($get, $quote);

		//	...
		return $records ?? [];
	}

	/** Display the records retrieved from the database in a table format.
	 *
	 */
	static public function Display(string $qql, $where=null, $option=null, int $limit=-1)
	{
		//	...
		OP()->WebPack(__DIR__.'/webpack/display.*');

		//	...
		if(!$records = self::Get($qql, $where, $option, $limit) ){
			OP()->Notice( self::Error() );
			return;
		}

		//	...
		$records = \OP\Encode($records);
		$json = json_encode($records);
		$json = htmlentities($json, ENT_NOQUOTES, 'utf-8');
		echo '<div class="qql records">'.$json.'</div>';
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
	static private function _Error( \PDOException $e )
	{
		//	...
		if(!$error_info = $e->errorInfo ?? null ){
			return;
		}

		//	...
	//	$HY000 = $error_info[0] ?? null;
		$code  = $error_info[1] ?? null;
		$info  = $error_info[2] ?? null;
		$message = "[{$code}] {$info}";

		//	...
		$request = self::$_request[count(self::$_request)-1];
		D($message, $request);

		//	...
		switch( $code ){
			case ' ':
				OP()->Notice("Does not match where field.");
				D( self::$_request );
				break;
		}

		//	...
		self::$_errors[] = $message;
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

	/** Dump debug information for developers.
	 *
	 * @created    2024-07-22
	 */
	static public function Debug()
	{
		//	...
		if( \OP\Env::isCI() ){
			return;
		}

		//	...
		D( self::$_request );
	}

	/** Quote field name.
	 *
	 * @created    2024-07-22
	 * @param      string     $field
	 * @return     string
	 */
	static public function Quote(string $field) : string
	{
		//	...
		if( strpos($field, ':') ){
			return include(__DIR__.'/include/quote_table.php');
		}else
		if( strpos($field, '(') ){
			return include(__DIR__.'/include/quote_field.php');
		}else{
			return include(__DIR__.'/include/quoted.php');
		}
	}
}
