<?php
    class Constants {
        private static $db_host          = 'localhost';
        private static $db_user          = 'root';
        private static $db_password      = '';
        private static $db_name          = 'comicmailer';
        private static $user_table       = 'users';
        private static $otp_session_name = 'start_time';

        public static function get_db_host() {
            return Constants::$db_host;
        }

        public static function get_db_user() {
            return Constants::$db_user;
        }

        public static function get_db_password() {
            return Constants::$db_password;
        }

        public static function get_db_name() {
            return Constants::$db_name;
        }

        public static function get_user_table() {
            return Constants::$user_table;
        }

        public static function get_otp_session_name() {
            return Constants::$otp_session_name;
        }
    }
?>