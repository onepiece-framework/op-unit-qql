<?php
/** op-unit-qql:/function/GetTableInfo.php
 *
 * @created    2024-07-24
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
