<?php
/** op-unit-qql:/function/GetTableInfo.php
 *
 * @created    2024-07-24
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
namespace OP\UNIT;

/** Get table info.
 *
 * @created    2024-07-24
 * @param     \PDO        $pdo
 * @param      string     $table
 * @return     array
 */
function GetTableInfo(\PDO $pdo, string $table) : array
{
	//	...
	switch( $pdo->getAttribute(\PDO::ATTR_DRIVER_NAME) ){
		//	...
		case 'mysql':
			$sql = "DESCRIBE {$table}";
			break;
		//	...
		case 'sqlite':
			$sql = "PRAGMA table_info({$table})";
			break;
		default:
	}

	//	...
	$stmt = $pdo  -> query($sql);
	$info = $stmt -> fetchAll(\PDO::FETCH_ASSOC);

	//	...
	return $info;
}
