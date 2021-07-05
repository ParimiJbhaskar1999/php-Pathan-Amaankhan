<?php
    require_once dirname( __DIR__ ) . '/classes/class-apis.php';
    require_once dirname( __DIR__ ) . '/headers.php';

    /**
     * get-max-comic-number api fetches maximum number of comic which is out till today.
     *
     * Method Type:
     * GET
     *
     * @return string|false a JSON encoded string on success or FALSE on failure.
     */
    $api          = new Apis();
    $comic_number = $api->get_max_comic_no();

    if ( isset ( $comic_number ) && $comic_number > 0 ) {
        $response = array(
            'success'      => true,
            'comic_number' => $comic_number,
            'message'      => 'comic number successfully retrieved.',
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'error while retrieving the comic number.',
        );
    }

    echo json_encode( $response );
?>
