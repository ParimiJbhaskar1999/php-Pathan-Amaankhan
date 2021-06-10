<?php
    class Constants {
        private static $db_host          = 'localhost';
        private static $db_user          = 'root';
        private static $db_password      = '';
        private static $db_name          = 'comicmailer';
        private static $user_table       = 'users';
        private static $otp_session_name = 'start_time';

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
    }
?>