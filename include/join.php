<?php
/** op-unit-qql:/include/join.php
 *
 * @created    2024-07-15
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

/* @var $quote string */
/* @var $table string */

//	...
$ON = [];
foreach( explode('+', $table) as $temp ){
	//	...
	list($l, $r) = explode('.', $temp);
	$on = $quote . trim($l) . $quote .'.'. $quote . trim($r) . $quote;
	//	...
	if(!$ON ){
		$FROM = $quote . trim($l) . $quote;
		$ON[] = $on;
	}else{
		$ON[]  = $on;
		$JOIN  = ' LEFT JOIN ';
		$FROM .= $JOIN . $quote . trim($l) . $quote;
		$FROM .= ' ON ' . $ON[0] .' = '. $ON[1];
		array_shift($ON);
	}
}
unset($l, $r, $on, $ON, $JOIN);

//	...
return $FROM;
