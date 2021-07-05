<?php
    require_once __DIR__ . '/class-templates.php';

    class Apis {
        /**
         * get_comic function fetches the comic info from xkcd.com.
         *
         * @param int $comic_number comic book's number, which is to be fetched.
         * @return mixed|string a json decoded object containing comic information on success or an error string on failure.
         */
        public function get_comic( $comic_number ) {
            $curl = curl_init();
            $url = "https://xkcd.com/$comic_number/info.0.json";
            curl_setopt( $curl, CURLOPT_URL, $url );
            curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

            $response = curl_exec( $curl );

            if ( curl_errno( $curl ) ) {
                return curl_error( $curl );
            } else {
                return json_decode( $response );
            }
        }

        /**
         * send_mail function sends email using sendgrid api.
         *
         * @param string         $receiver     email on which mail is to be send.
         * @param string         $subject      subject of the mail.
         * @param string         $body         body of the mail.
         * @param bool|null      $is_scheduled optional. when true sends the mail after 5 minutes. false.
         * @param string|null    $img_link     optional. when set image is attached to the mail. null.
         * @return string a success string on success or an error string on failure.
         */
        public function send_mail( $receiver, $subject, $body, $is_scheduled = false, $img_link = null ) {
            $curl = curl_init();
            $url = 'https://api.sendgrid.com/v3/mail/send';
            $key = Constants::get_mail_secret();

            curl_setopt( $curl, CURLOPT_URL, $url );
            curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $curl, CURLOPT_POST, 1 );

            $api_body = Templates::api_template( $receiver, $subject, $body, $is_scheduled, $img_link );

            curl_setopt( $curl, CURLOPT_POSTFIELDS, $api_body );

            $headers   = array();
            $headers[] = "Authorization: Bearer $key";
            $headers[] = 'Content-Type: application/json';

            curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
            curl_exec( $curl );

            if ( curl_errno( $curl ) ) {
                return curl_error( $curl );
            } else {
                return 'success';
            }
        }
    }
?>
