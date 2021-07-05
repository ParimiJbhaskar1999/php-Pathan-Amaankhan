<?php
    require_once dirname( __DIR__ ) . '/classes/class-apis.php';
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
    if ( isset( $_GET['number'] ) && filter_input( INPUT_GET, 'number', FILTER_VALIDATE_INT ) ) {
        $comic_number = (int) $_GET['number'];
        $api          = new Apis();
        $comic        = $api->get_comic( $comic_number );

        if ( isset ( $comic ) ) {
            $response = array(
                'success' => true,
                'comic'   => $comic,
                'message' => 'comic successfully retrieved.',
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Wrong Input',
            );
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Wrong Input.',
        );
    }

    echo json_encode( $response );
?>
