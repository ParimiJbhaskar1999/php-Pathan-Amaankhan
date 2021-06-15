<?php
    require_once __DIR__ . '/class-database.php';
    require_once __DIR__ . '/class-apis.php';

    class Mailer {
        private $table;
        private $db_connection;

        public function __construct() {
            $db                  = new Database();
            $this->db_connection = $db->get_connection();
            $this->table         = Constants::get_user_table();
        }

        private function mail_body( $comic_number, $email, $heading, $img_link ) {
            $unsubscribe_link = "https://localhost/php-Pathan-Amaankhan/apis/unsubscribe.php?email=$email";

            $mail_body  = '<!doctype html>';
            $mail_body .= '<html lang="en">';
            $mail_body .= '<head>
                               <meta charset="UTF-8">
                               <meta name="viewport"
                                     content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                               <meta http-equiv="X-UA-Compatible" content="ie=edge">
                               <title>Comic Mailer</title>
                               <style>
                                   .btn-style {
                                       border-width: 0; 
                                       border-radius: 10px; 
                                       color: white; 
                                       background-color: deeppink; 
                                       padding: 1em;
                                       box-shadow: 1px 1px 5px black;
                                   }
                                   
                                   .cntr {
                                       text-align: center;
                                   }
                                   
                                   .cnst-font {
                                       font-size: 1em;
                                   }                   
                               </style>
                           </head>';
            $mail_body .= '<body>';
            $mail_body .= '<table  style="width: 100%; border-collapse: separate; border-spacing: 0 1em;">';
            $mail_body .= "<tr>
                               <th><h1>$heading</h1></th>
                           </tr>";
            $mail_body .= "<tr>
                               <td class='cntr'>
                                   <img src='$img_link' alt='$img_link'>
                               </td>
                           </tr>";
            $mail_body .= "<tr>
                               <td class='cntr'>
                                   <a href='https://xkcd.com/$comic_number/'>
                                       <button class='btn-style cnst-font'>Open In Browser</button>
                                   </a>
                               </td>
                           </tr>";
            $mail_body .= "<tr>
                               <td class='cntr'>
                                   <a class='cnst-font' href='$unsubscribe_link'>
                                       Unsubscribe here
                                   </a>
                               </td>
                           </tr>";
            $mail_body .= '</table>';
            $mail_body .= '</body>';
            $mail_body .= '</html>';

            return $mail_body;
        }

        public static function send_confirmation_mail( $to, $otp ) {
            $subject = Constants::get_cnf_mail_subject();
            $message = Constants::get_cnf_mail_body( $otp );

            if ( mail( $to, $subject, $message ) ) {
                return 'success';
            } else {
                return 'failure';
            }
        }

        public function send_mails() {
            $headers = Constants::get_mail_headers();

            $query = "SELECT email FROM {$this->table} WHERE subscribed=1";
            $rows  = $this->db_connection->query( $query );
            $users = call_user_func_array('array_merge', $rows->fetch_all() );

            $comic_number = mt_rand( Constants::get_min_comic_no(), Constants::get_max_comic_no() );

            $api     = new Apis();
            $comic   = $api->get_comic( $comic_number );
            $subject = "Comic Number $comic_number";

            foreach ($users as $user) {
                $message = $this->mail_body( $comic_number, $user, $comic->title, $comic->img );
                mail( $user, $subject, $message, $headers );
            }
        }

        public function __destruct() {
            $this->db_connection->close();
        }
    }
?>
