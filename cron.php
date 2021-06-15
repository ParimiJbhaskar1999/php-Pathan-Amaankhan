<?php
    require_once __DIR__ . '/classes/class-mailer.php';

    $mailer = new Mailer();
    $mailer->send_mails();
?>