<?php
    class Apis {
        private $curl;

        public function __construct() {
            $this->curl = curl_init();
        }

        public function get_comic( $comic_number ) {
            $url = "https://xkcd.com/$comic_number/info.0.json";
            curl_setopt( $this->curl, CURLOPT_URL, $url );
            curl_setopt( $this->curl, CURLOPT_RETURNTRANSFER, true );

            $response = curl_exec( $this->curl );
            $error    = curl_error( $this->curl );

            if ( ! empty( $error )  ) {
                return $error;
            } else {
                return json_decode( $response );
            }
        }

        public function __destruct() {
            curl_close( $this->curl );
        }
    }
?>
