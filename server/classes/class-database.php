<?php
    require_once __DIR__ . '/class-constants.php';

    class Database {
        private $connection;

        /**
         * A new connection is established in the constructor and stored in connection variable.
         *
         * @return void
         */
        public function __construct() {
            $this->connection = new mysqli(
                Constants::get_db_host(),
                Constants::get_db_user(),
                Constants::get_db_password(),
                Constants::get_db_name()
            );
        }

        /**
         * get_connection gives the instance of database if the connection in constructor was success else
         * gives the error.
         *
         * @return mysqli|string a mysqli connection on success or error string on failure.
         */
        public function get_connection() {
            return $this->connection->connect_error
                ? 'Connection Error: ' . $this->connection->connect_error
                : $this->connection;
        }

        /**
         * get_cron_last_ran_time gives the time at which cron-job was last ran.
         *
         * @return int current time on failure or last ran time on success.
         */
        public function get_cron_last_ran_time() {
            $query           = 'SELECT cron_last_ran FROM cron_table where id = 1';
            $cron_last_ran   = strtotime( 'now' );
            $result          = $this->connection->query( $query );

            if ( $result->num_rows > 0 ) {
                $row           = $result->fetch_assoc();
                $cron_last_ran = (int) $row['cron_last_ran'];
            }

            return $cron_last_ran;
        }

        /**
         * set_cron_last_ran_time sets the time at which cron-job was ran.
         *
         * @param $time int time at which cron-job is ran.
         * @return string success string on success and failure string on failure.
         */
        public function set_cron_last_ran_time( $time ) {
            $query = 'UPDATE cron_table SET cron_last_ran = ? WHERE id = 1';
            $stmt  = $this->connection->prepare( $query );

            $stmt->bind_param( 'i', $time );
            $data_saved = $stmt->execute();

            if ( $data_saved ) {
                return 'success';
            } else {
                return 'failure';
            }
        }
    }
?>