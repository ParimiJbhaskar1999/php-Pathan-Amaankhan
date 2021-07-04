<?php
    require_once dirname( __DIR__ ) . '/classes/class-session.php';
    require_once dirname( __DIR__ ) . '/headers.php';

    /**
     * check-session api checks if the user's otp session is valid or not.
     *
     * Method Type:
     * GET
     *
     * @return string|false a JSON encoded string on success or FALSE on failure.
     */
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
