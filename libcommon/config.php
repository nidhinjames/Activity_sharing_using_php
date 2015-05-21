<?php
$PROJECT_NAME = "Ourlibrary";
$DB_NAME = "collegename_db";
$HOST = "localhost";
$USER = "root";
$PASSWD = "root";
$MAX_USER_PER_PAGE = 5;
$MAX_PAGE_NUMBER = 5;
$MAX_BOOK_PER_PAGE = "15";
$MAX_SEARCH_RESULT_PER_PAGE = 10;
$MaterialType = array("book", "adio cd", "video cd");
$PENALTY_PERDAY = 4;
$LIBADMIN = "libadmin/";
$LIBCOMMON = "libcommon/";
$STUDENT_FOLDER_PATH = "../studentdocs/";
$STUDENT_SWF_PATH = "swffiles/";
$STUDENT_PDF_PATH = "pdf/";
$STUDENT_DOC_PATH = "doc/";
$STUDENT_IMG_PATH = "images/";
//Staff folder path
$STAFF_FOLDER = "../staffdocs/";
$STAFF_SWF_PATH = "swffiles/";
$STAFF_PDF_PATH = "pdf/";
$STAFF_DOC_PATH = "doc/";
$STAFF_IMG_PATH = "images/";


$rating_dbhost = $HOST;
$rating_dbuser = $USER;
$rating_dbname = $DB_NAME;
$rating_tableName = 'ratings';
$rating_path_db       = '';
$rating_path_rpc      = '';
$rating_unitwidth     = 30; // the width (in pixels) of each rating unit (star, etc.)
// if you changed your graphic to be 50 pixels wide, you should change the value above
?>
