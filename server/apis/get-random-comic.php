<?php
    require_once dirname( __DIR__ ) . '/classes/class-apis.php';
    require_once dirname( __DIR__ ) . '/headers.php';

    /**
     * get-random-comic api fetches the data of a random comic.
     *
     * Method Type:
     * GET
     *
     * @return string|false a JSON encoded string on success or FALSE on failure.
     */
    $api   = new Apis();
    $comic = $api->get_random_comic();

    if ( isset ( $comic ) ) {
        $response = array(
            'success' => true,
            'comic'   => $comic,
            'message' => 'comic successfully retrieved.',
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'error while retrieving the comic.',
        );
    }

    echo json_encode( $response );
?>
