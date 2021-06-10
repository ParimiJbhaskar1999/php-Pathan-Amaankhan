<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php-Pathan-Amaankhan/classes/class-user.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/php-Pathan-Amaankhan/headers.php';

    if( isset( $_POST['email']  ) ) {
        $email       = $_POST['email'];
        $user        = new User( $email );
        $mail_send   = $user->send_verification_email();

        if( $mail_send === 'success' ) {
            $response = array(
                'success' => true,
                'message' => 'Email send successfully.',
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Email not send.',
            );
        }

    } else {
        $response = array(
            'success' => false,
            'message' => 'Missing required parameters',
        );
    }

    echo json_encode( $response );
?>
