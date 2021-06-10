<?php
    require_once __DIR__ . '/class-database.php';
    require_once __DIR__ . '/class-constants.php';
    require_once __DIR__ . '/class-session.php';
    require_once __DIR__ . '/class-session.php';

    class User {
        private $email;
        private $db_connection;
        private $table;
        private $session_name;

        public function  __construct( $email ) {
            $this->email         = $email;
            $db                  = new Database();
            $this->db_connection = $db->get_connection();
            $this->table         = Constants::get_user_table();
            $this->session_name  = Constants::get_otp_session_name();
        }

        private function is_registered( $email ) {
            $query = "SELECT * FROM " . $this->table . " WHERE email='$email'";
            $user  = $this->db_connection->query( $query );

            if( $user->num_rows > 0 ) {
                return true;
            } else {
                return false;
            }
        }

        private function create_user( $email, $otp ) {
            if( $this->is_registered( $email ) ) {
                $query = "UPDATE " . $this->table . " SET last_otp = $otp, time = CURRENT_TIMESTAMP WHERE email='$email'";
            } else {
                $query = "INSERT INTO " . $this->table . " (email, last_otp) values ('$email', $otp)";
            }

            $data_saved = $this->db_connection->query( $query );

            if( $data_saved ) {
                return 'success';
            } else {
                return 'failure';
            }
        }

        public function send_verification_email() {
            $email   = $this->email;
            $subject = 'Email Verification for Comic Mailer';
            $otp     = mt_rand( 1111, 9999 );
            $message = "The OTP for Comic Mailer is $otp.";

            $mail_send = mail( $email, $subject, $message );
            $creation  = $this->create_user( $email, $otp );

            if( $mail_send && $creation === 'success' && isset( $_SERVER['REQUEST_TIME'] ) ) {
                Session::start( $this->session_name, $_SERVER['REQUEST_TIME'] );
                return 'success';
            } else {
                return 'failure';
            }
        }

        public function verify_otp( $email, $otp ) {
            if( Session::check( $this->session_name ) === 'is_set' && isset( $_SERVER['REQUEST_TIME'] ) ) {
                $timestamp         =  $_SERVER['REQUEST_TIME'];
                $session_timestamp = Session::get_value( $this->session_name );

                if( $timestamp - $session_timestamp < 300 ) {
                    $query    = "SELECT last_otp from " . $this->table . " where email='$email'";
                    $rows     = $this->db_connection->query( $query );
                    $send_otp = $rows->fetch_row()[0];

                    if( $rows->num_rows > 0 && $send_otp === $otp ) {
                        $query = "UPDATE "
                            . $this->table .
                            " SET subscribed = 1, time = CURRENT_TIMESTAMP WHERE email='$email'";
                        $is_updated =  $this->db_connection->query( $query );

                        if( $is_updated ) {
                            Session::end( $this->session_name );
                            return 'success';
                        }
                    }
                } else {
                    Session::end( $this->session_name );
                }
            }

            return 'failure';
        }
    }
?>