<?php
    require_once __DIR__ . '/class-secrets.php';

    class Constants {
        private static $min_otp          = 1111;
        private static $max_otp          = 9999;
        private static $web_link         = 'https://comicmailer.herokuapp.com';
        private static $user_table       = 'users';
        private static $sender_email     = 'pamaan866@gmail.com';
        private static $otp_session_name = 'start_time';
        private static $otp_mail_subject = 'Comic Mailer Verification Code';
        private static $otp_mail_body    = 'The OTP for Comic Mailer is ';

        /**
         * get_min_otp gives the minimum digit of otp.
         * i.e. if range of otp is [1111, 9999], get_min_otp will return 1111.
         *
         * @return int minimum otp number.
         */
        public static function get_min_otp() {
            return self::$min_otp;
        }

        /**
         * get_max_otp gives the maximum digit ot otp.
         * i.e. if range of otp is [1111, 9999], get_max_otp will return 9999.
         *
         * @return int maximum otp number.
         */
        public static function get_max_otp() {
            return self::$max_otp;
        }

        /**
         * get_web_link gives the url on which website is hosted.
         *
         * @return string current url on which site is hosted.
         */
        public static function get_web_link() {
            return self::$web_link;
        }

        /**
         * get_user_table gives the name of table in which user information is saved.
         *
         * @return string name of the table in which user's information is saved.
         */
        public static function get_user_table() {
            return self::$user_table;
        }

        /**
         * get_sender_mail gives the email address from which the mails are going to be send to Subscribers.
         *
         * @return string sender's email address.
         */
        public static function get_sender_mail() {
            return self::$sender_email;
        }

        /**
         * get_otp_session_name gives the name of otp session which is to be set or which is set.
         *
         * @return string name of the session which is used for handling the otp_session.
         */
        public static function get_otp_session_name() {
            return self::$otp_session_name;
        }

        /**
         * get_otp_mail_subject gives the subject which is to be kept from mails containing otp.
         *
         * @return string subject of mail containing otp.
         */
        public static function get_otp_mail_subject() {
            return self::$otp_mail_subject;
        }

        /**
         * get_otp_mail_body gives the body of email containing otp.
         *
         * @param int $otp otp which is to be set inside the mail body.
         * @return string body of mail containing otp.
         */
        public static function get_otp_mail_body( $otp ) {
            return self::$otp_mail_body . $otp . '.';
        }

        /**
         * get_mail_secret gives the api key of Sendgrid api.
         *
         * @return string api key for sending mail.
         */
        public static function get_mail_secret() {
            return Secrets::mail_api_secret();
        }

        /**
         * get_db_host gives the domain on which our database is hosted.
         *
         * @return string domain of hosted database.
         */
        public static function get_db_host() {
            return Secrets::db_host();
        }

        /**
         * get_db_user gives the username of hosted database.
         *
         * @return string user name of hosted database.
         */
        public static function get_db_user() {
            return Secrets::db_user();
        }

        /**
         * get_db_password gives the password of hosted database.
         *
         * @return string password of hosted database.
         */
        public static function get_db_password() {
            return Secrets::db_password();
        }

        /**
         * get_db_name gives the database name of hosted database.
         *
         * @return string name of the hosted database.
         */
        public static function get_db_name() {
            return Secrets::db_name();
        }
    }
?>