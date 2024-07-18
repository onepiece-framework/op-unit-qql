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

//	...
foreach( $option as $key => $val ){

	//	...
	if( is_integer($key) ){
		$val = trim($val);
		if( $pos = strpos($val, ' ') ){
			$key = substr($val, 0, $pos);
			$val = substr($val, $pos +1);
		}else{
			D('Does not match option format.', $val);
			continue;
		}
	}

	//	...
	switch( $key = strtoupper($key) ){
		case 'LIMIT':
			if( $val > 0 ){
				$OPTION[] = $key.' '.$val;
			}
			break;

		case 'ORDER':
			$OPTION[] = $key.' BY '.$val;
			break;
	}
}

//	...
return join(' ', $OPTION);
