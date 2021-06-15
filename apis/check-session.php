<?php
    require_once dirname( __DIR__ ) . '/classes/class-session.php';
    require_once dirname( __DIR__ ) . '/classes/class-apis.php';
    require_once dirname( __DIR__ ) . '/headers.php';

    if ( Session::is_login_session_valid() ) {
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
