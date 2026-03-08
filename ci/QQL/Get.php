<?php
/**	op-unit-qql:/ci/QQL/Get.php
 *
 * @created    2026-03-08
 * @license    Apache-2.0
 * @package    op-unit-qql
 * @copyright  Tomoaki Nagahara
 */

/**	Declare strict type
 *
 */
declare(strict_types=1);

/**	Namespace
 *
 */
namespace OP;

/* @var $ci \OP\UNIT\CI\CI_Config */

//	The method name is obtained from this file name.
$method = basename(__FILE__);
$method = explode('.', $method)[0];

//	Get PHP version
$php = PHP_MAJOR_VERSION.PHP_MINOR_VERSION;

//	Positive case.
$args   = ' ai <- t_user.ai = 1';
$result = $php == 80 ? "1" : 1 ;
$ci->Set($method, $result, $args);

//	Expects an empty array to be returned.
$args   = 't_user.ai = 0';
$result = [];
$ci->Set($method, $result, $args);

//	Expects null to be returned.
$where  = [];
$option = [];
$limit  =  1;
$args   = [' ai <- t_user.ai = 0', $where, $option, $limit];
$result = null;
$ci->Set($method, $result, $args);
