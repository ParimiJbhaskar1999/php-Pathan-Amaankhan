<?php
    require_once __DIR__ . '/class-database.php';
    require_once __DIR__ . '/class-apis.php';

    class Mailer {
        private $api;
        private $table;
        private $db_connection;

        /**
         * The constructor of Mailer class
         * - Creates a new connection to database using the instance of Database class stores in $db variable.
         * - Creates the instance of Apis class and stores it into $api variable.
         * - Gets the name of users table and stores it into $table variable.
         *
         * @return void
         */
        public function __construct() {
            $db                  = new Database();
            $this->db_connection = $db->get_connection();
            $this->api           = new Apis();
            $this->table         = Constants::get_user_table();
        }

        /**
         * send_confirmation_mail sends the otp to the user provided in the parameters.
         *
         * @param string $to  set the receiver's mail address.
         * @param int    $otp set the otp for the otp in mail body.
         * @return string success string on success or failure string on failure.
         */
        public function send_confirmation_mail( $to, $otp ) {
            $subject = Constants::get_otp_mail_subject();
            $message = Templates::otp_mail_template( $otp );

            $response = $this->api->send_mail( $to, $subject, $message );

            if ( $response === 'success' ) {
                return 'success';
            } else {
                return 'failure';
            }
        }

        /**
         * send_mails sends the mail containing comic in it after 5 minutes or at the same time
         * as per the information provided in the parameter.
         *
         * @param bool|null $is_scheduled optional. when true mail is send after 5 minutes. false.
         * @return void
         */
        public function send_mails( $is_scheduled = false ) {
            $query = "SELECT email, token FROM {$this->table} WHERE subscribed = 1 AND token IS NOT NULL";
            $rows  = $this->db_connection->query( $query );

            if ( $rows->num_rows > 0 ) {
                $comic_number = mt_rand( Constants::get_min_comic_no(), Constants::get_max_comic_no() );
                $comic        = $this->api->get_comic( $comic_number );

                if ( isset( $comic->title ) ) {
                    $subject = "Comic Number $comic_number";
                    $user    = $rows->fetch_assoc();

                    while ( $user ) {
                        $message    = Templates::mail_template( $comic_number, $comic->title, $comic->img, $user['token'] );
                        $this->api->send_mail( $user['email'], $subject, $message, $is_scheduled, $comic->img );
                        $user = $rows->fetch_assoc();
                    }
                }
            }
        }
    }
?>
