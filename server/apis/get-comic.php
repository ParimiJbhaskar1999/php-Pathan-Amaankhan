<?php
    require_once dirname( __DIR__ ) . '/classes/class-user.php';
    require_once dirname( __DIR__ ) . '/headers.php';

    /**
     * get-comic api fetches the data of a particular comic number and returns it.
     *
     * Method Type:
     * GET
     *
     * @param int $_GET['number'] set the comic book's number.
     * @return string|false a JSON encoded string on success or FALSE on failure.
     */
    if ( isset( $_GET['number']  ) ) {
        $comic_number = $_GET['number'];
        $api          = new Apis();
        $comic        = $api->get_comic( $comic_number );

        $response = array(
            'success' => true,
            'comic'   => $comic,
            'message' => 'comic successfully retrieved.',
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Missing required parameters',
        );
    }

    echo json_encode( $response );
?>
