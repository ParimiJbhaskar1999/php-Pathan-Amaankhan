<?php
    require_once dirname( __DIR__ ) . '/classes/class-user.php';

    /**
     * unsubscribe api unsubscribes the user from the mail service if the service is availed.
     *
     * Method Type:
     * POST
     *
     * @param string $_POST['email'] set the user's email.
     * @return string|false a JSON encoded string on success or FALSE on failure.
     */
    if ( isset( $_POST['email'] ) ) {
        $email = (string) $_POST['email'];
        $user  = new User();

        if ( $user->unsubscribe( $email ) === 'success' ) {
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
            'message' => 'Missing required parameter.',
        );
    }

    echo json_encode( $response );
?>
