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
//is aws service
//define( 'SERVER_URL',               'http://ec2-54-69-59-169.us-west-2.compute.amazonaws.com/' );

//is local
define( 'SERVER_URL',              $_SERVER['SERVER_ADDR'] );

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('ERROR_LOGIN',                   0);
define('SUCCESS_LOGIN',                 1);
define('SUCCESS_LOGOUT',                6);
define('SUCCESS_QUERY',                 7);
define('NOT_LOGIN',                     2);
define('ERROR_REGISTERED',              3);
define('ERROR_QUERY',                   4);
define('ERROR_INVALID_FIELD',           5);
define('LOGINED',                       8);
define('API_DEFAULT',                   9);
define('SUCCESS_REGISTERED',            10);
define('ERROR_FIELD_EXIST',             11);
define('ERROR_PASSWORD_NOT_MATCH',      12);
define('ERROR_RECORD_NOT_EXIST',        13);
define('ERROR_CHANGE_PASSWORD',         14);
define('SUCCESS_CHANGE_PASSWORD',       15);
define('SUCCESS_REGISTERED_PLEASE_CONFIRM_YOUR_EMAIL',  16);
define('SUCCESS_CONFIRM',               17);
define('ERROR_CHANGE_EMAIL',            18);
define('COMMENT_NOT_FIND',              19);
define('ACCESS_DENIED',                 20);
define('ERROR_FIELD_NOT_SET',           21);
define('ERROR_DONT_SUPPORT',            22);
define('ERROR_CUSTOM',                  23);
define('SUCCESS_CUSTOM',                24);
define('NOTICE_CUSTOM',                 25);
define('ERROR_SEND_MAIL',               26);
define('ERROR_FRIEND_NOT_FOUND',        27);

//PROFILE CHANGE VALUE
define('SUCCESS_CHANGE_USER_NAME',      27);
define('SUCCESS_CHANGE_EMAIL',          28);

//USER INVITED STATUS
define('USER_REGISTERED',               201);
define('USER_UNREGISTERED',             202);
define('USER_INVITED_IN_SYSTEM',        203);
define('USER_INVITED_IN_FRIEND',        204);
define('USER_ALREADY_FRIEND',           205);

//FRIEND STATUS
define('FRIEND_ACCEPT',                 301);
define('FRIEND_INVITED',                302);
define('FRIEND_DECLINE',                303);
define('FRIEND_IGNORE',                 304);
define('FRIEND_DISABLE_FRIEND',         305);

//TYPE NOTIFICATION
define('NOTIFICATION_NEW_COMMENT',                      401);
define('NOTIFICATION_INVITE_IN_FRIEND',                 402);
define('NOTIFICATION_ACCEPT_FRIEND',                    403);
define('NOTIFICATION_REGISTERED_FRIEND',                404);
define('NOTIFICATION_REMOVED_FRIEND',                   405);
define('NOTIFICATION_DECLINED_FRIEND',                  406);
define('NOTIFICATION_FRIEND_ADDED_NEW_PHOTO',           407);
define('NOTIFICATION_FRIEND_ADDED_NEW_VIDEO',            408);
define('NOTIFICATION_FRIEND_COMMENTED_YOUR_PHOTO',      409);
define('NOTIFICATION_FRIEND_COMMENTED_YOUR_VIDEO',      410);
define('NOTIFICATION_FRIEND_LIKE_YOUR_PHOTO',           411);
define('NOTIFICATION_FRIEND_LIKE_YOUR_VIDEO',           412);
define('NOTIFICATION_SETTING_ENABLE',                   413);
define('NOTIFICATION_SETTING_DISABLE',                  414);
define('NOTIFICATION_ADDDED_NEW_USER',                  415);
define('NOTIFICATION_ACCESS_MEDIA_USER',                416);

//ROLE
define('NOT_CONFIRM_USER',              501);
define('CONFIRM_USER',                  502);

//MEDIA
define('ERROR_MEDIA_TYPE_FILE',         601);
define('SUCCESS_UPLOAD',                602);
define('MEDIA_NOT_FOUND',               603);

define( 'NOTIFICATION_TYPE0',           'invite' );
define( 'NOTIFICATION_TYPE1',           'decline' );
define( 'NOTIFICATION_TYPE2',           'accept' );
define( 'NOTIFICATION_TYPE3',           'ignore' );
define( 'NOTIFICATION_TYPE4',           'remove' );
define( 'NOTIFICATION_TYPE5',           'share' );
define( 'NOTIFICATION_TYPE6',           'comment' );
define( 'NOTIFICATION_TYPE7',           'photo_like' );
define( 'NOTIFICATION_TYPE8',           'video_like' );
define( 'NOTIFICATION_TYPE9',           'added_new_user' );

define( 'AVATAR_ROOT_PATH',                    'uploads/avatars/' );
define( 'AUDIO_COMMENT_ROOT_PATH',             'uploads/audio_comment/' );
define( 'MEDIA_ROOT_PATH',                     'uploads/medias/' );
define( 'VIDEO_THUMB_PATH',                    'uploads/medias/' );


/* End of file constants.php */
/* Location: ./application/config/constants.php */