<?php
    require_once dirname( __DIR__ ) . '/classes/class-user.php';
    require_once dirname( __DIR__ ) . '/headers.php';

    /**
     * verify-otp api verifies the otp entered by the user.
     *
     * Method Type:
     * POST
     *
     * @param string $_POST['email'] set the user's email.
     * @param int    $_POST['otp']   set the user entered otp.
     * @return string|false a JSON encoded string on success or FALSE on failure.
     */
    if ( isset( $_POST['email']  ) && isset( $_POST['otp'] ) ) {
        $email       = $_POST['email'];
        $otp         = $_POST['otp'];
        $user        = new User();
        $verified    = $user->verify_otp( $email, $otp );

        if ( $verified === 'success' ) {
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
