<?php
    require_once dirname( __DIR__ ) . '/classes/class-session.php';
    require_once dirname( __DIR__ ) . '/classes/class-constants.php';
    require_once dirname( __DIR__ ) . '/headers.php';

    if( Session::check( Constants::get_otp_session_name() ) === 'is_set' ) {
        $response = array(
            'success' => true,
            'message' => 'Session is set.',
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Session is not set.',
        );
    }

    echo json_encode( $response );
?>
