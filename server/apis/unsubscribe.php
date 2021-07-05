<?php
    require_once dirname( __DIR__ ) . '/classes/class-user.php';

    /**
     * unsubscribe api unsubscribes the user from the mail service if the service is availed.
     *
     * Method Type:
     * POST
     *
     * @param string $_POST['token'] user's token.
     * @return string|false a JSON encoded string on success or FALSE on failure.
     */
    if ( isset( $_POST['token'] ) ) {
        $token = (string) $_POST['token'];
        $user  = new User();

        if ( $user->unsubscribe( $token ) === 'success' ) {
            $response = array(
                'success' => true,
                'message' => 'Service unsubscribed successfully.',
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Unsubscribing failed please try again latter.',
            );
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Missing required parameters.',
        );
    }

    echo json_encode( $response );
?>
