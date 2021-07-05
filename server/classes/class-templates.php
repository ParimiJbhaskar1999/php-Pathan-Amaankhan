<?php
    class Templates {
        /**
         * otp_mail_template gives the email's html template containing otp in it.
         *
         * @param int $otp otp which is to be set inside the template.
         * @return string template of mail containing otp.
         */
        public static function otp_mail_template( $otp ) {
            $message = Constants::get_otp_mail_body( $otp );

            $template  = '<h1 style=\'text-align: center\'>Comic Mailer</h1>';
            $template .= "<p style='text-align: center'>$message</p>";

            return $template;
        }

        /**
         * mail_template gives the email's html template containing comic and unsubscription link in it.
         *
         * @param int    $comic_number comic book's number.
         * @param string $heading      heading of the mail(comic's name).
         * @param string $img_link     link of the comic's image.
         * @param string $token        unique token assign to each user which is used for unsubscribe
         * @return string template of mail containing comic.
         */
        public static function mail_template( $comic_number, $heading, $img_link, $token ) {
            $url = Constants::get_web_link();
            $unsubscribe_link = "$url/app/unsubscribe?token=$token";

            $template  = '<table style=\'width: 100%; border-collapse: separate; border-spacing: 0 1em;\'>';
            $template .= "<tr><th><h1>$heading</h1></th></tr>";
            $template .= "<tr><td style='text-align: center;'><img src='$img_link' alt='$img_link'></td></tr>";
            $template .= "<tr><td style='text-align: center;'><a href='https://xkcd.com/$comic_number/'>";
            $template .= '<button ';
            $template .= 'style=\'border-width: 0; ';
            $template .= 'border-radius: 10px; ';
            $template .= 'color: white; ';
            $template .= 'background-color: deeppink; ';
            $template .= 'padding: 1em; ';
            $template .= 'box-shadow: 1px 1px 5px black; ';
            $template .= 'font-size: 1em;\'>';
            $template .= 'Open In Browser';
            $template .= '</button>';
            $template .= '</a></td></tr>';
            $template .= '<tr><td style=\'text-align: center;\'>';
            $template .= "<a style='font-size: 1em;' href='$unsubscribe_link'>Unsubscribe here</a>";
            $template .= '</td></tr>';
            $template .= '</table>';

            return $template;
        }

        /**
         * api_template gives the mail api template attaching users and other parameters in it.
         *
         * @param string         $receiver     email on which mail is to be send.
         * @param string         $subject      subject of the mail.
         * @param string         $body         body of the mail.
         * @param bool|null      $is_scheduled optional. when true sends the mail after 5 minutes. Default false.
         * @param string|null    $img_link     optional. when set image is attached to the mail. Default null.
         * @return string template of mail sending api.
         */
        public static function api_template( $receiver, $subject, $body, $is_scheduled = false, $img_link = null ) {
            $sender = Constants::get_sender_mail();

            $template  = '{"personalizations": [';

            $template .= '{"to": [{"email": "';
            $template .= $receiver;
            $template .= '"}]';
            if ( $is_scheduled ) {
                $template .= ',"send_at": ';
                $template .= strtotime( '+5 minutes' );
            }
            $template .= '},';

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