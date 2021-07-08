<?php
    require_once __DIR__ . '/classes/class-mailer.php';
    require_once __DIR__ . '/classes/class-constants.php';

    // Checking if difference between the cron ran last time and now is greater than or equals to 10 minutes.
    if ( strtotime( 'now' ) - Constants::get_cron_last_ran_time()  >= 600 ) {

        // It will run cron-job only if we have successfully saved the run time.
        if ( Constants::set_cron_last_ran_time( strtotime( 'now' ) ) === 'success' ) {

            // As heroku scheduler runs cron-job every 10 minutes, we are scheduling mail to achieve 5 minutes gap between mails.
            $mailer = new Mailer();

            $is_scheduled = false;                  // sending regular mail
            $mailer->send_mails( $is_scheduled );

            $is_scheduled = true;                  // sending scheduled mail( 5 minutes after the regular mail )
            $mailer->send_mails( $is_scheduled );

        }

    }
?>