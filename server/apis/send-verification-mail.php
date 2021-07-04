<?php
    require_once dirname( __DIR__ ) . '/classes/class-user.php';
    require_once dirname( __DIR__ ) . '/headers.php';

    /**
     * send-verification-mail api sends the verification mail to the mail provided in the request body.
     *
     * Method Type:
     * POST
     *
     * @param string $_POST['email'] set the user's email.
     * @return string|false a JSON encoded string on success or FALSE on failure.
     */
    if ( isset( $_POST['email']  ) ) {
        $email       = $_POST['email'];
        $user        = new User();
        $mail_send   = $user->send_verification_email( $email );

        if ( $mail_send === 'success' ) {
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
