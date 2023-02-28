<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/

defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('DEVELOPMENT_MODE', '1');

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'db_efort');


define('KODE_TRANSAKSI', '01');
define('KODE_TRANSAKSI_PEMBAYARAN', '02');  
 
define('KODE_TRANSAKSI_UANG_MUKA', '03');

define('VERSION', 'Version 1.0');
define('TITLES', 'BIDIK - ASN Juara | BKPSDM Kota Manado');
define('TITLE_SECOND', 'BIDIK - ASN Juara');
define('TITLE_THIRD', 'BIDIK - ASN Juara');
define('PROGRAMMER_PHONE', '00000000');
define('COPYRIGHT', 'Copyright &copy; 2022 <strong>BKPSDM Manado</strong>');
// define('COPYRIGHT', 'Copyright &copy; '.date('Y').' <strong>PATRA LAB</strong>');
define('TRANSAKSI_TABLE_VIEW', 1);
define('USE_PRINT', '0');
define('URI_UPLOAD', './assets/'); //local with xampp
define('DB_BACKUP_FOLDER', 'db/backup/'); //local with xampp
define('DB_RESTORE_FOLDER', 'db/restore/'); //local with xampp

define('DEVELOPER', 'nikita');

// define('START_CELL', 'B23');
// define('HEADER_CELL', 'A21:AG22');
// define('START_ROW_NUM', '23');
// define('SKPD_CELL', 'C19');
// define('PERIODE_CELL', 'C20');

// define('START_CELL', 'B12');
// define('HEADER_CELL', 'A10:AH11');
// define('START_ROW_NUM', '12');
// define('SKPD_CELL', 'C8');
// define('PERIODE_CELL', 'C9'); //lastt

define('START_CELL', 'B7');
define('HEADER_CELL', 'A5:AH6');
define('START_ROW_NUM', '7');
define('SKPD_CELL', 'C3');
define('PERIODE_CELL', 'C4');

define('IMPORT_UNIT_KERJA', '4018000');

define('MARGIN_TOP_CETAKAN', '150px');
define('PADDING_CETAKAN', '10px');
define('FONT_CETAKAN', 'Verdana');
define('ROW_PER_PAGE_CETAK_TAGIHAN', 55);
define('ROW_PER_PAGE_CETAK_TINDAKAN', 45);

define('VONAGE_API_KEY', 'b9e13f92');
define('VONAGE_API_SECRET', 'd9b1754f4da78a5a');
define('TARGET_PENILAIAN_DISIPLIN_KERJA', 100);
define('URL_API_HARI_LIBUR', 'https://api-harilibur.vercel.app/api');
define('LIST_UNIT_KERJA_KHUSUS', [4011000, 4026000, 4012000, 4018000, 1010400, 1030750, 1020500, 7005010, 7005020]);
define('LIST_UNIT_KERJA_MASTER_SEKOLAH', [8000000, 8010000, 8020000, 8030000]);
define('LIST_UNIT_KERJA_MASTER_KECAMATAN', [5001000, 5002000, 5003000, 5004000, 5005000, 5006000, 5007000, 5008000, 5009000, 5010001, 5011001]);
define('LIST_UNIT_KERJA_KECAMATAN', [50010001, 50020001, 50030001, 50040001, 50050001, 50060001, 50070001, 50080001, 50090001, 50100011, 50110011]);
define('LIST_ROLE_KHUSUS', ['lurah', 'camat']);
define('ID_BIDANG_PEKIN', 166);
define('URL_MENU_PEKIN', ['rekapitulasi/absensi', 'dokumen-pendukung-absensi/verifikasi', 'dokumen-pendukung-absensi/disker']);
define('ID_UNITKERJA_DIKBUD', 3010000);
define('DOKUMEN_PENDUKUNG_DISIPLIN_KERJA', 'assets/dokumen_pendukung_disiplin_kerja');

define('TARGET_BOBOT_PRODUKTIVITAS_KERJA', 60);
define('TARGET_BOBOT_DISIPLIN_KERJA', 40);
define('BOBOT_NILAI_SKBP', 0.3);
define('BOBOT_NILAI_KOMPONEN_KINERJA', 0.3);