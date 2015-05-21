<?php
$PROJECT_NAME = "Ourlibrary";
//$DB_NAME = "simat_dbfeb23";
$DB_NAME = "simat_mar18";
//$DB_NAME = "sreepathy_db2";
//$DB_NAME = "pisat_db";
$HOST = "localhost";
$USER = "root";
$PASSWD = "root";
$MAX_USER_PER_PAGE = 15;
$MAX_PAGE_NUMBER = 5;
$MAX_BOOK_PER_PAGE = "50";
$MAX_SEARCH_RESULT_PER_PAGE = 10;
$MaterialType = array("Book", "Adio cd", "Video cd");
$PENALTY_PERDAY = 4;
$ROOT_PATH = "/var/www/sreepathy/";
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


$GroupPrivileges = array( 
                                'Users & Privileges' => 'staff',
                                'Books' => 'books',
                                'Department' => 'dept',
                                'Category' => 'category',
                                'Suggestion' => 'suggestion',
                                'Booktransaction' => 'transaction',
                                'Settings' => 'settings',
                                'Author' => 'author',
                                'Publisher' => 'publisher',
                                'Supplier' => 'supplier',
                                'Currency' => 'currency',
                                'Language' => 'language',
                                'Frequency' => 'frequency',
                                'Draw Entry' => 'drawentry',
                                'Rack Entry' => 'rackentry',
                                'Attachments' => 'attachment',
								'Accession Register' => 'accregi',
                                'Faculty Report' => 'facultyrep',
                                'Student Report' => 'studentrep',
                                'Book Issue Report' => 'bookissu',
                                'Cost summary' => 'bookcost',
								'Book Bank Settings' => 'BBS_settings',
								'Book Bank Transaction' => 'BBS_transaction',
                                'Subject' => 'subject');
$adminGroupPrivileges = array(
				'Department' => 'dept',
				'Subject' => 'subject',
				'Admin' => 'adminacc',
				'Faculty' => 'staff',
				'Batches' => 'batch',
				'Assign Faculty' => 'sbs',
				'Student' => 'student',
				'Timetable' => 'timetable',
				'Exams' => 'exam',
				'Exam Type' => 'exam_type',
				'Document' => 'document',
				'Calendar' => 'calendar'
				);

$sms_username="sreepathy";
$sms_password="sreepathy1";
$sms_sender="SIMAT";
$sms_domain="sms.marketsolutions.co.in/";
$sms_method="POST";

/* Mail server configuration */

$SMTPHost = "smtp.gmail.com";
$SMTPPort = 465;
$mailID = "simatlms@gmail.com";
$mailpassword =  "simatlms123";
$MailFromID =  "simatlms@gmail.com";
$MailFromName = "SIMAT";
$MailSubject = "test";
$MailBody = "Test message";
$mailReplyTo = "simatlms@gmail.com"

?>
