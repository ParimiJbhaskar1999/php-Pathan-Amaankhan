<?php
    class Database {
        private $connection;

        public function __construct() {
            $this->connection = new mysqli(
                Constants::get_db_host(),
                Constants::get_db_user(),
                Constants::get_db_password(),
                Constants::get_db_name()
            );
        }

        public function get_connection() {
            return $this->connection->connect_error
                ? 'Connection Error: ' . $this->connection->connect_error
                : $this->connection;
        }
    }
?>