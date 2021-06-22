<?php
    require_once dirname( __DIR__ ) . '/classes/class-user.php';

    /*
     * unsubscribe api unsubscribes the user from the mail service if the service is availed.
     *
     * Returns -> ( Json Object )
     *
     * Method Type:
     * POST
     *
     * Parameters
     * email: string
     */
    if ( isset( $_POST['email']  ) ) {
        $email = $_POST['email'];
        $user = new User();

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
