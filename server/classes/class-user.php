<?php
    require_once __DIR__ . '/class-database.php';
    require_once __DIR__ . '/class-constants.php';
    require_once __DIR__ . '/class-session.php';
    require_once __DIR__ . '/class-session.php';
    require_once __DIR__ . '/class-mailer.php';

    class User {
        private $db_connection;
        private $mailer;
        private $table;
        private $session_name;

        /**
         * The constructor of User class
         * - Creates a new database connection
         * - Gets the name of user table and stores it into $table variable
         * - Gets the session name and stores it into $session_name variable
         *
         * @return void
         */
        public function  __construct( ) {
            $db                  = new Database();
            $this->db_connection = $db->get_connection();
            $this->mailer        = new Mailer();
            $this->table         = Constants::get_user_table();
            $this->session_name  = Constants::get_otp_session_name();
        }

        /**
         * is_registered check if the user is already registered or not.
         *
         * @param string $email email address of the user.
         * @return bool true on success or false on failure.
         */
        private function is_registered( $email ) {
            $query = "SELECT * FROM {$this->table} WHERE email='$email'";
            $user  = $this->db_connection->query( $query );

            if ( $user->num_rows > 0 ) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * create_user creates a new user or updates existing user.
         *
         * @param string $email email address of the user.
         * @param int    $otp   otp send to the user.
         * @return string success string on success or failure string on failure.
         */
        private function create_user( $email, $otp ) {
            if ( $this->is_registered( $email ) ) {
                $query = "UPDATE {$this->table} SET last_otp = $otp, time = CURRENT_TIMESTAMP WHERE email='$email'";
            } else {
                $query = "INSERT INTO {$this->table} (email, last_otp) values ('$email', $otp)";
            }

            $data_saved = $this->db_connection->query( $query );

            if ( $data_saved ) {
                return 'success';
            } else {
                return 'failure';
            }
        }

        /**
         * is_otp_session_valid checks if the otp session is valid or not.
         *
         * @return bool true on success or false on failure.
         */
        public function is_otp_session_valid() {
            if ( Session::check( $this->session_name ) === 'is_set' && isset( $_SERVER['REQUEST_TIME'] ) ) {
                $timestamp         = $_SERVER['REQUEST_TIME'];
                $session_timestamp = Session::get_value( $this->session_name );

                if ( $timestamp - $session_timestamp < 300 ) {
                    return true;
                } else {
                    Session::end( $this->session_name );
                }
            }

            return false;
        }

        /**
         * send_verification_email send a verification email to the email address sent in the parameter.
         *
         * @param string $receiver user's email address.
         * @return string success string on success or failure string on failure.
         */
        public function send_verification_email( $receiver ) {
            $otp     = mt_rand( Constants::get_min_otp(), Constants::get_max_otp() );

            $mail_send = $this->mailer->send_confirmation_mail( $receiver, $otp );
            $creation  = $this->create_user( $receiver, $otp );

            if ( $mail_send === 'success' && $creation === 'success' && isset( $_SERVER['REQUEST_TIME'] ) ) {
                Session::start( $this->session_name, $_SERVER['REQUEST_TIME'] );
                return 'success';
            } else {
                return 'failure';
            }
        }

        /**
         * verify_otp verifies the otp entered by the user.
         *
         * @param string $email user's email address.
         * @param int    $otp   otp entered by the user.
         * @return string success string on success or failure string on failure.
         */
        public function verify_otp( $email, $otp ) {
            if ( $this->is_otp_session_valid() ) {
                $query    = "SELECT last_otp from {$this->table} where email='$email'";
                $rows     = $this->db_connection->query( $query );
                $send_otp = $rows->fetch_row()[0];

                if ( $rows->num_rows > 0 && $send_otp === $otp ) {
                    $query = 'UPDATE '
                        . $this->table .
                        " SET subscribed = 1, time = CURRENT_TIMESTAMP WHERE email='$email'";
                    $is_updated =  $this->db_connection->query( $query );

                    if ( $is_updated ) {
                        Session::end( $this->session_name );
                        return 'success';
                    }
                }
            }

            return 'failure';
        }

        /**
         * unsubscribe unsubscribes the mailing service if mailing service is availed by the user.
         *
         * @param  string $email user's email address.
         * @return string success string on success or failure string on failure.
         */
        public function unsubscribe( $email ) {
            $query      = "UPDATE {$this->table} SET subscribed = 0 WHERE email='$email'";
            $is_updated = $this->db_connection->query( $query );

            $query = "SELECT last_otp from {$this->table} where email='$email'";
            $rows  = $this->db_connection->query( $query );

            $is_user_valid = $rows->num_rows > 0;

            if ( $is_updated && $is_user_valid ) {
                return 'success';
            } else {
                return 'failure';
            }
        }
    }
?>