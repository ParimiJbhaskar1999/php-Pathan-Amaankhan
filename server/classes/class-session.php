<?php
    require_once __DIR__ . '/class-user.php';

    Class Session {
        /**
         * start function starts a new session with the name and value provided in the parameters.
         *
         * @param string $session_name  set the name of session.
         * @param mixed  $session_value set the value stored in perticular session.
         * @return void
         */
        public static function start( $session_name, $session_value ) {
            $_SESSION[ $session_name ] = $session_value;
        }

        /**
         * end function ends the running session.
         *
         * @param string $session_name name of the session which needs to be deleted.
         * @return void
         */
        public static function end( $session_name ) {
            unset( $_SESSION[ $session_name ] );
        }

        /**
         * check function checks if the session is set or not.
         *
         * @param string $session_name name of the session whose status is to be checked.
         * @return string is_set when session is set or not_set when session is not set.
         */
        public static function check( $session_name ) {
           return isset( $_SESSION[ $session_name ] ) ? 'is_set' : 'not_set';
        }

        /**
         * end_all function ends all currently running sessions.
         *
         * @return void
         */
        public static function end_all() {
            session_destroy();
        }

        /**
         * get_value function gets the current value stored in a particular session.
         * If the session is not set then it returns null.
         *
         * @param string $session_name session's name, whose value is to be fetched.
         * @return Session|null a session object on success or null on failure.
         */
        public static function get_value( $session_name ) {
            if ( self::check( $session_name ) ) {
                return $_SESSION[ $session_name ];
            } else {
                return null;
            }
        }

        /**
         * is_login_session_valid function checks if otp_session( of 5 minutes ) created for a perticular user
         * is valid or not.
         *
         * @return bool true on success or false on failure.
         */
        public static function is_login_session_valid() {
            $user = new User;
            if ( $user->is_otp_session_valid() ) {
                return true;
            } else {
                return false;
            }
        }
    }