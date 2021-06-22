<?php
    require_once __DIR__ . '/class-constants.php';

    class Database {
        private $connection;

        /*
         * A new connection is established in the constructor and stored in connection variable.
         *
         * Returns -> ( none )
         *
         * Parameters
         * none
         */
        public function __construct() {
            $this->connection = new mysqli(
                Constants::get_db_host(),
                Constants::get_db_user(),
                Constants::get_db_password(),
                Constants::get_db_name()
            );
        }

        /*
         * get_connection gives the instance of database if the connection in constructor was success else
         * gives the error.
         *
         * Returns -> ( mysqli Object )
         *
         * Parameters
         * none
         */
        public function get_connection() {
            return $this->connection->connect_error
                ? 'Connection Error: ' . $this->connection->connect_error
                : $this->connection;
        }
    }
?>