<?php
/** op-unit-qql:/include/join_calc.php
 *
 * @created    2024-07-22
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

/* @var $temp  string */
/* @var $LEFT  string */
/* @var $RIGHT string */

//	+($RIGHT)
if( $temp[0] === '<' or $temp[0] === '>' ){
	$RIGHT = $temp[0];
}else{
	$RIGHT = null;
}

//	...
switch( $LEFT.'+'.$RIGHT ){
	case  '+':
	case '<+':
		$JOIN = 'LEFT';
		break;
	case '+>':
		$JOIN = 'RIGHT';
		break;
	case '>+<':
		$JOIN = 'INNER';
		break;
	case '<+<':
		$JOIN = 'LEFT OUTER';
		break;
	case '>+>':
		$JOIN = 'RIGHT OUTER';
		break;
	default:
		$JOIN = 'LEFT';
		OP()->Notice("Does not match QQL format: `$JOIN`");
}

//	Carryover next table
$len = strlen($temp)-1;
if( $temp[$len] === '<' or $temp[$len] === '>' ){
	$LEFT = $temp[$len];
}else{
	$LEFT = null;
}

//	...
$temp = trim($temp, '<>');

//	...
return $JOIN;
