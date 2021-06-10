<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php-Pathan-Amaankhan/classes/class-session.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php-Pathan-Amaankhan/classes/class-constants.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/php-Pathan-Amaankhan/headers.php';

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
