<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Cache timer
|--------------------------------------------------------------------------
| 
| all are in seconds
|
*/
define('CACHE_TIMER_H01',                       3600);
define('CACHE_TIMER_H02',                       7200);
define('CACHE_TIMER_H05',                       18000);
define('CACHE_TIMER_M01',                       60);
define('CACHE_TIMER_M03',                       180);
define('CACHE_TIMER_M05',                       300);
define('CACHE_TIMER_M10',                       600);
define('CACHE_TIMER_M15',                       900);
define('CACHE_TIMER_M30',                       1800);

define('CACHE_TIMER_COMPANY_INFO',              300);
define('CACHE_TIMER_COMPANY_INFO_NONE',         60);
define('CACHE_TIMER_COMPANIES',                 300);
define('CACHE_TIMER_COMPANIES_NONE',            180);
define('CACHE_TIMER_QUOTE',                     300);
define('CACHE_TIMER_QUOTE_NONE',                60);


/* End of file constants.php */
/* Location: ./application/config/constants.php */