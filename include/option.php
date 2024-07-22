<?php
/** op-unit-qql:/include/option.php
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

/* @var $option array  */

//	...
$OPTION = [];

//	Convert to assoc from strings array.
$temp = [];
foreach( $option as $key => $val ){
	//	...
	if( is_integer($key) ){
		$val = trim($val);
		if( $pos = strpos($val, ' ') ){
			$key = trim( substr($val, 0, $pos) );
			$val = trim( substr($val, $pos +1) );
		}else{
			D('Does not match option format.', $val);
			continue;
		}
	}
	//	...
	$temp[$key] = $val;
}
$option = $temp;

//	...
foreach( ['group','order','limit','offset','page',] as $key ){
	//	...
	if(!$val = $option[$key] ?? null ){
		continue;
	}

	//	...
	switch( $key = strtoupper($key) ){
		case 'GROUP':
			$val = self::Quote($val);
			$OPTION[] = $key.' BY '.$val;
			break;

		case 'ORDER':
			if( $pos = strrpos($val, ' desc') ){
				$val = substr($val, 0, $pos);
				$val = self::Quote($val) . ' DESC';
			}else{
				$val = self::Quote($val);
			}
			$OPTION[] = $key.' BY '.$val;
			break;

		case 'LIMIT':
		case 'OFFSET':
			if( is_int($val) and $val > 0 ){
				$OPTION[] = $key.' '.$val;
			}
			break;
	}
}

//	...
return join(' ', $OPTION);
