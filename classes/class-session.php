<?php
    require_once __DIR__ . '/class-user.php';

    Class Session {
        public static function start( $session_name, $session_value ) {
            $_SESSION[ $session_name ] = $session_value;
         }

        public static function end( $session_name ) {
            unset( $_SESSION[ $session_name ] );
        }

        public static function check( $session_name ) {
           return isset( $_SESSION[ $session_name ] ) ? 'is_set' : 'not_set';
        }

        public static function end_all() {
            session_destroy();
        }

        public static function get_value( $session_name ) {
            if ( self::check( $session_name ) ) {
                return $_SESSION[ $session_name ];
            } else {
                return null;
            }
        }

        public static function is_login_session_valid() {
            $user = new User;
            if ( $user->is_otp_valid() ) {
                return true;
            } else {
                return false;
            }
        }
    }