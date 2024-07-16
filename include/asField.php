<?php
/** op-unit-qql:/include/asField.php
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

/* @var $quote string  */
/* @var $field string  */
/* @var $pos   integer */
/* @var $parse array   */

//	...
$l = trim( substr($field, 0, $pos) );
$r = trim( substr($field, $pos+3)  );
if( strpos($l, '.') ){
	list($t, $f) = explode('.', $l);
	$l = $quote.$t.$quote.'.'.$quote.$f.$quote;
}else{
	$l = $quote.$l.$quote;
}
//D($field, $l, $r, $t, $f);

//	...
$parse['FIELDs'][] = $r;

//	...
return $l.' AS '.$quote.$r.$quote;
