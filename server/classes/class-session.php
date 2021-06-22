<?php
    require_once __DIR__ . '/class-user.php';

    Class Session {
        /*
         * start function starts a new session with the name and value provided in the parameters.
         *
         * Returns -> ( none )
         *
         * Parameters
         * $session_name : string
         * $session_value: any
         */
        public static function start( $session_name, $session_value ) {
            $_SESSION[ $session_name ] = $session_value;
        }

        /*
         * end function ends the running session.
         *
         * Returns -> ( none )
         *
         * Parameters
         * $session_name: string
         */
        public static function end( $session_name ) {
            unset( $_SESSION[ $session_name ] );
        }

        /*
         * check function checks if the session is set or not.
         *
         * Returns -> ( string )
         *
         * Parameters
         * $session_name: string
         */
        public static function check( $session_name ) {
           return isset( $_SESSION[ $session_name ] ) ? 'is_set' : 'not_set';
        }

        /*
         * end_all function ends all currently running sessions.
         *
         * Returns -> ( none )
         *
         * Parameters
         * none
         */
        public static function end_all() {
            session_destroy();
        }

        /*
         * get_value function gets the current value stored in a particular session.
         * If the session is not set then it returns null.
         *
         * Returns -> ( value / null )
         *
         * Parameters
         * $session_name: string
         */
        public static function get_value( $session_name ) {
            if ( self::check( $session_name ) ) {
                return $_SESSION[ $session_name ];
            } else {
                return null;
            }
        }

        /*
         * is_login_session_valid function checks if otp_session( of 5 minutes ) created for a perticular user
         * is valid or not.
         *
         * Returns -> ( boolean )
         *
         * Parameters
         * none
         */
        public static function is_login_session_valid() {
            $user = new User;
            if ( $user->is_otp_valid() ) {
                return true;
            } else {
                return false;
            }
        }
    }