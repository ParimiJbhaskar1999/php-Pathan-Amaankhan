<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php-Pathan-Amaankhan/classes/class-user.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/php-Pathan-Amaankhan/headers.php';

    if( isset( $_POST['email']  ) && isset( $_POST['otp'] ) ) {
        $email       = $_POST['email'];
        $otp         = $_POST['otp'];
        $user = new User( $email );
        $verified    = $user->verify_otp( $email, $otp );

        if( $verified === 'success' ) {
            $response = array(
                'success' => true,
                'message' => 'Verified successfully.',
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Verification failed.',
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
