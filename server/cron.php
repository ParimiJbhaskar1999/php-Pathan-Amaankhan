<?php
    require_once __DIR__ . '/classes/class-mailer.php';

    // As heroku scheduler runs cron-job every 10 minutes, we are scheduling mail to achieve 5 minutes gap between mails.
    $mailer = new Mailer();
    $is_scheduled = false;                  // sending regular mail
    $mailer->send_mails( $is_scheduled );

    $is_scheduled = true;                  // sending scheduled mail( 5 minutes after the regular mail )
    $mailer->send_mails( $is_scheduled );
?>