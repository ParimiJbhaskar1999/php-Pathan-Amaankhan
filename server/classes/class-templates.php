<?php
    class Templates {
        /*
         * otp_mail_template gives the email's html template containing otp in it.
         *
         * Returns -> ( string )
         *
         * Parameters
         * $otp: integer
         */
        public static function otp_mail_template( $otp ) {
            $message = Constants::get_otp_mail_body( $otp );

            $template  = "<h1 style='text-align: center'>Comic Mailer</h1>";
            $template .= "<p style='text-align: center'>$message</p>";

            return $template;
        }

        /*
         * mail_template gives the email's html template containing comic and unsubscription link in it.
         *
         * Returns -> ( string )
         *
         * Parameters
         * $comic_number: integer
         * $heading     : string
         * $img_link    : string
         */
        public static function mail_template( $comic_number, $heading, $img_link ) {
            $url = Constants::get_web_link();
            $unsubscribe_link = "$url/app/unsubscribe";

            $template  = "<table style='width: 100%; border-collapse: separate; border-spacing: 0 1em;'>";
            $template .= "<tr><th><h1>$heading</h1></th></tr>";
            $template .= "<tr><td style='text-align: center;'><img src='$img_link' alt='$img_link'></td></tr>";
            $template .= "<tr><td style='text-align: center;'><a href='https://xkcd.com/$comic_number/'>";
            $template .= "<button ";
            $template .= "style='border-width: 0; ";
            $template .= "border-radius: 10px; ";
            $template .= "color: white; ";
            $template .= "background-color: deeppink; ";
            $template .= "padding: 1em; ";
            $template .= "box-shadow: 1px 1px 5px black; ";
            $template .= "font-size: 1em;'>";
            $template .= "Open In Browser";
            $template .= "</button>";
            $template .= "</a></td></tr>";
            $template .= "<tr><td style='text-align: center;'>";
            $template .= "<a style='font-size: 1em;' href='$unsubscribe_link'>Unsubscribe here</a>";
            $template .= "</td></tr>";
            $template .= "</table>";

            return $template;
        }

        /*
         * api_template gives the mail api template attaching users and other parameters in it.
         *
         * Returns -> ( string )
         *
         * Parameters
         * $to          : array( string )
         * $subject     : string
         * $body        : string
         * $is_scheduled: boolean
         * $ims_link    : string
         */
        public static function api_template( $to, $subject, $body, $is_scheduled = false, $img_link = null ) {
            $sender = Constants::get_sender_mail();

            $template  = '{"personalizations": [';

            foreach ( $to as $user ) {
                $template .= '{"to": [{"email": "';
                $template .= $user;
                $template .= '"}]';
                if ( $is_scheduled ) {
                    $template .= ',"send_at": ';
                    $template .= strtotime( '+5 minutes' );
                }
                $template .= '},';
            }

            $template  = rtrim( $template, ',' );
            $template .= '],';
            $template .= '"from": {"email": "';
            $template .= $sender;
            $template .= '"},"subject": "';
            $template .= $subject;
            $template .= '","content": [{"type": "';
            $template .= 'text/html';
            $template .= '","value": "';
            $template .= $body;
            $template .= '"}]';

            if ( isset( $img_link ) ) {
                $img = file_get_contents( $img_link );
                $data = base64_encode( $img );
                $template .= ',"attachments": [{"content": "';
                $template .= $data;
                $template .= '","type": "image/png","filename": "image.png"}]';
            }

            $template .= '}';

            return $template;
        }
    }
?>