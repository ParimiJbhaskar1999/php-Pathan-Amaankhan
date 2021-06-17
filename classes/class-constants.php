<?php
    class Constants {
        private static $min_otp          = 1111;
        private static $max_otp          = 9999;
        private static $min_comic_no     = 1;
        private static $max_comic_no     = 2475;
        private static $db_host          = 'remotemysql.com';
        private static $db_user          = 'lJ6eM1HOzx';
        private static $db_password      = 'BVTJ47Pz2Z';
        private static $db_name          = 'lJ6eM1HOzx';
        private static $user_table       = 'users';
        private static $otp_session_name = 'start_time';
        private static $cnf_mail_subject = 'Comic Mailer Verification Code';
        private static $cnf_mail_body    = 'The OTP for Comic Mailer is ';
        private static $mail_headers     = 'MIME-Version: 1.0' . "\r\n" .
                                           'Content-type:text/html;charset=UTF-8' . "\r\n";

        public static function get_min_otp() {
            return self::$min_otp;
        }

        public static function get_max_otp() {
            return self::$max_otp;
        }

        public static function get_min_comic_no() {
            return self::$min_comic_no;
        }

        public static function get_max_comic_no() {
            return self::$max_comic_no;
        }

        public static function get_db_host() {
            return self::$db_host;
        }

        public static function get_db_user() {
            return self::$db_user;
        }

        public static function get_db_password() {
            return self::$db_password;
        }

        public static function get_db_name() {
            return self::$db_name;
        }

        public static function get_user_table() {
            return self::$user_table;
        }

        public static function get_otp_session_name() {
            return self::$otp_session_name;
        }

        public static function get_cnf_mail_subject() {
            return self::$cnf_mail_subject;
        }

        public static function get_cnf_mail_body( $otp ) {
            return self::$cnf_mail_body . $otp . '.';
        }

        public static function get_mail_headers() {
            return self::$mail_headers;
        }

    }
?>