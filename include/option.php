<?php
/** op-unit-qql:/include/option.php
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

//	pager
if( isset($option['page']) ){
	require(__DIR__.'/option_page.php');
}

//	...
foreach( ['group','order','limit','offset'] as $key ){
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
			if( is_int($val) and $val >= 0 ){
				$OPTION[] = $key.' '.$val;
			}
			break;
	}
}

//	...
return join(' ', $OPTION);
